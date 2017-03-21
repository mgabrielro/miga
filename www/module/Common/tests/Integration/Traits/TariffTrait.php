<?php

namespace Common\Traits;

use Common\Calculation\Model\Tariff\Gkv as Tariff;
use Common\Service\TariffFeatureParser;

/**
 * Class TariffTrait
 *
 * @author Martin Rintelen <martin.rintelen@check24.de>
 */
trait TariffTrait
{
    /**
     * @param array $data
     *
     * @return Tariff
     */
    public function getTariff($data = [])
    {
        $defaultData = [
            'result'       =>
                [
                    'position' => 1,
                ],
            'provider'     =>
                [
                    'id'                    => 77,
                    'name'                  => 'hkk Erste Gesundheit',
                    'comparename'           => null,
                    'version_id'            => 77,
                    'brand'                 => '',
                    'brand_provider_id'     => null,
                    'company'               => 'hkk Erste Gesundheit',
                    'description'           => '',
                    'logo'                  => '',
                    'logo2'                 => '',
                    'logo_comparison'       => '',
                    'result_grouping'       => '',
                    'company_id'            => 77,
                    'contact'               =>
                        [
                            'phone'      => '0421 3655-0',
                            'phone_info' => '',
                            'email'      => '',
                        ],
                    'address'               =>
                        [
                            'company' => 'hkk Erste Gesundheit',
                            'street'  => 'Martinistraße 26',
                            'zipcode' => '28195',
                            'city'    => 'Bremen',
                        ],
                    'customer_satisfaction' => 'no',
                    'auto_tariff_selection' => 'no',
                    'efeedback_ids'         => null,
                    'efeedback_review_id'   => 0,
                    'creditor_identifier'   => 'DE51ZZZ00000507816',
                    'sepa_text'             => '',
                ],
            'tariff'       =>
                [
                    'id'                         => 48,
                    'product_id'                 => 41,
                    'version_id'                 => 89,
                    'variation_key'              => 'base',
                    'name'                       => 'Front-line uniform framework',
                    'name_pdf'                   => 'Front-line uniform framework',
                    'validfrom'                  => '',
                    'tips'                       => null,
                    'promotion'                  => 'no',
                    'promotion_title'            => '',
                    'promotion_position'         => null,
                    'promotion_bin'              => null,
                    'hide_rule'                  => '',
                    'promotion_tariff_id'        => 0,
                    'attachments'                =>
                        [
                            'appform' => null,
                        ],
                    'description'                => 'Natus molestiae et sit magnam. Vitae fugiat odit rerum. Facilis voluptatem omnis ad hic perspiciatis.',
                    'code'                       => '',
                    'actioncode'                 => '',
                    'communication'              => 'normal',
                    'grade'                      =>
                        [
                            'max_points'      => 0,
                            'total_points'    => 0,
                            'result'          => 1,
                            'name'            => 'sehr gut',
                            'feature_details' =>
                                [
                                ],
                        ],
                    'product_dependent_features' =>
                        [
                            'extra_bullet'                              => 'minus est molestias fugiat',
                            'extra_bullet_icon'                         => 'negative',
                            'extra_bullet_tooltip'                      => 'Omnis dolor sed quaerat aut dicta blanditiis. Consequatur ut eveniet illo numquam quos. Voluptatem maxime pariatur necessitatibus molestiae tempora.',
                            'extra_bullet2'                             => 'quasi pariatur enim quas',
                            'extra_bullet2_icon'                        => 'gift',
                            'extra_bullet2_tooltip'                     => 'Qui quia et et nulla quas natus. Id dolor tenetur voluptate omnis dolorem.',
                            'extra_bullet3'                             => null,
                            'extra_bullet3_icon'                        => null,
                            'extra_bullet3_tooltip'                     => null,
                            'ignore_health_insurance_search'            => 'no',
                            'tariff_details_available'                  => 'yes',
                            'additional_premium'                        => 0.96999999999999997,
                            'additional_premium_validfrom'              => '2016-04-03',
                            'additional_premium_next'                   => '0.02',
                            'additional_premium_next_validfrom'         => '2016-05-31 23:20:48',
                            'rating'                                    => 3,
                            'service_phone'                             => 'yes',
                            'schedule_mediation'                        => 'yes',
                            'doctor_search_portal'                      => 'yes',
                            'online_patients_receipt'                   => 'yes',
                            'homeopathy'                                => 'no',
                            'homeopathy_comment'                        => null,
                            'homeopathic_therapy'                       => 'not_specified',
                            'homeopathic_therapy_refund'                => '148.51',
                            'homeopathic_therapy_healthaccount'         => 'yes',
                            'homeopathic_therapy_comment'               => null,
                            'homeopathic_medicine'                      => 'no',
                            'homeopathic_medicine_refund'               => '42.57',
                            'homeopathic_medicine_healthaccount'        => 'yes',
                            'homeopathic_medicine_comment'              => null,
                            'osteopathy'                                => 'yes',
                            'osteopathy_refund'                         => '42.85',
                            'osteopathy_healthaccount'                  => 'not_specified',
                            'osteopathy_care_provider'                  => null,
                            'osteopathy_comment'                        => null,
                            'alternative_cancer_therapy'                => 'no',
                            'alternative_cancer_therapy_comment'        => null,
                            'professional_tooth_cleaning'               => 'no',
                            'professional_tooth_cleaning_refund'        => '93.01',
                            'professional_tooth_cleaning_healthaccount' => 'yes',
                            'professional_tooth_cleaning_comment'       => null,
                            'reduced_dental_prosthesis'                 => 'no',
                            'reduced_dental_prosthesis_comment'         => null,
                            'specific_dental_treatment'                 => 'yes',
                            'specific_dental_treatment_comment'         => null,
                            'free_choice_hospital'                      => 'yes',
                            'additional_household_help'                 => 'yes',
                            'additional_nursing_home_care'              => 'yes',
                            'vaccinations_beyond_by_law'                => 'no',
                            'additional_checkups_adult'                 => 'yes',
                            'miscellaneous_services'                    => null,
                            'miscellaneous_services_formatted'          => null,
                            'bonus_program'                             => 'no',
                            'bonus_program_money_max'                   => '52',
                            'bonus_program_money_treatment'             => '34',
                            'retention_program'                         => 'no',
                            'artificial_insemination'                   => 'mock',
                            'additional_pregnancy_examination'          => 'mock',
                            'midwife_standby_service'                   => 'mock',
                            'additional_youth_examination'              => 'mock',
                            'travel_vaccination'                        => 'mock',
                            'third_party_course'                        => 'mock',
                            'premium_refund'                            => 'mock',
                            'agencies'                                  => [
                                'num_agencies'           => null,
                                'selected_federal_state' => null,
                            ],
                            'early_diagnosis_skin_cancer'               => null,
                            'early_diagnosis_bowel_cancer'              => null,
                            'early_diagnosis_breast_cancer'             => null,
                        ],
                ],
            'subscription' =>
                [
                    'possible' => 'yes',
                    'external' => '',
                    'url'      => '&c24_position=1',
                    'way'      => 'all',
                ],
            'price'        =>
                [
                    'premium'            => 14.6,
                    'additional_premium' => 0.58999999999999997,
                    'total_premium'      => 15.19,
                    'contribution_month' => [
                        'amount'   => 32875,
                        'currency' => 'EUR',
                    ],
                    'contribution_year'  => [
                        'amount'   => 394500,
                        'currency' => 'EUR',
                    ],
                ],
            'bonus'        =>
                [
                ],
        ];
        $mergedData  = array_merge($defaultData, $data);

        $tariff = new Tariff($mergedData);

        /** @var TariffFeatureParser $tariffFeatureParser */
        $tariffFeatureParser = $this->getApplicationServiceLocator()->get(TariffFeatureParser::class);

        $tariff->setFeatures($tariffFeatureParser->parse($tariff));

        return $tariff;
    }
}