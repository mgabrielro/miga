<?php

    namespace classes\calculation\mclient\model\tariff;

    use \shared\classes\common\utils;
    use \shared\classes\common\exception;

    /**
     * Abstract base class for tariff models.
     *
     * @author Philipp Kemmeter <philipp.kemmeter@check24.de>
     */
    abstract class base extends \shared\classes\calculation\client\model\tariff {

        /**
         * Factory that creates a new tariff object based on the product.
         *
         * @param integer $product_id Product id
         * @param array $data Data
         * @return \classes\calculation\mclient\model\tariff\base
         */
        public static function create($product_id, array $data) {

            utils::check_int($product_id, 'product_id');
            utils::check_array($data, 'data');

            if (product_id_exists($product_id)) {
                $class_name = '\\classes\\calculation\\client\\model\\tariff\\' . get_def('product/' . $product_id);
                return new $class_name($data);
            } else {
                throw new exception\argument('Wrong product id "' . $product_id . '"');
            }

        }

        /**
         * Retrive Promo position
         *
         * @return integer
         */
        public function get_promotion_position() {

            if (isset($this->data['result']['promotion_position'])) {
                return $this->data['result']['promotion_position'];
            }

            return 0;
            
        }

        /**
         * Returns the efeedback IDs.
         *
         * Belongs to tariff grade feature.
         *
         * @return integer
         */
        public function get_efeedback_ids() {
            return $this->data['provider']['efeedback_ids'];
        }

        /**
         * Return EFeedback Review ID
         *
         * @return integer
         */
        public function get_efeedback_review_id() {
            return $this->data['provider']['efeedback_review_id'];
        }

    }

