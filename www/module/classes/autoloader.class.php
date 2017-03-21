<?php

    namespace classes {

        /**
         * Autoloader
         *
         * Handles autoloading for classes folder
         *
         * @author Tobias Albrecht <tobias.albrecht@check24.de>
         * @copyright rapidsoft GmbH
         * @version 1.0
         */
        class autoloader {

            /**
             * Register autoloader
             *
             * @return void
             */
            public static function register_autoloader() {
                spl_autoload_register('\classes\autoloader::autoloader');
            }

            /**
             * Autoloader
             *
             * @param string $class Class
             * @return void
             */
            public static function autoloader($class) {

                if (strpos($class, 'classes') !== 0) {
                    return;
                }

                // Build path
                // We replace current namespace from given namespace because we use this file dirname as base and this file is already in this namespace

                $path = dirname(__FILE__) . DIRECTORY_SEPARATOR . str_replace('\\', DIRECTORY_SEPARATOR, str_replace(__NAMESPACE__ . '\\', '', $class)) . '.class.php';

                if (!file_exists($path)) {
                    throw new \Exception('Autoload failed for class "' . $class . '"');
                }

                require_once $path;

            }

        }

    }