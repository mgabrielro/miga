<?php

    namespace classes\register\steps\fields {

        /**
         * Base field and validation creator
         *
         * @author Tobias Albrecht <tobias.albrecht@check24.de>
         * @copyright rapidsoft GmbH
         * @version 1.0
         */
        class base {

            /**
             * Name of the field.
             *
             * @var string
             */
            protected $name = '';

            /**
             * Form
             *
             * @var \Zend\Form\Form
             */
            protected $form = NULL;

            /**
             * Input filter
             *
             * @var \Zend\InputFilter\InputFilter
             */
            protected $input_filter = NULL;

            /**
             * Field definition
             *
             * @var array
             */
            protected $field_definition = array();

            /**
             * Factory
             *
             * @param string $name Name
             * @param \Zend\Form\Form $form Form
             * @param \Zend\InputFilter\InputFilter $input_filter Input filter
             * @param array $field_definition Field definition
             * @return base
             */
            public static function create($name, \Zend\Form\Form $form, \Zend\InputFilter\InputFilter $input_filter, array $field_definition) {

                switch ($name) {

                    default :

                        return new static($name, $form, $input_filter, $field_definition);

                }

            }

            /**
             * Constructor
             *
             * @param string $name Name
             * @param \Zend\Form\Form $form Form
             * @param \Zend\InputFilter\InputFilter $input_filter Input filter
             * @param array $field_definition Field definition
             * @return void
             */
            public function __construct($name, \Zend\Form\Form $form, \Zend\InputFilter\InputFilter $input_filter, array $field_definition) {

                $this->name = $name;
                $this->form = $form;
                $this->input_filter = $input_filter;
                $this->field_definition = $field_definition;

            }

            /**
             * Run
             *
             * @return void
             */
            public function run() {

                $field_definition = $this->get_field_definition();

                // Create default input filter

                $filter = new \Zend\InputFilter\Input(
                    $this->name
                );

                if ($field_definition['mandatory'] == false) {
                    $filter->setAllowEmpty(true);
                }

                $validators = array();

                // Create form element and add validators

                $element = $this->{'create_' . $field_definition['type']}($validators);

                for ($i = 0, $n = count($validators); $i < $n; ++$i) {

                    $filter->getValidatorChain()->addValidator(
                        $validators[$i]
                    );

                }

                // Set default value

                if ($field_definition['type'] == 'select') {

                    if ($field_definition['db_data'] === NULL) {
                        $field_definition['db_data'] = key($field_definition['option']);
                    }

                    if ($field_definition['display_data'] === NULL) {
                        $field_definition['display_data'] = current($field_definition['option']);
                    }

                }

                if ($field_definition['db_data'] !== NULL) {
                    $element->setValue($field_definition['db_data']);
                }

                // Add field to form

                $this->get_form()->add($element);

                // Add to input filter

                $this->input_filter->add($filter);

            }

            /**
             * Creates a fully configured checkbox element.
             *
             * @param array &$validators List of validators.
             * @return \Zend\Form\Element\Checkbox
             */
            protected function create_checkbox(array &$validators) {

                $element = new \Zend\Form\Element\Checkbox(
                    $this->get_name(),
                    array('unchecked_value' => $this->field_definition['unchecked_value'], 'checked_value' => $this->field_definition['checked_value'])
                );

                if (!empty($this->field_definition['label'])) {
                    $element->setLabel($this->field_definition['label']);
                }

                return $element;

            }

            /**
             * Creates a fully configured date element.
             *
             * @param array &$validators List of validators.
             * @return \Zend\Form\Element\Text
             */
            protected function create_date(array &$validators) {
                $element = new \classes\register\elements\date(
                    $this->get_name()
                );

                $element->set_format('d.m.Y');
                return $element;

            }

            /**
             * Creates a fully configured datetime element.
             *
             * @param array &$validators List of validators.
             * @return \Zend\Form\Element\Text
             */
            protected function create_datetime(array &$validators) {
                // TODO add appropriate validator
                return $this->create_text($validators);
            }

            /**
             * Creates a fully configured email element.
             *
             * @param array &$validators List of validators.
             * @return \Zend\Form\Element\Text
             */
            protected function create_email(array &$validators) {

                $field_definition = $this->get_field_definition();

                $element = new \Zend\Form\Element\Email(
                    $this->get_name()
                );

                return $element;

            }

            /**
             * Creates a fully configured float element.
             *
             * @param array &$validators List of validators.
             * @return \Zend\Form\Element\Text
             */
            protected function create_float(array &$validators) {
                $element = $this->create_text($validators);
                return $element;
            }

            /**
             * Creates a fully configured hourminute element.
             *
             * @param array &$validators List of validators.
             * @return \Zend\Form\Element\Text
             */
            protected function create_hourminute(array &$validators) {
                // TODO add appropriate validator
                return $this->create_text($validators);
            }

            /**
             * Creates a fully configured id element.
             *
             * @param array &$validators List of validators.
             * @return \Zend\Form\Element\Text
             */
            protected function create_id(array &$validators) {
                return $this->create_int($validators);
            }

            /**
             * Creates a fully configured int element.
             *
             * @param array &$validators List of validators.
             * @return \Zend\Form\Element\Text
             */
            protected function create_int(array &$validators) {

                $element = $this->create_text($validators);

                $field_definition = $this->get_field_definition();

                if (isset($field_definition['min'])) {
                    $element->setAttribute('min', $field_definition['min']);
                }

                if (isset($field_definition['max'])) {
                    $element->setAttribute('max', $field_definition['max']);
                }

                $validators[] = new \Zend\Validator\Digits(
                    array('locale' => 'de')
                );

                return $element;

            }

            /**
             * Creates a fully configured radio element.
             *
             * @param array &$validators List of validators.
             * @return \Zend\Form\Element\Radio
             */
            protected function create_radio(array &$validators) {

                $field_definition = $this->get_field_definition();

                $options = array();

                for ($i = 0, $i_max = count($field_definition['allowed_values']); $i < $i_max; ++$i) {
                    $options[] = array('value' => $field_definition['allowed_values'][$i], 'label' => $field_definition['option'][$field_definition['allowed_values'][$i]]);
                }

                $element = new \Zend\Form\Element\Radio(
                    $this->get_name(),
                    array('options' => $options)
                );

                if (!empty($field_definition['label'])) {
                    $element->setLabel($field_definition['label']);
                }

                return $element;

            }

            /**
             * Creates a fully configured radio element.
             *
             * @param array &$validators List of validators.
             * @return \Zend\Form\Element\Radio
             */
            protected function create_radio_list(array &$validators) {

                $field_definition = $this->get_field_definition();

                $options = array();

                for ($i = 0, $i_max = count($field_definition['allowed_values']); $i < $i_max; ++$i) {
                    $options[$field_definition['allowed_values'][$i]] = $field_definition['option'][$field_definition['allowed_values'][$i]];
                }

                $element = new \Zend\Form\Element\Radio(
                    $this->get_name(),
                    array('options' => $options)
                );

                if (!empty($field_definition['label'])) {
                    $element->setLabel($field_definition['label']);
                }

                return $element;

            }

            /**
             * Creates a fully configured regex element.
             *
             * @param array &$validators List of validators.
             * @return \Zend\Form\Element\Text
             */
            protected function create_regex(array &$validators) {

                $field_definition = $this->get_field_definition();

                $element = $this->create_text($validators);

                $validators[] = new \Zend\Validator\Regex(
                    $field_definition['regex']
                );

                return $element;

            }

            /**
             * Creates a fully configured select element.
             *
             * @param array &$validators List of validators.
             * @return \Zend\Form\Element\Select
             */
            protected function create_select(array &$validators) {

                $field_definition = $this->get_field_definition();

                $element = new \Zend\Form\Element\Select(
                    $this->get_name()
                );

                $all_options = $field_definition['option'];
                $allowed_options = $field_definition['allowed_option'];

                // These fields are allowed to get the options disabled.that are empty or "-" and
                // therefore not usable. (It makes no sense to choose them)

                $disable_allowed_fields = [
                    'gender',
                    'title',
                    'insure_title',
                    'insure_gender',
                    'city',
                    'street',
                    'bill_city',
                    'bill_street',
                    'accountowner_city',
                    'accountowner_street',
                    'legalform',
                ];

                $options = [];

                foreach ($all_options AS $value => $label) {

                    $disabled_option = (
                        in_array($this->get_name(), $disable_allowed_fields) &&
                        (!in_array($value, $allowed_options) || $value == '' || $value == '-')
                    );

                    if ($disabled_option) {
                        $options[$value] = ['value' => $value, 'label' => $label, 'disabled' => 'disabled'];
                    } else {
                        $options[$value] = $label;
                    }
                }

                $element->setValueOptions($options);

                if ($field_definition['mandatory'] == false && isset($field_definition['option'][''])) {
                    $field_definition['allowed_option'][] = '';
                }

                $validator = new \Zend\Validator\InArray(
                    array('haystack' => $field_definition['allowed_option'])
                );

                $validators[] = $validator;

                return $element;

            }

            /**
             * Creates a fully configured text element.
             *
             * @param array &$validators List of validators.
             * @return \Zend\Form\Element\Text
             */
            protected function create_text(array &$validators) {

                $field_definition = $this->get_field_definition();

                $element = new \Zend\Form\Element\Text(
                    $this->get_name()
                );

                if ($field_definition['mandatory'] == true) {
                    $validators[] = new \Zend\Validator\NotEmpty();
                }

                $options = array(
                    'encoding' => 'UTF-8'
                );

                if (!empty($field_definition['min_length'])) {
                    $options['min'] = $field_definition['min_length'];
                }

                if (!empty($field_definition['max_length'])) {
                    $options['max'] = $field_definition['max_length'];
                    $element->setAttribute('maxlength', $field_definition['max_length']);
                }

                if (isset($options['max']) || isset($options['min'])) {
                    $validators[] = new \Zend\Validator\StringLength($options);
                }

                return $element;

            }

            /**
             * Returns the name of the field.
             *
             * @return string
             */
            public function get_name() {
                return $this->name;
            }

            /**
             * Returns the field definition.
             *
             * @return array Of mixed scalar values.
             */
            public function get_field_definition() {
                return $this->field_definition;
            }

            /**
             * Returns the form.
             *
             * @return \Zend\Form\Form
             */
            public function get_form() {
                return $this->form;
            }

        }

    }
