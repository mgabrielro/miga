<?php

    namespace classes\calculation\mclient\model\parameter;

    use \shared\classes\common\exception;
    use \shared\classes\common\utils;

    /**
     * Abstract parent class of parameter models.
     *
     * @author Igor Duspara <igor.duspara@check24.de>
     */
    abstract class base extends \shared\classes\calculation\client\model\parameter {

        /**
         * Creates a new parameter object based on the given product id.
         *
         * @param integer $product_id Product id.
         * @param array $data         Data array.
         * @return base
         */
        public static function create($product_id, $data) {

            utils::check_int($product_id, 'product_id');
            utils::check_array($data, 'data');


            if (product_id_exists($product_id)) {
                $classname = '\\classes\\calculation\\client\\model\\parameter\\' . get_def('product/' . $product_id);
                return new $classname($data);
            } else {
                throw new \rs_invalid_argument_exception('Wrong product id "' . $product_id . '"');
            }

        }

    }