<?php

    namespace classes\register\steps\fields;

    /**
     * Fieldcreator
     *
     * @author Sufijen Bani <sufijen.bani@check24.de>
     * @version 1.0
     */
    class address extends base {

        /**
         * Creates a fully configured select element.
         *
         * @param array &$validators List of validators.
         * @return \Zend\Form\Element\Select
         */
        protected function create_select(array &$validators) {

            $element = parent::create_select($validators);

            $options = $element->getValueOptions();

            foreach ($options AS $value => $label) {

                // For TITLE and INSURE_TITLE we need to allow the user to select "-",
                // so wee need to remove the "disable" attr.

                if ((($this->get_name() == 'title' || $this->get_name() == 'insure_title') && $value == '-') &&
                    is_array($label)) {
                    $options[$value] = $label['label'];
                }

            }

            $element->setValueOptions($options);

            return $element;

        }

    }
