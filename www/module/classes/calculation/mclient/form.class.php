<?php

    namespace classes\calculation\mclient;

    /**
     * Form wrapper to build Zend form elements from shared form.
     * This is made to use the form templates the same way as in form.
     *
     * TODO: Generate zend field in add methods and return fields in generate methods
     *
     * @author Sufijen Bani <sufijen.bani@check24.de>
     */
    use WebDriver\Exception;

    /**
     * Class form
     * @package classes\calculation\mclient
     */
    class form extends \shared\classes\calculation\client\form {

        /**
         * Our Zend form extension
         *
         * @var \Mobile\Form\Form
         */
        protected $form;

        /**
         * @var \Zend\Http\Request
         */
        protected $request;

        /** @var  \classes\filter\abstract_profession_person_state */
        protected $state;

        /**
         * Contructor
         *
         * @param string $deviceoutput Deviceoutput (affects some text fields)
         * @param \Zend\Form\Form $form
         * @param \Zend\Http\Request $request
         */
        public function __construct($deviceoutput, \Zend\Form\Form $form, \Zend\Http\Request $request) {

            parent::__construct($deviceoutput);

            $this->form    = $form;
            $this->request = $request;

        }

        /**
         * Get state object for default value of the form.
         *
         * @throws \Exception State object is null
         * @return \classes\filter\abstract_profession_person_state
         *
         */
        public function get_state() {

            if (is_null($this->state)) {
                throw new \Exception('State object wasn\'t provided for ' . get_class($this));
            }

            return $this->state;
        }

        /**
         * Set state object for default value of the form.
         *
         * @param \classes\filter\abstract_profession_person_state $state State object.
         *
         * @return void
         */
        public function set_state(\classes\filter\abstract_profession_person_state $state) {
            check_object($state, 'state');
            $this->state = $state;
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

            \shared\classes\common\utils::check_string($name, 'name');
            \shared\classes\common\utils::check_string($label, 'label', true);
            \shared\classes\common\utils::check_string($help_content, 'help_content', true);


            if (in_array($name, $this->fields) == false) {
                throw new \shared\classes\common\exception\logic('Field "' . $name . '" does not exists');
            }

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

            if ($this->deviceoutput == 'tablet' || $this->deviceoutput == 'mobile') {
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

            \shared\classes\common\utils::check_string($name, 'name');
            \shared\classes\common\utils::check_string($label, 'label', true);
            \shared\classes\common\utils::check_string($help_content, 'help_content', true);

            if (in_array($name, $this->fields) == false) {
                throw new \shared\classes\common\exception\logic('Field "' . $name . '" does not exists');
            }

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

            \shared\classes\common\utils::check_string($name, 'name');
            \shared\classes\common\utils::check_string($label, 'label', true);
            \shared\classes\common\utils::check_string($help_content, 'help_content', true);

            if (in_array($name, $this->fields) == false) {
                throw new \shared\classes\common\exception\logic('Field "' . $name . '" does not exists');
            }

            if ($this->auto_tabindex_active == true) {
                $extra['tabindex'] = $this->auto_tabindex_counter;
                $this->auto_tabindex_counter++;
            }

            $field = new \Zend\Form\Element\Checkbox($name);
            $field->setOptions(['checked_value' => $value]);
            $field->setValue($this->data[$name]);
            $field->setCheckedValue($this->checkbox_values[$name]['checked']);
            $field->setUncheckedValue($this->checkbox_values[$name]['unchecked']);

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

            \shared\classes\common\utils::check_string($name, 'name');
            \shared\classes\common\utils::check_string($label, 'label', true);
            \shared\classes\common\utils::check_string($help_content, 'help_content', true);

            if (in_array($name, $this->fields) == false) {
                throw new \shared\classes\common\exception\logic('Field "' . $name . '" does not exists');
            }

            if (empty($extra['class'])) {
                $extra['class'] = 'c24-form-radio';
            }

            if ($this->auto_tabindex_active == true) {
                $extra['tabindex'] = $this->auto_tabindex_counter;
                $this->auto_tabindex_counter++;
            }

            $options = [];

            foreach ($values AS $key => $val) {
                $options[] = ['value' => $key, 'label' => $val];
            }

            $field = new \Zend\Form\Element\Radio($name);

            $field->setOptions(['options' => $options]);

            $field->setValueOptions($values);

            $field->setValue($this->data[$name]);
            $field->setLabel($label);

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

            \shared\classes\common\utils::check_string($name, 'name');
            \shared\classes\common\utils::check_string($label, 'label', true);
            \shared\classes\common\utils::check_string($help_content, 'help_content', true);

            if (in_array($name, $this->fields) == false) {
                throw new \shared\classes\common\exception\logic('Field "' . $name . '" does not exists');
            }

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
         * Generate zend radio list with css background images.
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
        public function generate_zend_icon_radio_list($name, $label, array $values, $help_content = '', array $extra = array(), $visible = true) {

            \shared\classes\common\utils::check_string($name, 'name');
            \shared\classes\common\utils::check_string($label, 'label', true);
            \shared\classes\common\utils::check_string($help_content, 'help_content', true);

            if (in_array($name, $this->fields) == false) {
                throw new \shared\classes\common\exception\logic('Field "' . $name . '" does not exists');
            }

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

            $element = $this->form->generate_icon_radio_list(
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

            if ($this->deviceoutput == 'tablet' ||
                $this->deviceoutput == 'mobile' ||
                $this->deviceoutput == 'app') {
                $extra['type'] = 'date';
            }

            return $this->generate_zend_text_field($name, $label, $help_content, $extra, $visible);

        }


        /**
         * Generate zend date android field
         * (day, month and year fields)
         *
         * @param string $name Name
         * @param string $label Label
         * @param string $help_content Helpinfo div content
         * @param array $extra Extra attributes
         * @param boolean $visible Display field or not
         *
         * @return string
         */
        public function generate_zend_date_android_field($name, $label, $help_content = '', array $extra = array(), $visible = true) {

            $element = new \Mobile\Form\DateAndroid($name, [
                'label' => $label
            ]);

            return $this->form->render($element);

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

            // Totalconsumption has error

            if (isset($data['c24api_totalconsumption'])) {

                // Totalconsumption select and input exists

                if (isset($this->data['c24_totalconsumption_select']) && isset($this->data['c24_totalconsumption_total'])) {

                    if ($this->data['c24_totalconsumption_select'] == -1) {

                        // Total field needed

                        $data['c24_totalconsumption_total'] = $data['c24api_totalconsumption'];

                    } else {

                        // Select field needed

                        $data['c24_totalconsumption_select'] = $data['c24api_totalconsumption'];

                    }

                    unset($data['c24api_totalconsumption']);

                }

            }

            foreach ($data AS $key => $value) {

                if (isset($this->data[$key])) {
                    $data[$key] = \classes\register\translation::t($value);
                }

            }

            parent::set_error($data);

        }

    }
