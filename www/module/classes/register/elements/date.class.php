<?php

    namespace classes\register\elements {

        /**
         * Date element for tg framework
         *
         * @author Tobias Albrecht <tobias.albrecht@check24.de>
         * @copyright rapidsoft GmbH
         * @version 1.0
         */
        class date extends \Zend\Form\Element {

            /**
             * Seed attributes
             *
             * @var string[]
             */
            protected $attributes = array(
                'type' => 'text',
            );

            /**
             * Date format to use for DateTime values. By default, this is RFC-3339,
             * full-date (Y-m-d), which is what HTML5 dictates.
             *
             * @var string
             */
            private $format = 'Y-m-d';



            /**
             * Set format
             *
             * @param string $format Format
             *
             * @return void
             */
            public function set_format($format) {
                $this->format = $format;
            }

            /**
             * Retrieve the element value
             *
             * If the value is a DateTime object, and $returnFormattedValue is true
             * (the default), we return the string
             * representation using the currently registered format.
             *
             * If $returnFormattedValue is false, the original value will be
             * returned, regardless of type.
             *
             * @param boolean $returnFormattedValue Return value formatted
             * @return mixed
             */
            public function getValue($returnFormattedValue = true) {

                $value = parent::getValue();

                if ($returnFormattedValue == false) {
                    return $value;
                } else {

                    $time = @strtotime($value);

                    if ($time === false) {
                        return $value;
                    } else {
                        return date($this->format, $time);
                    }

                }

            }

        }

    }
