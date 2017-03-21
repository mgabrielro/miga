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
    class less_than_dateformat extends \Zend\Validator\AbstractValidator {

        const NOT_LESS           = 'notLessThan';
        const NOT_LESS_INCLUSIVE = 'notLessThanInclusive';

        /**
         * Validation failure message template definitions
         *
         * @var string[]
         */
        protected $messageTemplates = array(
            self::NOT_LESS           => 'The input is not less than "%max%"',
            self::NOT_LESS_INCLUSIVE => 'The input is not less or equal than "%max%"'
        );

        /**
         * Additional variables available for validation failure messages
         *
         * @var string[]
         */
        protected $messageVariables = array(
            'max' => 'max'
        );

        /**
         * Maximum value
         *
         * @var mixed
         */
        protected $max;

        /**
         * Whether to do inclusive comparisons, allowing equivalence to max
         *
         * If false, then strict comparisons are done, and the value may equal
         * the max option
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
         * @throws \InvalidArgumentException Missing option "max"
         * @return void
         */
        public function __construct($options = NULL) {

            if ($options instanceof Traversable) {
                $options = ArrayUtils::iteratorToArray($options);
            }

            if (!is_array($options)) {

                $options = func_get_args();
                $temp['max'] = array_shift($options);

                if (!empty($options)) {
                    $temp['inclusive'] = array_shift($options);
                }

                $options = $temp;

            }

            if (!array_key_exists('max', $options)) {
                throw new \InvalidArgumentException('Missing option "max"');
            }

            if (!array_key_exists('inclusive', $options)) {
                $options['inclusive'] = false;
            }

            if (array_key_exists('format', $options)) {
                $this->format = $options['format'];
            }

            $this->setMax($options['max'])
                 ->setInclusive($options['inclusive']);

            parent::__construct($options);

        }

        /**
         * Returns the max option
         *
         * @return mixed
         */
        public function getMax() {
            return $this->max;
        }

        /**
         * Sets the max option
         *
         * @param mixed $max Max
         * @return self Provides a fluent interface
         */
        public function setMax($max) {
            $this->max = $max;
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
         * Returns true if and only if $value is less than max option, inclusively
         * when the inclusive option is true
         *
         * @param mixed $value Value
         * @return boolean
         */
        public function isValid($value) {

            $datetime_value = \DateTime::createFromFormat($this->format, $value);

            if ($datetime_value === NULL || $datetime_value === false) {
                $this->error('INVALID_DATE');
                return false;
            }

            $datetime_max = \DateTime::createFromFormat($this->format, $this->max);

            $this->setValue($datetime_value->getTimestamp());

            if ($this->inclusive) {

                if ($datetime_value->getTimestamp() > $datetime_max->getTimestamp()) {
                    $this->error(self::NOT_LESS_INCLUSIVE);
                    return false;
                }

            } else {

                if ($datetime_value->getTimestamp() >= $datetime_max->getTimestamp()) {
                    $this->error(self::NOT_LESS);
                    return false;
                }

            }

            return true;

        }

    }
