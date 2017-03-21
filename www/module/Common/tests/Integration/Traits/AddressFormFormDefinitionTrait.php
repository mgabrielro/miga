<?php

namespace Common\Traits;

/**
 * Trait AddressFormFormDefinitionTrait
 *
 * @author Markus Lommer <markus.lommer@check24.de>
 */
trait AddressFormFormDefinitionTrait
{
    /**
     * @param array $data
     *
     * @return array
     */
    public function getAddressFormFormDefinition($data = [])
    {
        $addressFormFormDefinition = [
            'salutation'       => [
                'mandatory'                     => true,
                'db_data'                       => '',
                'display_data'                  => '',
                'mandatory_error_message'       => 'SALUTATION_MANDATORY',
                'type'                          => 'select',
                'option'                        => [
                    ''       => 'Bitte wählen',
                    'male'   => 'Herr',
                    'female' => 'Frau',
                ],
                'allowed_option'                => [
                    'male',
                    'female',
                ],
                'allowed_options_error_message' => 'SALUTATION_SELECT',
            ],
            'title'            => [
                'mandatory'                     => false,
                'db_data'                       => '',
                'display_data'                  => '',
                'mandatory_error_message'       => 'TITLE_MANDATORY',
                'type'                          => 'select',
                'option'                        => [
                    '-'         => '-',
                    'Dr.'       => 'Dr.',
                    'Prof.'     => 'Prof.',
                    'Prof. Dr.' => 'Prof. Dr.',
                ],
                'allowed_option'                => [
                    '-',
                    'Dr.',
                    'Prof.',
                    'Prof. Dr.',
                ],
                'allowed_options_error_message' => 'TITLE_SELECT',
            ],
            'insure_firstname' => [
                'mandatory'               => true,
                'db_data'                 => '',
                'display_data'            => null,
                'mandatory_error_message' => 'INSURE_FIRSTNAME_MANDATORY',
                'type'                    => 'text',
                'min_length'              => 2,
                'max_length'              => 50,
                'length_error_message'    => 'INSURE_FIRSTNAME_LENGTH',
            ],
            'insure_lastname'  => [
                'mandatory'               => true,
                'db_data'                 => '',
                'display_data'            => null,
                'mandatory_error_message' => 'INSURE_LASTNAME_MANDATORY',
                'type'                    => 'text',
                'min_length'              => 2,
                'max_length'              => 50,
                'length_error_message'    => 'INSURE_LASTNAME_LENGTH',
            ],
            'zipcode'          => [
                'mandatory'               => true,
                'db_data'                 => '',
                'display_data'            => '',
                'mandatory_error_message' => 'ZIPCODE_MANDATORY',
                'type'                    => 'regex',
                'regex'                   => '/^[0-9]{5}$/',
                'regex_error_message'     => 'ZIPCODE_INVALID_CHARS',
            ],
            'street'           => [
                'mandatory'                     => true,
                'db_data'                       => '',
                'display_data'                  => '',
                'mandatory_error_message'       => 'STREET_MANDATORY',
                'type'                          => 'select',
                'option'                        => [],
                'allowed_option'                => [],
                'allowed_options_error_message' => 'STREET_SELECT',
            ],
            'streetnumber'     => [
                'mandatory'               => true,
                'db_data'                 => '',
                'display_data'            => null,
                'mandatory_error_message' => 'STREETNUMBER_MANDATORY',
                'type'                    => 'text',
                'min_length'              => 1,
                'max_length'              => 7,
                'length_error_message'    => 'STREETNUMBER_LENGTH',
            ],
            'city'             => [
                'mandatory'               => true,
                'db_data'                 => '',
                'display_data'            => null,
                'mandatory_error_message' => 'CITY_MANDATORY',
                'type'                    => 'text',
                'min_length'              => 1,
                'max_length'              => 50,
                'length_error_message'    => 'CITY_LENGTH',
            ],
            'phonenumber'            => [
                'mandatory'               => true,
                'db_data'                 => '',
                'display_data'            => null,
                'mandatory_error_message' => 'PHONENUMBER.IS_EMPTY',
                'type'                    => 'text',
                'min_length'              => 1,
                'max_length'              => 21,
                'length_error_message'    => 'PHONENUMBER.NOT_VALID',
            ],
            'birthdate'        => [
                'mandatory'               => true,
                'db_data'                 => '',
                'display_data'            => null,
                'mandatory_error_message' => 'BIRTHDATE_MANDATORY',
                'type'                    => 'date',
                'range_start'             => null,
                'range_end'               => null,
                'date_error_message'      => 'BIRTHDATE_INVALID_CHARS',
                'html5-type'              => 'date',
            ],
            'email'            => [
                'mandatory'               => true,
                'db_data'                 => '',
                'display_data'            => '',
                'mandatory_error_message' => 'EMAIL_MANDATORY',
                'type'                    => 'email',
                'email_error_message'     => 'EMAIL_INVALID_CHARS',
                'html5-type'              => 'email',
            ],
            'contact'          => [
                'mandatory'               => true,
                'db_data'                 => 'no',
                'display_data'            => 'no',
                'mandatory_error_message' => 'CONTACT_MANDATORY',
                'type'                    => 'checkbox',
                'checked_value'           => 'yes',
                'unchecked_value'         => 'no',
            ],
        ];

        $addressFormFormDefinition = array_merge($addressFormFormDefinition, $data);

        return $addressFormFormDefinition;
    }
}