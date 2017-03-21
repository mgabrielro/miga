<?php

    namespace Mobile\Form\View\Helper;

    /**
     * Class formdate
     * @author Andreas Frömer <andreas.froemer@check24.de>
     */
    class FormDate extends \Zend\Form\View\Helper\FormDate {

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
        );


        /**
         * Render a form <input> element from the provided $element
         *
         * @param  \Zend\Form\ElementInterface $element
         * @return string
         */
        public function render(\Zend\Form\ElementInterface $element) {
            $name = $element->getName();


            // overwrite the default render method
            // for iOS we need to disable a read-only field
            // otherwise the date picker will be opened
            //
            // We need to manually ad an hidden field because
            // $element->setUseHiddenElement(true) doesn't currently work

            $hidden_field = '';
            if ($element->getAttribute("disabled") == "disabled"){

                $attributes = [
                    'name' => $name,
                    'type' => "hidden",
                    'value' => $element->getValue()
                ];

                $hidden_field = sprintf(
                    ' <input %s%s ',
                    $this->createAttributesString($attributes),
                    $this->getInlineClosingBracket()
                );
            }

            return parent::render($element) . $hidden_field;
        }

    }
