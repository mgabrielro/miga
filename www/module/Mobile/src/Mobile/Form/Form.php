<?php

    namespace Mobile\Form {

        /**
         * form
         *
         * Wrapper between zend form and our API form
         *
         * @author Andreas Buchenrieder <andreas.buchenrieder@check24.de>
         */
        class Form extends \Zend\Form\Form {

            private $auto_tabindex_counter = 1;
            private $auto_tabindex_active = true;

            private $labels = array();
            private $visible_states = array();
            private $select_label = array();
            private $help_infos = array();

            /**
             * Used for field rendering
             *
             * @var PhpRenderer
             */
            private $renderer = NULL;

            /**
             * Constructor
             *
             * @return void
             */
            public function __construct() {

                parent::__construct();

                $this->renderer = new \Zend\View\Renderer\PhpRenderer;

                $resolver = new \Zend\View\Resolver\AggregateResolver();

                $stack = new \Zend\View\Resolver\TemplatePathStack(array(
                    'script_paths' => array(__DIR__ . '/../../../view/mobile/fields'),
                ));

                $resolver->attach($stack);

                $this->renderer->setResolver($resolver);

            }

            /**
             * Get renderer
             *
             * @return RendererInterface
             */
            public function get_renderer() {
                return $this->renderer;
            }

            /**
             * Base field generation valid for all field types
             *
             * @param string $name Field name
             * @param string $label Field label
             * @param array &$extra Extra attributes
             * @param boolean $visible Visible
             * @param array $help_infos Help infos
             *
             * @return \Zend\Form\Element
             */
            private function generate_base_field($name, $label = '', &$extra = array(), $visible = true, array $help_infos = array()) {

                \shared\classes\common\utils::check_string($name, 'name');
                \shared\classes\common\utils::check_string($label, 'label', true);
                \shared\classes\common\utils::check_array($extra, 'extra', true);

                if (!$this->has($name)) {
                    throw new \Exception('Field "' . $name . '" does not exists');
                }

                if (empty($extra['class'])) {
                    $extra['class'] = '';
                }

                if (empty($extra['id'])) {
                    $extra['id'] = $name;
                }

                if ( ($this->auto_tabindex_active == true) && (!isset($extra['tabindex'])) ) {
                    $extra['tabindex'] = $this->auto_tabindex_counter++;
                }

                $element = $this->get($name);

                $msg = $element->getMessages();

                if (!empty($msg)) {
                    $element->setAttribute('class', $element->getAttribute('class') . ' c24-form-errorbox c24-form-error-color');
                }

                $this->labels[$name] = $label;
                $this->visible_states[$name] = $visible;
                $this->help_infos[$name] = $help_infos;

                return $element;

            }

            /**
             * Generate select label field via using before given definition
             *
             * @param string $name Name
             * @param string $label Label
             * @param array $extra Extra attributes
             * @param boolean $visible Visible
             * @param array $help_infos Help infos
             *
             * @return \Zend\Form\Element
             */
            public function generate_select_label_field($name, $label = '', $extra = array(), $visible = true, $help_infos = array()) {
                $this->select_label[$name] = true;
                return $this->generate_select_field($name, $label, $extra, $visible, $help_infos);
            }

            /**
             * Generate select field via using before given definition
             *
             * @param string $name Name
             * @param string $label Label
             * @param array $extra Extra attributes
             * @param boolean $visible Visible
             * @param array $help_infos Help infos
             *
             * @return \Zend\Form\Element
             */
            public function generate_select_field($name, $label = '', $extra = array(), $visible = true, $help_infos = array()) {

                $element = $this->generate_base_field($name, $label, $extra, $visible, $help_infos);

                $extra['class'] .= 'c24-form-select';
                $extra['data-overlay'] = 'c24-select-' . $name . '-overlay-content';
                $extra['data-headline'] = 'c24-select-' . $name . '-headline';
                $extra['data-content-layer'] = $name . '-contentunder';

                if (empty($extra['placeholder'])) {
                    $extra['placeholder'] = $label;
                }

                $element->setAttributes($extra);

                $msg = $element->getMessages();

                if (!empty($msg)) {
                    $element->setAttribute('class', $element->getAttribute('class') . ' c24-form-errorbox c24-form-error-color');
                }

                return $element;

            }

            /**
             * Generate text field via using before given definitions
             *
             * @param string $name Name
             * @param string $label Label
             * @param array $extra Extra attributes
             * @param boolean $visible Visible
             * @param array $help_infos Help infos
             *
             * @return \Zend\Form\Element
             */
            public function generate_text_field($name, $label = '', $extra = array(), $visible = true, $help_infos = array()) {

                $element = $this->generate_base_field($name, $label, $extra, $visible, $help_infos);

                $extra['class'] .= ' c24-form-text';

                if (empty($extra['placeholder'])) {
                    $extra['placeholder'] = $label;
                }

                $extra['data-headline'] = 'c24-text-' . $name . '-headline';
                $extra['data-content-layer'] = $name . '-contentunder';
                $extra['autocorrect'] = 'off';

                $element->setAttributes($extra);

                $element = $this->get($name);

                $msg = $element->getMessages();

                if (!empty($msg)) {
                    $element->setAttribute('class', $element->getAttribute('class') . ' c24-form-errorbox c24-form-error-color');
                }

                return $element;

            }

            /**
             * Generate password field via using before given definitions
             *
             * @param string $name Name
             * @param string $label Label
             * @param array $extra Extra attributes
             * @param boolean $visible Visible
             * @param array $help_infos Help infos
             *
             * @return \Zend\Form\Element
             */
            public function generate_password_field($name, $label = '', $extra = [], $visible = true, $help_infos = []) {

                $element = $this->generate_base_field($name, $label, $extra, $visible, $help_infos);

                $extra['class'] .= ' c24-form-text';

                if (empty($extra['placeholder'])) {
                    $extra['placeholder'] = $label;
                }

                $extra['type'] = 'password';
                $extra['data-headline'] = 'c24-password-' . $name . '-headline';

                $element->setAttributes($extra);

                return $element;

            }

            /**
             * Generate email field via using before given definitions
             *
             * @param string $name Name
             * @param string $label Label
             * @param array $extra Extra attributes
             * @param boolean $visible Visible
             * @param array $help_infos Help infos
             *
             * @return \Zend\Form\Element
             */
            public function generate_email_field($name, $label = '', $extra = array(), $visible = true, $help_infos = array()) {

                $element = $this->generate_base_field($name, $label, $extra, $visible, $help_infos);

                $extra['class'] .= ' c24-form-text';

                if (empty($extra['placeholder'])) {
                    $extra['placeholder'] = $label;
                }

                $extra['type'] = 'email';
                $extra['data-headline'] = 'c24-text-' . $name . '-headline';

                $element->setAttributes($extra);

                return $element;

            }

            /**
             * Generate text field with tel subtype
             *
             * @param string $name Name
             * @param string $label Label
             * @param array $extra Extra attributes
             * @param boolean $visible Visible
             * @param array $help_infos Help infos
             *
             * @return \Zend\Form\Element
             */
            public function generate_tel_field($name, $label = '', $extra = array(), $visible = true, $help_infos = array()) {

                $extra['type'] = 'tel';

                return $this->generate_text_field($name, $label, $extra, $visible, $help_infos);

            }

            /**
             * Generate text field with number pattern on mobile devices via using before given definitions
             *
             * @param string $name Name
             * @param string $label Label
             * @param array $extra Extra attributes
             * @param boolean $visible Visible
             * @param array $help_infos Help infos
             *
             * @return \Zend\Form\Element
             */
            public function generate_digit_field($name, $label = '', $extra = array(), $visible = true, $help_infos = array()) {

                $extra['type'] = 'text';

                return $this->generate_text_field($name, $label, $extra, $visible, $help_infos);

            }

            /**
             * Generate text field with tel subtype
             *
             * @param string $name Name
             * @param string $label Label
             * @param array $extra Extra attributes
             * @param boolean $visible Visible
             * @param array $help_infos Help infos
             *
             * @return \Zend\Form\Element
             */
            public function generate_number_field($name, $label = '', $extra = array(), $visible = true, $help_infos = array()) {
                $extra['type'] = 'number';
                return $this->generate_text_field($name, $label, $extra, $visible, $help_infos);
            }

            /**
             * Generate date field
             *
             * @param string $name Name
             * @param string $label Label
             * @param array $extra Extra attributes
             * @param boolean $visible Visible
             * @param array $help_infos Help infos
             *
             * @return \Zend\Form\Element
             */
            public function generate_date_field($name, $label = '', $extra = array(), $visible = true, $help_infos = array()) {

                $element = $this->generate_base_field($name, $label, $extra, $visible, $help_infos);

                $extra['class'] .= 'c24-form-date';

                if (!empty($element->getValue())) {

                    // Add notempty fix
                    // This is done to display the placeholder, or value
                    // for html5-date input types.
                    $extra['class'] .= ' notempty';

                }

                if (empty($extra['placeholder'])) {
                    $extra['placeholder'] = $label;
                }

                $extra['data-dp-view'] = 'years';

                $extra['data-headline'] = 'c24-text-' . $name . '-headline';

                $element->setAttributes($extra);

                return $element;

            }

            /**
             * Generate radio field
             *
             * @param string $name Name
             * @param string $label Label
             * @param array $extra Extra attributes
             * @param boolean $visible Visible
             * @param array $help_infos Help infos
             *
             * @return \Zend\Form\Element
             */
            public function generate_radio_field($name, $label = '', $extra = array(), $visible = true, $help_infos = array()) {

                $element = $this->generate_base_field($name, $label, $extra, $visible, $help_infos);

                $extra['class'] .= 'c24-form-radio';
                $extra['type'] = 'radio';

                $element->setAttributes($extra);

                return $element;

            }


            /**
             * Generate radio field
             *
             * @param string $name Name
             * @param string $label Label
             * @param array $extra Extra attributes
             * @param boolean $visible Visible
             * @param array $help_infos Help infos
             *
             * @return \Zend\Form\Element
             */
            public function generate_radio_list($name, $label = '', $extra = array(), $visible = true, $help_infos = array()) {

                $element = $this->generate_base_field($name, $label, $extra, $visible, $help_infos);

                $extra['class'] .= 'c24-form-radio-list';
                $extra['type'] = 'radio_list';

                $element->setAttributes($extra);

                return $element;

            }

            /**
             * Generate radio field with css background images
             *
             * @param string $name Name
             * @param string $label Label
             * @param array $extra Extra attributes
             * @param boolean $visible Visible
             * @param array $help_infos Help infos
             *
             * @return \Zend\Form\Element
             */
            public function generate_icon_radio_list($name, $label = '', $extra = array(), $visible = true, $help_infos = array()) {

                $element = $this->generate_base_field($name, $label, $extra, $visible, $help_infos);

                $extra['class'] .= 'c24-form-radio-list';
                $extra['type'] = 'icon_radio_list';

                $element->setAttributes($extra);

                return $element;

            }


            /**
             * Generate checkbox field
             *
             * @param string $name Name
             * @param string $label Label
             * @param array $extra Extra attributes
             * @param boolean $visible Visible
             * @param array $help_infos Help infos
             *
             * @return \Zend\Form\Element
             */
            public function generate_checkbox_field($name, $label = '', $extra = array(), $visible = true, $help_infos = array()) {

                $element = $this->generate_base_field($name, $label, $extra, $visible, $help_infos);

                $extra['class'] .= 'c24-form-checkbox';
                $extra['type'] = 'checkbox';

                $element->setAttributes($extra);

                return $element;

            }

            /**
             * Generate hidden field
             *
             * @param string $name  Name
             * @param string $label Label
             * @param array $extra  Extra attributes
             * @param boolean $visible Visible
             *
             * @return \Zend\Form\Element
             */
            public function generate_hidden_field($name, $label = '', $extra = array(), $visible = true) {

                $element = $this->generate_base_field($name, $label, $extra, $visible);

                $extra['type'] = 'hidden';

                $element->setAttributes($extra);

                return $element;

            }


            /**
             * Render a form element
             *
             * @param $element \Zend\Form\Element Zend element
             *
             * @return string
             */
            public function render(\Zend\Form\Element $element) {

                switch ($element->getAttribute('type')) {

                    case 'select' :

                        if (isset($this->select_label[$element->getName()])) {
                            $template = 'select_label.phtml';
                        } else {
                            $template = 'select.phtml';
                        }

                        $helper = new \Zend\Form\View\Helper\FormSelect();

                        break;

                    case 'text' :

                        $template = 'text.phtml';
                        $helper = new \Zend\Form\View\Helper\FormInput();

                        break;

                    case 'password' :

                        $template = 'text.phtml';
                        $helper = new \Zend\Form\View\Helper\FormPassword();

                        break;

                    case 'email' :

                        $template = 'text.phtml';
                        $helper = new \Zend\Form\View\Helper\FormEmail();

                        break;

                    case 'tel' :

                        $template = 'text.phtml';
                        $helper = new \Zend\Form\View\Helper\FormTel();

                        break;

                    case 'number' :

                        $template = 'text.phtml';
                        $helper = new \Zend\Form\View\Helper\FormNumber();

                        break;

                    case 'date' :

                        $template = 'date.phtml';
                        //$helper = new \Zend\Form\View\Helper\FormDate();

                        // Due to the fact that since ZF2 Version 2.1.4 the valid tag attributes
                        // for date input elements have changed we need to extend from
                        // \Zend\Form\View\Helper\FormDate to add the missing 'placeholder' tag as valid
                        // tag attribute again.
                        $helper = new \Mobile\Form\View\Helper\FormDate();

                        break;

                    case 'date_android' :

                        $template = 'date_android.phtml';

                        $this->labels[$element->getName()] = $element->getLabel();
                        $this->visible_states[$element->getName()] = true;
                        $this->help_infos[$element->getName()] = ['content' => $element->getAttribute('hint')];

                        $helper = new \Mobile\Form\View\Helper\FormDateAndroid();

                        break;

                    case 'radio' :

                        $template = 'radio.phtml';
                        $helper = new \Zend\Form\View\Helper\FormRadio();

                        break;

                    case 'radio_list' :

                        $template = 'radio_list.phtml';
                        $helper = new \Zend\Form\View\Helper\FormRadio();

                        break;

                    case 'icon_radio_list' :

                        $template = 'icon_radio_list.phtml';
                        $helper = new \Zend\Form\View\Helper\FormRadio();

                        break;


                    case 'checkbox' :

                        $template = 'checkbox.phtml';
                        $helper = new \Zend\Form\View\Helper\FormCheckbox();
                        //$element->setUseHiddenElement(true);

                        break;

                    case 'hidden' :

                        $template = 'hidden.phtml';
                        $helper = new \Zend\Form\View\Helper\FormHidden();

                        break;

                    default:
                        return '';

                }

                try {

                    $render_attributes = array(
                        'element' => $element,
                        'label' => $this->labels[$element->getName()],
                        'content' => $helper->render($element),
                        'visible' => $this->visible_states[$element->getName()],
                        'help_info' => $this->help_infos[$element->getName()],
                        'hint' => $element->getAttribute('hint')
                    );

                    return $this->renderer->render($template, $render_attributes);

                } catch (\Exception $e) {
                    var_dump($e);
                }

            }

            /**
             * Set auto tabindex active
             *
             * @param boolean $value Value
             * @return void
             */
            public function set_auto_tabindex_active($value) {
                \shared\classes\common\utils::check_boolean($value, 'value');
                $this->auto_tabindex_active = $value;
            }

        }

    }
