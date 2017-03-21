<?php

    namespace classes\calculation\client\controller\pkv;

    use Application\Service\FeedbackService;
    use shared\classes\calculation\client AS shared_client;
    use Zend\Http\Header\SetCookie;

    /**
     * Result power render class
     *
     * @author Tobias Albrecht, Stefan Becker
     * @copyright rapidsoft GmbH
     * @version 1.0
     */
    class tariff_detail extends shared_client\controller\base {

        /**
         * Run
         *
         * @return shared_client\controllerstatus
         */
        public function run() {

            $status = '';
            $output = '';

            if (!isset($this->parameters['c24api_calculationparameter_id']) || !isset($this->parameters['c24api_tariffversion_id']) || !isset($this->parameters['c24api_tariffversion_variation_key'])) {
                $status = shared_client\controllerstatus::FORM_ERROR;
            } else {

                $models = $this->get_client()->get_calculation_models(
                    get_def('product_id'),
                    [
                        'c24api_calculationparameter_id' => $this->parameters['c24api_calculationparameter_id'],
                        'c24api_tariffversion_variation_key' => $this->parameters['c24api_tariffversion_variation_key'],
                        'c24api_tariffversion_ids' => $this->parameters['c24api_tariffversion_id'],
                        'c24api_ignore_filter' => 'yes'
                    ]
                );

                $tariff = NULL;

                if (empty($models['result'])) {

                    $status = shared_client\controllerstatus::FORM_SUCCESS;

                    $view = $this->create_view();
                    $view->form_link = $this->get_client()->get_link('form');

                    $output['result'] = $view->render('pv/error.php');
                    $output['filter'] = '';
                    $output['footer'] = '';
                    $output['head'] = '';
                    $output['back_link'] = $this->get_client()->get_link('result', array('c24api_calculationparameter_id' => $this->parameters['c24api_calculationparameter_id']));
                    $output['head_title'] = 'Details zum' . "\n" . 'ausgewählten Tarif';

                } else {

                    $tariff = $models['result'][0];

                    $calculationparameter = $this->get_client()->get_calculationparameter(get_def('product_id'), $this->parameters['c24api_calculationparameter_id']);

                    $status = shared_client\controllerstatus::FORM_SUCCESS;

                    $view = $this->create_view();

                    $view->tariff_history = $this->update_tariff_history($this->parameters, $tariff);
                    $view->tariff = $tariff;
                    $view->parameter = $models['parameter'];
                    $view->feature = $tariff->get_tariff_feature();
                    $view->tariff_detail_link = $this->get_client()->get_link('tariff_detail');
                    $view->customerfeedback = [];

                    if ($tariff->get_subscription_external() == '') {

                        $subscription_url_parameter = array(
                            'c24api_product_id' => $tariff->get_tariff_product_id(),
                            'c24api_calculationparameter_id' => $view->parameter->get_id(),
                            'c24api_tariffversion_id' => $tariff->get_tariff_version_id(),
                            'c24api_tariffversion_variation_key' => $tariff->get_tariff_variation_key()
                        );

                        $link = $this->get_client()->get_link('register_link');
                        $parts = explode('?', $link);

                        $view->subscription_url = $parts[0] . implode('/', $subscription_url_parameter) . '/';

                        if (isset($parts[1])) {
                            $view->subscription_url .= '?' . $parts[1];
                        }

                    } else {
                        $view->subscription_url = $tariff->get_subscription_external();
                    }

                    $back_link_param = [
                        'c24api_calculationparameter_id' => $calculationparameter->get_id(),
                        'c24api_birthdate' => $calculationparameter->get_birthdate(),
                        'c24api_paymentperiod' => $calculationparameter->get_paymentperiod(),
                        'c24api_insure_date' => $calculationparameter->get_insure_date()
                    ];

                    $output['filter'] = '';
                    $output['footer'] = '';
                    $output['head'] = '';
                    $output['result'] = $view->render('default/pkv/tariffdetail.php');
                    $output['back_link'] = $this->get_client()->get_link('result', $back_link_param);
                    $output['head_title'] = 'Details zum' . "\n" . 'ausgewählten Tarif';

                }

            }

            return new shared_client\controllerstatus($status, $output);

        }

        /**
         * Update the history of seen Tariffs.
         *
         * @param array $parameters       The Get parameters
         * @param object $tariff           The current Tariff
         *
         * @return array|mixed
         */
        private function update_tariff_history(array$parameters, $tariff) {

            $tariff_history = [];
            $old_tariff_history = [];

            if (isset($_COOKIE['tariff_history'])) {
                $tariff_history = $old_tariff_history = unserialize($_COOKIE['tariff_history']);
            }

            $link = $this->get_client()->get_link('tariff_detail');

            $link .= '&c24api_calculationparameter_id=' . $parameters['c24api_calculationparameter_id']
                    . '&c24api_tariffversion_id=' . $parameters['c24api_tariffversion_id']
                    . '&c24api_tariffversion_variation_key=' . $parameters['c24api_tariffversion_variation_key']
                    . '&c24api_product_id=' . $tariff->get_tariff_product_id();

            $tariff_history[$parameters['c24api_tariffversion_variation_key']] = [
                'calculationparameter_id'       => $parameters['c24api_calculationparameter_id'],
                'tariffversion_id'              => $parameters['c24api_tariffversion_id'],
                'tariffversion_variation_key'   => $parameters['c24api_tariffversion_variation_key'],
                'logo' => $tariff->get_provider_logo(),
                'link' => $link
            ];

            if ($tariff_history != $old_tariff_history) {

                if (count($old_tariff_history) >= 4) {
                    array_shift($tariff_history);
                }

                $this->getServiceLocator()->get('Response')->getHeaders()->addHeader(
                    new SetCookie('tariff_history', serialize($tariff_history), time() + 3600)
                );

            }

            return $tariff_history;

        }

    }
