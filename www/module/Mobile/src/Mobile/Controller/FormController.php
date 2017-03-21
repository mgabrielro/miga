<?php

namespace Mobile\Controller;

use Common\Controller\BaseController;
use shared\classes\calculation\client\controllerstatus;
use Zend\View\Model\ViewModel;

/**
 * Class IndexController
 *
 * !! NOT USED !!
 *
 * @deprecated
 * @package Mobile\Controller
 * @author Robert Eichholtz <robert.eichholtz@check24.de>
 */
class FormController extends RisikolebenController
{
    /**
     * Login user
     *
     * @return \Zend\Http\Response
     */
    public function indexAction()
    {
        /** @var \Zend\Http\Request $request */
        $request = $this->getRequest();

        /** @var \Zend\Config\Config $c24Config */
        $c24Config = $this->getServiceLocator()->get('ZendConfig')->check24;

        // Referrer
        $this->handleReferrer($request);

        // set generic layout variables
        $this->assignGenericParameter();

        // C24login
        $this->assign('c24login', $this->get('C24Login'));

        // CS Code
        $this->assignCouponCode($this->product_id);

        /** @var \classes\calculation\mclient\client $client */
        $client = $this->get_client($this->product_id);

        $client->set_force_current_timepoint('yes');
        $client->set_stats('yes');

        $this->layout()->client = $client;

        // Load PLZ by logged user as proposal by search
        // @TODO City autocomplete not realized. User can not search without field 'city'

        if (empty($request->getQuery('c24api_zipcode')) && $request->getCookie() && $request->getCookie()->offsetExists('c24session')) {
            $request->setQuery('c24api_zipcode', $this->getServiceLocator()->get('C24Login')->get_zipcode($request->getCookie()->c24session));
        }

        $api_content = $client->handle_controller_pkv($request);

        $assign = array();

        $defs = $c24Config->defs;

        if (is_string($api_content)) {

            $this->layout()->back_link = $this->get_protocol() . '://m.check24.de/';

            $assign['result'] = $api_content;

            $this->layout()->page_title = $defs->products->{$this->product_id}->form_title;
            $this->layout()->page_description = '';

        } else {

            $calculationparameter_id = '';
            $match = array();

            if (!empty($api_content['back_link'])) {

                if (preg_match('/([\dabcdef]{32})/', $api_content['back_link'], $match) > 0) {
                    $calculationparameter_id = $match[1];
                }

            }

            if ($calculationparameter_id == '') {

                if (preg_match('/([\dabcdef]{32})/', $api_content['result'], $match) > 0) {
                    $calculationparameter_id = $match[1];
                }

            }

            if ($request->getQuery('c24_paging') == 'yes') {

                $this->layout()->status = 'OK';
                $this->layout()->json_content = $api_content['result'];
                $this->layout()->message = '';

                $this->layout('layout/json.phtml');

            } else {

                $assign['result_head'] = $api_content['head'];
                $assign['result_header_filter'] = $api_content['filter'];
                $assign['result'] = $api_content['result'];
                $assign['result_footer'] = $api_content['footer'];
                $this->layout()->back_link = $api_content['back_link'];
                $this->layout()->ssl = $this->get_protocol();

                if (!empty($api_content['head_title'])) {
                    $this->layout()->head_title = $api_content['head_title'];
                }


                $this->layout()->page_title       = $defs->products->{$this->product_id}->form_title;
                $this->layout()->page_description = $defs->products->{$this->product_id}->form_desc;

            }

        }

        if ($request->getQuery('c24_controller')) {

            #$this->layout()->result_css = $this->get_css('massets/css/common/');
            #$this->layout()->result_css .= $this->get_css('massets/css/tariff_detail/');

            switch ($request->getQuery('c24_controller')) {

                case 'form':
                    $this->layout()->js .= file_get_contents($c24Config->document_root . '/massets/js/includes/form.js', true);
                    $this->layout()->result_css .= $this->get_css('massets/css/result/');
                    break;

                case 'result' :
                    $this->layout()->js .= file_get_contents($c24Config->document_root . '/massets/js/includes/result.js', true);
                    $this->layout()->result_css = $this->get_css('massets/css/result/');
                    break;

                case 'tariff_detail':
                    $this->layout()->js = file_get_contents($c24Config->document_root . '/massets/js/includes/tariff_detail.js', true);
                    $this->layout()->tariff_detail_css = $this->get_css('massets/css/tariff_detail/');
                    break;

            }

        } else {
            $this->layout()->js .= file_get_contents($c24Config->document_root . '/massets/js/includes/form.js', true);
        }

        $assign['generaltracking'] = $this->getGeneralTracking(10);

        $this->layout()->common_css = $this->get_css('massets/css/common/');
        #$this->layout()->ajax_occupation_name_link = $this->get_client($this->product_id)->get_link('ajax/json', array('action' => 'occupation_name'));

        return $assign;
    }
}