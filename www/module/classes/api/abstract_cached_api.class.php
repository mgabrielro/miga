<?php

    namespace classes\api;

    use \Cache\CacheAwareInterface;
    use \Cache\CacheAwareTrait;
    use \Common\Config\ConfigAwareInterface;
    use \Common\Config\ConfigAwareTrait;
    use \shared\classes\common\exception;

    /**
     * Abstract class for remote calls
     *
     * @author Robert Curth <robert.curth@check24.de>
     * @author Lars Kneschke <lars.kneschke@check24.de>
     */
    abstract class abstract_cached_api implements CacheAwareInterface, ConfigAwareInterface {

        use CacheAwareTrait;
        use ConfigAwareTrait;

        /**
         * @var array
         */
        protected $api_result;

        /**
         * @var fallback_api_client
         */
        protected $client;

        /**
         * @var null|string
         */
        protected $endpoint;

        /**
         * @var mixed|null
         */
        protected $fallback;

        /**
         * Set rest client
         *
         * @param fallback_api_client $client The client
         * @return $this
         */
        public function set_client(fallback_api_client $client) {

            $this->client = $client;

            $this->client
                ->set_endpoint($this->endpoint)
                ->set_fallback($this->fallback);

            return $this;

        }

        /**
         * Get rest client
         *
         * @return fallback_api_client
         */
        public function get_client() {

            if (! $this->client instanceof fallback_api_client) {
                throw new exception\logic('$client is not yet set (call set_client() before)');
            }

            return $this->client;

        }

        /**
         * Get result from rest client / do remote call
         *
         * @return mixed
         */
        protected function get_api_result() {

            if ($this->api_result === NULL) {

                $cache_key = $this->getCache()->getVersionedKey(get_class($this) . '::' . __FUNCTION__);

                $this->api_result = $this->getCache()->get($cache_key, $found);

                if (!$found) {

                    $this->api_result = $this->get_client()->run();

                    /**
                     * ttl can be set in config file check24 => cache => ttl => $cache_key (see above)
                     *
                     * default timeout is 600
                     */

                    $ttl = $this->getConfig()->check24->cache->ttl->get($cache_key, 600);

                    // store for 10 minutes in redis cache
                    $this->getCache()->set($cache_key, $this->api_result, new \Cachet\Dependency\TTL($ttl));

                }

            }

            return $this->api_result;

        }

    }