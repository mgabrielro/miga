<?php

    namespace Mobile\Form\View\Helper;

    use Zend\Form\View\Helper\FormNumber;

    /**
     * Date android helper to render the fieldset
     *
     * @author Gabriel Mandu <gabriel.mandu@check24.de>
     */
    class FormDateAndroid extends \Zend\Form\View\Helper\FormNumber {

        /**
         * Attributes valid for the input tag type="datetime"
         *
         * @var array
         */
        protected $validTagAttributes = array(
            'name'           => true,
            'autocomplete'   => true,
            'autofocus'      => true,
            'disabled'       => true,
            'form'           => true,
            'list'           => true,
            'max'            => true,
            'min'            => true,
            'readonly'       => true,
            'required'       => true,
            'step'           => true,
            'type'           => true,
            'value'          => true,
            'placeholder'    => true,
            'max_length'     => true,
        );

        /**
         * Render our DateAndroid fieldset
         *
         * @param  \Zend\Form\ElementInterface $element
         * @return string
         */
        public function render(\Zend\Form\ElementInterface $element) {

            $label = $element->getLabel();

            $fields = '';

            /** @var $child \Zend\Form\ElementInterface */
            foreach($element as $child) {

                $helper = new FormNumber();
                $fields .= $helper->render($child);

            }

            return sprintf('<div class="android_fields">%s</div>', $fields);
        }

        /**
         * Determine input type to use
         *
         * @param  \Zend\Form\ElementInterface $element
         * @return string
         */
        protected function getType(\Zend\Form\ElementInterface $element)
        {
            return 'date_android';
        }


    }
