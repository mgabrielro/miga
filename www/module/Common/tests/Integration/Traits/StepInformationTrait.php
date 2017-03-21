<?php

namespace Common\Traits;

/**
 * Trait StepInformationTrait
 *
 * @author  Markus Lommer <markus.lommer@check24.de>
 * @package Common\Traits
 */
trait StepInformationTrait
{
    /**
     * @param array $data
     *
     * @return array
     */
    public function getStepInformation($data = [])
    {

        $mockData = [
            'address'     => [
                'salutation'       => 'male',
                'title'            => '-',
                'insure_firstname' => 'Max',
                'insure_lastname'  => 'Mustermann',
                'zipcode'          => '24118',
                'street'           => 'Im Brauereiviertel',
                'streetnumber'     => '11',
                'city'             => 'Kiel',
                'phonenumber'      => '043112345678',
                'birthdate'        => '1974-03-05',
                'email'            => 'xxxxx.xxxxx@check24.de',
                'contact'          => 'yes',
            ],
            'declaration' => [
                'current_insurance_type'                         => 'by_law',
                'current_insurer'                                => '7',
                'current_insurer_name'                           => 'AOK Nordwest',
                'insure_start'                                   => '',
                'cancelation_customer'                           => 'no',
                'residence_germany'                              => '',
                'previously_insured_in_foreign_european_country' => '',
                'birthplace'                                     => '',
                'birthname'                                      => '',
                'nationality'                                    => '',
                'family_insurance'                               => 'no',
                'employer'                                       => 'CHECK24',
                'employer_street'                                => 'Baumwall',
                'employer_streetnumber'                          => '7',
                'employer_zipcode'                               => '20459',
                'employer_city'                                  => 'Hamburg',
                'employer_phone'                                 => '04012345678',
                'salary_application'                             => 'between_limit',
                'parenthood'                                     => 'no',
                'subsequent_pension_number'                      => 'no',
                'missing_pension_number'                         => 'no',
                'pension_number_not_available'                   => 'yes',
                'pension_number_not_available_birthname'         => 'Max Mustermann',
                'pension_number_not_available_birthplace'        => 'Eutin',
                'pension_number'                                 => '',
                'subsequent_health_number'                       => 'yes',
                'health_number'                                  => '',
                'comment'                                        => '',
                'occupational_title'                             => 'PHP_Developer',
                'terminable_employment'                          => 'yes',
                'relationship_employer'                          => 'no',
                'employed_since'                                 => '2016-10-01',
                'working_hours'                                  => 40,
                'terminable_employment_until'                    => '2017-03-01',
                'relationship_employer_status'                   => '',
                'company_participation'                          => 'no',
                'multiple_employment'                            => 'no',
                'salary_self_employment'                         => 'no',
                'pension_application'                            => 'no',
                'pensions'                                       => 'no',
                'exemption_care_insurance'                       => 'no',
                'exemption_pension_insurance'                    => 'no',
            ],
            'request'     => [
                'lead_id'                => 'mock',
                'subsequent_link'        => 'mock',
                'cancelation_customer'   => 'mock',
                'current_insurance_type' => 'mock',
                'is_subsequent'          => 'mock',
            ],
        ];

        $data = array_merge($mockData, $data);

        return $data;
    }
}