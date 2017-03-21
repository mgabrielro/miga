<?php

    namespace shared\classes\calculation\client\view {

        /**
         * Helper.
         *
         * Wrapps all the view helper methods.
         *
         * @author Philipp Kemmeter <philipp.kemmeter@check24.de>
         */
        class helper {

            /**
             * Creates a new view helper.
             *
             * @param \shared\classes\calculation\client\view $view The  view  this  helper is
             *                                       helping.
             * @return void
             */
            public function __construct(\shared\classes\calculation\client\view $view) {
                $this->view = $view;
            }

            /**
             * The overloaded call method wrapps all calls to objects.
             *
             * They will return  an output to  render, so the return  type is a
             * string, always.
             *
             * @param string $name Name of the method.
             * @param array $args  Arguments.
             * @return string
             */
            public function __call($name, $args) {

                $classname = '\\shared\\classes\\calculation\\client\\view\\helper\\' . $name;

                if (count($args) > 10) {

                    throw new \shared\classes\calculation\client\common\exception\argument(
                        'Too many parameters. You need to extend the __call method :-)'
                    );

                }


                for ($i = 0; $i < 10; ++$i) {

                    if (!isset($args[$i])) {
                        $args[$i] = NULL;
                    }

                }


                // This looks ugly, but it's the fastes way to implement it.
                // PHP allows to call a method with more arguments than needed,
                // that's why it's working.
                //
                // Reflection on the other hand would be more general and more
                // elegant, but 10 times slower.

                $helper = new $classname(
                    $this->view, $args[0], $args[1], $args[2], $args[3], $args[4], $args[5], $args[6], $args[7], $args[8], $args[9]
                );

                return $helper->get_output();

            }

        }

    }
