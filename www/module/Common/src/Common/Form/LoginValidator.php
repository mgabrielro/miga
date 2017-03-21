<?php

namespace Common\Form;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;
use Zend\Validator;

/**
 * Class LoginValidator
 *
 * @package Common\Form
 * @author Robert Eichholtz <robert.eichholtz@check24.de>
 */
class LoginValidator implements InputFilterAwareInterface
{
    protected $inputFilter;

    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        throw new \Exception("Not used");
    }

    public function getInputFilter()
    {
        if (!$this->inputFilter)
        {
            $inputFilter = new InputFilter();
            $factory     = new InputFactory();


            $inputFilter->add($factory->createInput([
                'name' => 'email',
                'filters' => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array (
                        'name' => 'EmailAddress',
                        'options' => array(
                            'messages' => [
                                Validator\EmailAddress::INVALID             => 'Bitte geben Sie eine E-Mail-Adresse an',
                                Validator\EmailAddress::INVALID_FORMAT      => 'Bitte geben Sie eine korrekte E-Mail-Adresse an',
                                Validator\EmailAddress::INVALID_HOSTNAME    => '\'%hostname%\' ist kein gültiger Hostname',
                                Validator\Hostname::INVALID_HOSTNAME        => 'Ihre Eingabe stimmt nicht mit dem erwarteten Format eines gültigen DNS Hostnamen überein',
                                Validator\HostName::INVALID_HOSTNAME_SCHEMA => 'Der DNS Hostname kann nicht mit dem TLD Schema verifiziert werden',
                                Validator\Hostname::LOCAL_NAME_NOT_ALLOWED  => 'Lokale Netzwerkadressen sind nicht erlaubt',
                                Validator\Hostname::UNKNOWN_TLD             => 'Der DNS Hostname ist nicht in der Liste bekannter TLD',
                                Validator\Hostname::UNDECIPHERABLE_TLD      => 'Die TLD des DNS Hostnamen kann nicht extrahiert werden'
                            ]
                        ),
                    ),
                    array (
                        'name' => 'NotEmpty',
                        'options' => array(
                            'messages' => array(
                                Validator\NotEmpty::IS_EMPTY => 'Bitte geben Sie eine E-Mail-Adresse an'
                            )
                        ),
                    ),
                ),
            ]));

            $inputFilter->add($factory->createInput([
                'name' => 'password',
                'filters' => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                ),
            ]));

            $this->inputFilter = $inputFilter;
        }

        return $this->inputFilter;
    }
}