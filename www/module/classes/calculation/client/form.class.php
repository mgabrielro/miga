<?php

    namespace classes\calculation\client;
    use \shared\classes\common\utils;

    /**
     * Form wrapper to build Zend form elements from shared form.
     * This is made to use the form templates the same way as in form
     *
     * @author Sufijen Bani <sufijen.bani@check24.de>
     * @author Robert Curth <robert.curth@check24.de>
     */
    class form extends \shared\classes\calculation\client\form {

        /**
         * Our Zend form extension
         *
         * @var \Application\Form\Form
         */
        protected $form;

        /**
         * @var \Zend\Http\Request
         */
        protected $request;

        /**
         * Constructor
         *
         * @param string $deviceoutput Deviceoutput (affects some text fields)
         * @return void
         */
        public function __construct($deviceoutput, \Zend\Form\Form $form, \Zend\Http\Request $request) {

            parent::__construct($deviceoutput);

            $this->form    = $form;
            $this->request = $request;

            $this->set_error($this->form->getMessages());

        }

        /**
         * Set inner form
         *
         * @param \Zend\Form\Form $form
         * @return $this
         */
        public function setForm(\Zend\Form\Form $form) {
            $this->form = $form;

            return $this;
        }

        /**
         * Get url from request object
         *
         * @return string
         */
        public function get_url() {

            $uri = $this->request->getUri()->toString();

            if (strpos($uri, '?') !== false) {
                return substr($uri, 0, strpos($uri, '?'));
            } else {
                return $uri;
            }

        }

        /**
         * Generate zend text field via using before given definitions
         *
         * @param string $name Name
         * @param string $label Label
         * @param string $help_content Helpinfo div content
         * @param array $extra Extra attributes
         * @param boolean $visible Display field or not
         *
         * @return string
         */
        public function generate_zend_text_field($name, $label, $help_content = '', array $extra = array(), $visible = true) {

            check_string($name, 'name');
            check_string($label, 'label', true);
            check_string($help_content, 'help_content', true);
            $this->assert_field_exists($name);

            if (!$this->form->has($name)) {

                $field = new \Zend\Form\Element\Text($name);
                $this->form->add($field);
                $field->setValue($this->data[$name]);

                if ($this->auto_tabindex_active == true) {
                    $extra['tabindex'] = $this->auto_tabindex_counter;
                    $this->auto_tabindex_counter++;
                }

                if ($this->get_error_message($name) != '') {
                    $field->setMessages([$this->get_error_message($name)]);
                }

            }

            if (empty($extra['type']) ||
                !($this->is_mobile_app())
            ) {
                $extra['type'] = 'text';
            }

            $element = $this->form->generate_text_field(
                $name,
                $label,
                $extra,
                $visible,
                ['content' => $help_content]
            );

            return $this->form->render($element);

        }

        /**
         * Generate zend tel field via using before given definitions
         *
         * @param string $name Name
         * @param string $label Label
         * @param string $help_content Helpinfo div content
         * @param array $extra Extra attributes
         * @param boolean $visible Display field or not
         *
         * @return string
         */
        public function generate_zend_tel_field($name, $label, $help_content = '', array $extra = array(), $visible = true) {

            if ($this->is_mobile_app()) {
                $extra['type'] = 'tel';
            }

            return $this->generate_zend_text_field($name, $label, $help_content, $extra, $visible);

        }

        /**
         * Generate zend text field with number pattern on mobile devices via using before given definitions
         *
         * @param string $name Name
         * @param string $label Label
         * @param string $help_content Helpinfo div content
         * @param array $extra Extra attributes
         * @param boolean $visible Display field or not
         *
         * @return string
         */
        public function generate_zend_digit_field($name, $label, $help_content = '', array $extra = array(), $visible = true) {

            $extra['type'] = 'number';

            return $this->generate_zend_text_field($name, $label, $help_content, $extra, $visible);

        }

        /**
         * Generate select field via using before given definition
         *
         * @param string $name Name
         * @param string $label Label
         * @param string $help_content Helpinfo div content
         * @param array $extra Extra attributes
         * @param boolean $visible Display field or not
         *
         * @return string
         */
        public function generate_zend_select_field($name, $label, $help_content = '', array $extra = array(), $visible = true) {

            check_string($name, 'name');
            check_string($label, 'label', true);
            check_string($help_content, 'help_content', true);
            $this->assert_field_exists($name);

            if ($this->auto_tabindex_active == true) {
                $extra['tabindex'] = $this->auto_tabindex_counter;
                $this->auto_tabindex_counter++;
            }

            $field = new \Zend\Form\Element\Select($name);
            $field->setValueOptions($this->options[$name]);
            $field->setValue($this->data[$name]);

            $this->form->add($field);

            if ($this->get_error_message($name) != '') {
                $field->setMessages([$this->get_error_message($name)]);
            }

            $element = $this->form->generate_select_field(
                $name,
                $label,
                $extra,
                $visible,
                ['content' => $help_content]
            );

            return $this->form->render($element);

        }

        /**
         * Generate checkbox field via using before given definition
         *
         * @param string $name Name
         * @param string $label Label
         * @param string $value Value
         * @param string $help_content Helpinfo div content
         * @param array $extra Extra attributes
         * @param boolean $visible Display field or not
         *
         * @throws \shared\classes\common\exception\argument Invalid argument
         * @throws \shared\classes\common\exception\logic Logic exception
         * @return string
         */
        public function generate_zend_checkbox_field($name, $label, $value, $help_content = '', array $extra = array(), $visible = true) {

            check_string($name, 'name');
            check_string($label, 'label', true);
            check_string($help_content, 'help_content', true);
            $this->assert_field_exists($name);

            if ($this->auto_tabindex_active == true) {
                $extra['tabindex'] = $this->auto_tabindex_counter;
                $this->auto_tabindex_counter++;
            }

            $field = new \Zend\Form\Element\Checkbox($name);
            $field->setOptions(['checked_value' => $value]);
            $field->setCheckedValue($this->checkbox_values[$name]['checked']);
            $field->setUncheckedValue($this->checkbox_values[$name]['unchecked']);
            $field->setValue($this->data[$name]);

            $this->form->add($field);

            if ($this->get_error_message($name) != '') {
                $field->setMessages([$this->get_error_message($name)]);
            }

            $element = $this->form->generate_checkbox_field(
                $name,
                $label,
                $extra,
                $visible,
                ['content' => $help_content]
            );

            return $this->form->render($element);

        }

        /**
         * Generate zend radio field
         *
         * @param string $name Name
         * @param string $label Label
         * @param array $values Used values
         * @param string $help_content Helpinfo div content
         * @param array $extra Extra attributes
         * @param boolean $visible Display field or not
         *
         * @return string
         */
        public function generate_zend_radio_field($name, $label, array $values, $help_content = '', array $extra = array(), $visible = true) {

            check_string($name, 'name');
            check_string($label, 'label', true);
            check_string($help_content, 'help_content', true);
            $this->assert_field_exists($name);


            if (empty($extra['class'])) {
                $extra['class'] = 'c24-form-radio';
            }

            $options = [];

            foreach ($values AS $key => $val) {

                $temp_options = ['value' => $key, 'label' => $val];

                if ($this->auto_tabindex_active == true) {
                    $temp_options['tabindex'] = $this->auto_tabindex_counter++;
                }

                $options[] = $temp_options;

            }

            $field = new \Zend\Form\Element\Radio($name);

            $field->setOptions(['options' => $options]);

            $field->setValueOptions($values);

            $field->setValue((isset($this->data[$name])) ? $this->data[$name]: $this->form->get($name)->getValue());
            $field->setLabel($label);

            $field->setMessages(($this->form->has($name)) ? $this->form->get($name)->getMessages(): array());

            $this->form->add($field);

            $element = $this->form->generate_select_field(
                $name,
                $label,
                $extra,
                $visible,
                ['content' => $help_content]
            );

            return $this->form->render($element);

        }


        /**
         * Generate zend radio list
         *
         * @param string $name Name
         * @param string $label Label
         * @param array $values Used values
         * @param string $help_content Helpinfo div content
         * @param array $extra Extra attributes
         * @param boolean $visible Display field or not
         *
         * @return string
         */
        public function generate_zend_radio_list($name, $label, array $values, $help_content = '', array $extra = array(), $visible = true) {

            check_string($name, 'name');
            check_string($label, 'label', true);
            check_string($help_content, 'help_content', true);
            $this->assert_field_exists($name);

            if (empty($extra['class'])) {
                $extra['class'] = 'c24-form-radio-list';
            }

            if ($this->auto_tabindex_active == true) {
                $extra['tabindex'] = $this->auto_tabindex_counter;
                $this->auto_tabindex_counter++;
            }



            $field = new \Zend\Form\Element\Radio($name);

            $field->setValueOptions($this->options[$name]);

            $field->setValue($this->data[$name]);
            $field->setLabel($label);

            $this->form->add($field);

            if ($this->get_error_message($name) != '') {
                $field->setMessages([$this->get_error_message($name)]);
            }

            $element = $this->form->generate_radio_list(
                $name,
                $label,
                $extra,
                $visible,
                ['content' => $help_content]
            );

            return $this->form->render($element);

        }



        /**
         * Generate zend date field
         *
         * @param string $name Name
         * @param string $label Label
         * @param string $help_content Helpinfo div content
         * @param array $extra Extra attributes
         * @param boolean $visible Display field or not
         *
         * @return string
         */
        public function generate_zend_date_field($name, $label, $help_content = '', array $extra = array(), $visible = true) {

            if ($this->is_mobile_app()) {

                $extra['type'] = 'date';
                $extra['class'] = 'c24-mobile-date';

                if (!empty($this->get_data()['c24api_birthdate'])) {
                    $extra['value'] = date('Y-m-d', strtotime($this->get_data()['c24api_birthdate']));
                }

            }

            return $this->generate_zend_text_field($name, $label, $help_content, $extra, $visible);

        }

        /**
         * Set data
         *
         * Used to set parameter data
         *
         * @param array $data Data
         * @return void
         */
        public function set_error(array $data) {

            foreach ($data AS $key => $value) {

                if (isset($this->data[$key])) {
                    $data[$key] = \classes\register\translation::t($value);
                }

            }

            parent::set_error($data);

        }

        /**
         * Ensures the field exists in the form
         *
         * @param string $field Field
         *
         * @throws \shared\classes\common\exception\logic Thrown if the field is missing
         * @return void
         */
        protected function assert_field_exists($field) {

            if (in_array($field, $this->fields) == false && !$this->form->has($field)) {
                throw new \shared\classes\common\exception\logic('Field "' . $field . '" does not exists');
            }

        }

        /**
         * Get the current auto_tabindex_counter
         *
         * @param boolean|true $auto_increment Should auto_tabindex_counter be incremented?
         *
         * @return int Tabindex counter
         */
        public function get_auto_tabindex_counter($auto_increment = true) {

            $current_auto_tabindex_counter = $this->auto_tabindex_counter;

            if ($auto_increment) {
                $this->set_auto_tabindex_counter($this->auto_tabindex_counter + 1);
            }

            return $current_auto_tabindex_counter;

        }

        /**
         * Set the value of auto_tabindex_counter
         *
         * @param integer $counter_value Counter value
         *
         * @throws \shared\classes\common\exception\argument Exception
         * @return void
         */
        public function set_auto_tabindex_counter($counter_value) {

            check_int($counter_value, 'counter_value');

            $this->auto_tabindex_counter = $counter_value;

        }

        /**
         * Return if the user is using a mobile device
         *
         * @return boolean
         */
        public function is_mobile_app()
        {

            if ( $this->deviceoutput != "desktop" ) {
                return true;
            } else {
                return false;
            }

        }

    }
