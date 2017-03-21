<?php

namespace Common\Controller\Traits;

/**
 * trait CouponTrait
 *
 * @package Common\Controller\Traits
 * @author Robert Eichholtz <robert.eichholtz@check24.de>
 */
trait CouponTrait
{
    /**
     * @var string
     */
    protected $coupon_name = 'cs_code';

    /**
     * Loaded cs code dataobject if cs_code is valid
     *
     * @var \shared\classes\cscode\client\helper\dataobject\cscode|NULL
     */
    protected $coupon = NULL;

    /**
     * Cs code client. If not loaded yet, NULL
     *
     * @var \classes\cscode\client|NULL
     */
    protected $couponClient = NULL;

    /**
     * Get the cs code data object
     *
     * @return \shared\classes\cscode\client\helper\dataobject\cscode|NULL
     */
    public function getCoupon() {
        return $this->coupon;
    }

    /**
     * Get the cs code client
     *
     * @return \classes\cscode\client|NULL
     */
    public function getCouponClient() {
        return $this->couponClient;
    }

    /**
     * Deletes the session-entry for the coupon-code
     *
     * @return void
     */
    protected function deleteCouponCodeFromSession()
    {
        /** @var $session \Zend\Session\Container */
        $session = $this->get("SessionContainer");
        $session->offsetUnset($this->coupon_name);
    }

    /**
     * Add the cs_code info
     *
     * @param integer $product_id Product id
     * @return void
     */
    protected function assignCouponCode($product_id = null, $partner_id = 24, $is_mobile_app = true, $tracking_id = 'NONE_TID')
    {
        if(null === $product_id) {
            $product_id = $this->getProductId();
        }

        /** @var $session \Zend\Session\Container */
        $session = $this->getSession();

        /**
         * Get Coupon Code from URL and save into Session
         */
        if (!empty($this->getRequest()->getQuery($this->coupon_name))) {
            $session->offsetSet($this->coupon_name, $this->getRequest()->getQuery($this->coupon_name));
        }

        if ($session->offsetExists($this->coupon_name))
        {
            $this->couponClient = new \classes\cscode\client();
            $this->couponClient->add_search_array(['code' => $session->offsetGet($this->coupon_name)], 'code');
            $this->couponClient->set_is_mobile_app($is_mobile_app);
            $this->couponClient->set_partner_id($partner_id);
            $this->couponClient->set_product_id($product_id);
            $this->couponClient->set_tracking_id($tracking_id);
            $this->couponClient->run();

            /** @var \shared\classes\cscode\client\helper\dataobject\cscode $coupon */
            $coupon = $this->couponClient->get_dataobject();

            $this->assign($this->coupon_name, $coupon);

            if ($coupon->is_valid()) {
                $this->coupon = $coupon;
            }
        }

        elseif($couponCode = $this->getRequest()->getPost('coupon_code', false))
        {
            /** @var $session \Zend\Session\Container */
            $session = $this->getSession();
            $session->offsetSet($this->coupon_name, $couponCode);
        }
    }
}