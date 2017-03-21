<?php

    namespace classes\register\client\model;

    /**
     * Lead model
     *
     * @author Marco Walther <marco.walther@check24.de>
     */
    class lead extends \shared\classes\register\client\model\lead {

        /**
         * Factory
         *
         * @param integer $product_id Product id
         * @param array $data Data
         *
         * @throws \shared\classes\common\exception\logic Undefined product id
         * @return self
         */
        public static function create($product_id, array $data) {

            \shared\classes\common\utils::check_int($product_id, 'product_id');
            \shared\classes\common\utils::check_array($data, 'data');

            if (product_id_exists($product_id)) {
                $className = get_def('products/' . $product_id . '/key');
                return new $className($data);
            } else {
                throw new \shared\classes\common\exception\logic('Undefined product id');
            }

        }

    }