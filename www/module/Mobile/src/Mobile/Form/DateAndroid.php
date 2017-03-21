<?php

    namespace Mobile\Form;

    use Zend\Form\Element;

    /**
     * Class formdate specific ONLY for Android devices
     * where we need the birthday to be displayed as
     * three different input fields (day, month and year)
     *
     * @author Gabriel Mandu <gabriel.mandu@check24.de>
     */
    class DateAndroid extends \Zend\Form\Fieldset {

        /**
         * Create a new DateAndroid input fieldset
         *
         * @param null|string $name  The input form field id
         * @param array $options     Specific input field options
         */
        public function __construct($name = null, $options = array()) {
            parent::__construct($name, $options);
            $this->initFields();
        }

        /**
         * Add the needed fields to the fieldset
         */
        public function initFields() {

            $this->setAttribute('type', 'date_android');
            $this->setAttribute('hint', '<p>Bitte geben Sie das Geburtsdatum der zu versichernden Person ein. Die Beitragshöhe berechnet sich nach dem Alter.</p>');

            $this->add([
                'name' => $this->getName() . '_day',
                'attributes' => [
                    'id' => $this->getName() . '_day',
                    'type' => 'number',
                    'maxlength' => '2',
                    'placeholder' => 'TT',
                    'class' => 'date_android day'
                ]
            ]);

            $this->add([
                'name' => $this->getName() . '_month',
                'attributes' => [
                    'id' => $this->getName() . '_month',
                    'type' => 'number',
                    'maxlength' => '2',
                    'placeholder' => 'MM',
                    'class' => 'date_android month'
                ]
            ]);

            $this->add([
                'name' => $this->getName() . '_year',
                'attributes' => [
                    'id' => $this->getName() . '_year',
                    'type' => 'number',
                    'maxlength' => '4',
                    'placeholder' => 'JJJJ',
                    'class' => 'date_android year'
                ]
            ]);

        }

    }
