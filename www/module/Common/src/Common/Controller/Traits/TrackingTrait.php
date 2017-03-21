<?php

namespace Common\Controller\Traits;

use classes\tracking\generaltracking;

/**
 * trait TrackingTrait
 *
 * @package Common\Controller\Traits
 * @author Robert Eichholtz <robert.eichholtz@check24.de>
 */
trait TrackingTrait
{
    /**
     * @param int $product_id
     *
     * @return \stdClass
     */
    protected function getGeneralTracking($product_id = 10)
    {
        $generaltracking = new \stdClass();
        $generaltracking->pixel  = $this->generateGeneralTrackingPixel($product_id);
        $generaltracking->action = $this->generateGeneralTrackingAction($this->getProductId());
        return $generaltracking;
    }

    /**
     * Generate general tracking action pixel
     *
     * @param integer $product_id Product id
     * @param string $area_id Area id
     * @param string $subscriptiontype Subscriptiontype (offer or expert)
     * @return generaltracking
     */
    public function generateGeneralTrackingAction($product_id, $area_id = '', $subscriptiontype = null) {
        return $this->generateGeneralTrackingPixel($product_id, $area_id, null, $subscriptiontype);
    }

    /**
     * Generate general tracking pixel
     *
     * @param integer $product_id Product id
     * @param string $area_id Area Id
     * @param string $action_id Action Id
     * @param string $subscriptiontype Subscriptiontype (offer or expert)
     * @return generaltracking
     */
    public function generateGeneralTrackingPixel($product_id, $area_id = '', $action_id = null, $subscriptiontype = null)
    {
        $client = $this->getCalculationClient($product_id);

        if (!$area_id) {

            /** @var \Zend\Stdlib\Parameters $query */
            $query = $this->getRequest()->getQuery();

            // Default area is just input1
            $area_id = 'input1';

            if ($query->offsetExists('c24_calculate') && !empty($query->get('c24api_calculationparameter_id'))) {
                $area_id = 'result';
            } else if ($query->offsetExists('c24_change_options')) {
                $area_id = 'input2';
            }

            if ($query->offsetExists('c24_controller') && $query->offsetGet('c24_controller') == 'tariff_detail') {
                $area_id = 'tariffoverview';
            }

        } else {

            switch ($area_id) {

                case 'address':

                    if ($subscriptiontype !== null && $subscriptiontype == 'offer') {
                        $area_id = 'request_send_offer';
                    } else {
                        $area_id = 'request2';
                    }

                    break;

                case 'converted':
                    $area_id = 'requestthankyou';
                    break;

            }

        }

        $general_tracking = $this->getServiceLocator()->get('ZendConfig')->check24->defs->products->$product_id->generaltracking;

        $site_id = $general_tracking->siteid;
        $area_ids_mappings = $general_tracking->areaid_mappings;

        if ($action_id === null){
            $action_ids = $general_tracking->actionids;
            $action_id = $action_ids[$area_id];
        }

        if (!empty($area_ids_mappings) && isset($area_ids_mappings[$area_id])){
            $area_id = $area_ids_mappings[$area_id];
        }

        $pid = $client->get_tracking_id();
        $tid = $client->get_tracking_id2();

        if ($product_id == 21) {
            $product = 'pkv';
        } else {
            $product = \classes\register\registermanager::get_product_name($product_id);
        }

        $sid = (new \Zend\Session\SessionManager())->getId();
        $deviceouput = $client->get_deviceoutput();
        $referer_path = '';

        if ($this->getRequest()->getHeader('Referer')) {
            $referer_path = $this->getRequest()->getHeader('Referer')->uri()->toString();
        }

        $pixel = new generaltracking($site_id, $pid, $tid, $area_id, $product, $action_id, $sid, $deviceouput, NULL, $referer_path);

        return $pixel;

    }

}