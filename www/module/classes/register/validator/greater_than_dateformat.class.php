<?php

    /**
     * Zend Framework (http://framework.zend.com/)
     *
     * @link      http://github.com/zendframework/zf2 for the canonical source repository
     * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
     * @license   http://framework.zend.com/license/new-bsd New BSD License
     * @package   Zend_Validator
     */

    namespace classes\register\validator;

    use Traversable;
    use \Zend\Stdlib\ArrayUtils;

    /**
     * @category   Zend
     * @package    Zend_Validate
     *
     * @author Everyone
     */
    class greater_than_dateformat extends \Zend\Validator\AbstractValidator {

        const NOT_GREATER           = 'notGreaterThan';
        const NOT_GREATER_INCLUSIVE = 'notGreaterThanInclusive';

        /**
         * Validation failure message template definitions
         *
         * @var string[]
         */
        protected $messageTemplates = array(
            self::NOT_GREATER => 'The input is not greater than "%min%"',
            self::NOT_GREATER_INCLUSIVE => 'The input is not greater or equal than "%min%"'
        );

        /**
         * @var string[]
         */
        protected $messageVariables = array(
            'min' => 'min'
        );

        /**
         * Minimum value
         *
         * @var mixed
         */
        protected $min;

        /**
         * Whether to do inclusive comparisons, allowing equivalence to max
         *
         * If false, then strict comparisons are done, and the value may equal
         * the min option
         *
         * @var boolean
         */
        protected $inclusive;

        /**
         * Dateformat
         *
         * @var string
         */
        protected $format;

        /**
         * Sets validator options
         *
         * @param array|Traversable $options Options
         *
         * @throws \InvalidArgumentException Missing option "min"
         * @return void
         */
        public function __construct($options = NULL) {

            if ($options instanceof Traversable) {
                $options = ArrayUtils::iteratorToArray($options);
            }

            if (!is_array($options)) {

                $options = func_get_args();
                $temp['min'] = array_shift($options);

                if (!empty($options)) {
                    $temp['inclusive'] = array_shift($options);
                }

                $options = $temp;

            }

            if (!array_key_exists('min', $options)) {
                throw new \InvalidArgumentException('Missing option "min"');
            }

            if (!array_key_exists('inclusive', $options)) {
                $options['inclusive'] = false;
            }

            if (array_key_exists('format', $options) == true) {
                $this->format = $options['format'];
            }

            $this->setMin($options['min'])
                 ->setInclusive($options['inclusive']);

            parent::__construct($options);

        }

        /**
         * Returns the min option
         *
         * @return mixed
         */
        public function getMin() {
            return $this->min;
        }

        /**
         * Sets the min option
         *
         * @param mixed $min Min
         * @return self Provides a fluent interface
         */
        public function setMin($min) {
            $this->min = $min;
            return $this;
        }

        /**
         * Returns the inclusive option
         *
         * @return boolean
         */
        public function getInclusive() {
            return $this->inclusive;
        }

        /**
         * Sets the inclusive option
         *
         * @param boolean $inclusive Inclusive
         * @return self Provides a fluent interface
         */
        public function setInclusive($inclusive) {
            $this->inclusive = $inclusive;
            return $this;
        }

        /**
         * Returns true if and only if $value is greater than min option
         *
         * @param mixed $value Value
         * @return boolean
         */
        public function isValid($value) {

            $datetime_value = \DateTime::createFromFormat($this->format, $value);

            $datetime_min = \DateTime::createFromFormat($this->format, $this->min);

            if ($datetime_value === NULL || $datetime_value === false) {
                $this->error('INVALID_DATE');
                return false;
            }

            $this->setValue($datetime_value->getTimestamp());

            if ($this->inclusive) {

                if ($datetime_min->getTimestamp() > $datetime_value->getTimestamp()) {
                    $this->error(self::NOT_GREATER_INCLUSIVE);
                    return false;
                }

            } else {

                if ($datetime_min->getTimestamp() >= $datetime_value->getTimestamp()) {
                    $this->error(self::NOT_GREATER);
                    return false;
                }

            }

            return true;

        }

    }
