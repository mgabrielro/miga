<?php

    namespace classes;

    use Zend\Config\Config AS ZendConfig;

    /**
     * Legacy class to load config files
     *
     * @deprecated Inject config via DI
     * @author    Tobias Albrecht <tobias.albrecht@check24.de>
     * @author    Lars Kneschke <lars.kneschke@check24.de>
     */
    class config {

        /**
         * Config
         *
         * @var ZendConfig
         */
        private static $config;

        /**
         * Init config
         *
         * @param ZendConfig $config The Zend\Config object
         * @return void
         */
        public static function init(ZendConfig $config) {
            self::$config = $config->check24;
        }

        /**
         * Get value of config key
         *
         * @param string $key The config key
         * @return mixed
         */
        public static function get($key) {
            return self::fetch($key);
        }

        /**
         * Check if config key exists
         *
         * @param string $key The key to check for
         * @return boolean
         */
        public static function has($key) {
            return (self::fetch($key) !== NULL);
        }

        /**
         * Fetch key from config
         *
         * @param string $key The key to fetch
         * @return mixed
         */
        protected static function fetch($key) {

            /*
             * This piece of code is a hack!
             *
             * It's used to work around the problem, that we access configuration settings in index.php before the
             * framework is initialized.
             *
             * To work around that problem we first load a minimal configuration here and later set the complete
             * configuration in \Application\Module::onBootstrap.
             */

            if (! self::$config instanceof ZendConfig) {

                $config = new ZendConfig(require 'config/autoload/global.php');

                $local = (file_exists('config/autoload/local.php')) ? require 'config/autoload/local.php' : array();

                $config->merge(new ZendConfig($local));

                self::$config = $config->check24;

            }

            if (isset(self::$config->$key)){
                return self::$config->$key;
            }

            $parts = explode('_', $key);

            $currentValue = self::$config;

            while ($part = array_shift($parts)) {

                if (!isset($currentValue->$part)) {
                    return NULL;
                }

                $currentValue = $currentValue->$part;
            }

            return $currentValue;

        }

    }