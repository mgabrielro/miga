<?php

    namespace classes\register\steps {

        use Psr\Log\LoggerAwareInterface;
        use Psr\Log\LoggerAwareTrait;
        use Zend\ServiceManager\ServiceLocatorAwareInterface;
        use Zend\ServiceManager\ServiceLocatorInterface;

        /**
         * Base register step
         *
         * @author Tobias Albrecht <tobias.albrecht@check24.de>
         * @copyright rapidsoft GmbH
         * @version 1.0
         */
        abstract class base implements ServiceLocatorAwareInterface, LoggerAwareInterface {

            use LoggerAwareTrait;

            private $registermanager = NULL;
            protected $register_data = array();

            /**
             * @var ServiceLocatorInterface
             */
            protected $serviceLocator;

            /**
             * Constructor
             *
             * @param \classes\register\registermanager $registermanager Registermanager
             * @param array $register_data Register data
             * @return void
             */
            public function __construct(\classes\register\registermanager $registermanager, array $register_data) {
                $this->registermanager = $registermanager;
                $this->register_data = $register_data;
            }

            /**
             * Set serviceManager instance
             *
             * @param ServiceLocatorInterface $serviceLocator The service locator
             * @return void
             */
            public function setServiceLocator(ServiceLocatorInterface $serviceLocator) {
                $this->serviceLocator = $serviceLocator;
            }

            /**
             * Retrieve serviceManager instance
             *
             * @return ServiceLocatorInterface
             */
            public function getServiceLocator() {
                return $this->serviceLocator;
            }

            /**
             * Set register data (needed for late setting or refresh)
             *
             * @param array $value Value
             * @return void
             */
            public function set_register_data(array $value) {
                $this->register_data = $value;
            }

            /**
             * Factory
             *
             * @param string $name Name
             * @param \classes\register\registermanager $registermanager Registermanager
             * @param array $register_data Register data
             *
             * @throws \Exception Undefined step
             * @return base
             */
            public static function create($name, \classes\register\registermanager $registermanager, array $register_data) {

                $class_name = '\\classes\\register\\steps\\' . $name;

                if (class_exists($class_name)) {
                    return new $class_name($registermanager, $register_data);
                } else {
                    throw new \Exception('Undefined step');
                }

            }

            /**
             * Handle load
             *
             * @return void
             */
            public function handle_load() {

            }

            /**
             * Handle request
             *
             * @return boolean
             */
            public function handle_request() {
                $this->handle_form_definition();
                return true;
            }

            /**
             * Handle form definition
             *
             * @return void
             */
            public function handle_form_definition() {

                foreach ($this->register_data['form_definition'] AS $field => $definition) {

                    /** @var fields\base[] $fields */
                    $fields = $this->create_field($field, $definition);

                    if (!is_array($fields)) {
                        $fields = array($fields);
                    }

                    for ($i = 0, $n = count($fields); $i < $n; ++$i) {
                        $fields[$i]->run();
                    }

                }

            }

            /**
             * Create a field with given definition
             *
             * @param string $name Field name
             * @param array $definition Field definition
             *
             * @return fields\base
             */
            protected function create_field($name, $definition) {

                return fields\base::create(
                    $name,
                    $this->get_registermanager()->get_form(),
                    $this->get_registermanager()->get_inputfilter(),
                    $definition
                );

            }

            /**
             * Handle submit
             *
             * Extended submit logic for step
             *
             * @return boolean
             */
            public function handle_submit() {
                return true;
            }

            /**
             * Handle success called after form is valid
             *
             * Redirect to next step
             *
             * @return NULL
             * @see \classes\register\registermanager::run()
             */
            public function handle_success() {

                $manager = $this->get_registermanager();

                if ($manager->get_response_submit() === NULL) {
                    return NULL;
                }

                $response_data = $manager->get_response_submit()->get_data();

                // Redirect to next step

                $next_step = $manager::get_next_step(
                    $manager->get_current_step(), $response_data['steps']
                );

                if (empty($next_step)) {
                    return NULL;
                }

                $manager->get_controller()->redirect_to_step(
                    $manager->get_registercontainer_id(),
                    $manager->get_product_id(),
                    $next_step
                );

                return;

            }

            /**
             * Handles errors
             *
             * Called by the register manager if an error occured after submit.
             *
             * @return void
             */
            public function handle_error() {
            }

            /**
             * Get registermanager
             *
             * @return \classes\register\registermanager
             */
            protected function get_registermanager() {
                return $this->registermanager;
            }

            /**
             * Get view
             *
             * @return string
             */
            public abstract function get_view();

        }

    }
