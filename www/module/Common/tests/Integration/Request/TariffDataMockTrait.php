<?php
namespace Common\Request;

/**
 * Trait with mocks for application service
 *
 * @author  Robert Eichholtz <robert.eichholtz@check24.de>
 * @package Common\Request
 */
trait TariffDataMockTrait
{
    /**
     * @throws \shared\classes\common\exception\argument
     * @return array
     */
    protected function getTariffDataArray()
    {
        return [
            '68-base' =>
                [
                    'result'       =>
                        [
                            'position' => 1,
                        ],
                    'provider'     =>
                        [
                            'id'                         => 74,
                            'name'                       => 'hkk Erste Gesundheit',
                            'comparename'                => null,
                            'version_id'                 => 186,
                            'brand'                      => '',
                            'brand_provider_id'          => null,
                            'health_insurance_search_id' => 26,
                            'company'                    => 'hkk Erste Gesundheit',
                            'description'                => '',
                            'logo'                       => '/filestore/provider_logo/c1ccf35b92568066b14b0a52e3e10cbf.svg',
                            'logo2'                      => '',
                            'logo_comparison'            => '',
                            'result_grouping'            => '',
                            'company_id'                 => 74,
                            'contact'                    =>
                                [
                                    'phone'      => '089 2000471403',
                                    'phone_info' => '',
                                    'email'      => '',
                                ],
                            'address'                    =>
                                [
                                    'company' => 'hkk Erste Gesundheit',
                                    'street'  => 'Martinistraße 26',
                                    'zipcode' => '28195',
                                    'city'    => 'Bremen',
                                ],
                            'customer_satisfaction'      => 'no',
                            'auto_tariff_selection'      => 'no',
                            'efeedback_ids'              => null,
                            'efeedback_review_id'        => 0,
                            'creditor_identifier'        => 'DE51ZZZ00000507816',
                            'sepa_text'                  => '',
                        ],
                    'tariff'       =>
                        [
                            'id'                         => 68,
                            'product_id'                 => PRODUCT_GKV,
                            'version_id'                 => 68,
                            'variation_key'              => 'base',
                            'name'                       => 'hkk Krankenkasse',
                            'name_pdf'                   => 'hkk Krankenkasse',
                            'validfrom'                  => '',
                            'tips'                       => null,
                            'promotion'                  => 'no',
                            'promotion_title'            => '',
                            'promotion_position'         => null,
                            'promotion_bin'              => null,
                            'hide_rule'                  => '',
                            'promotion_tariff_id'        => 0,
                            'description'                => '',
                            'code'                       => '',
                            'actioncode'                 => '',
                            'communication'              => 'normal',
                            'attachments'                =>
                                [
                                    'appform'           => null,
                                    'encrypted_appform' => null,
                                ],
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
                                    'extra_bullet'                              => null,
                                    'extra_bullet_icon'                         => null,
                                    'extra_bullet_tooltip'                      => '',
                                    'extra_bullet2'                             => null,
                                    'extra_bullet2_icon'                        => null,
                                    'extra_bullet2_tooltip'                     => '',
                                    'extra_bullet3'                             => null,
                                    'extra_bullet3_icon'                        => null,
                                    'extra_bullet3_tooltip'                     => '',
                                    'ignore_health_insurance_search'            => 'no',
                                    'tariff_details_available'                  => 'yes',
                                    'additional_premium'                        => 0.58999999999999997,
                                    'additional_premium_valid_from'             => '2016-01-01',
                                    'next_additional_premium'                   => null,
                                    'next_additional_premium_valid_from'        => null,
                                    'rating'                                    => 1,
                                    'service_phone'                             => 'no',
                                    'schedule_mediation'                        => 'yes',
                                    'doctor_search_portal'                      => 'yes',
                                    'online_patients_receipt'                   => 'yes',
                                    'homeopathy'                                => 'yes',
                                    'homeopathy_comment'                        => '',
                                    'homeopathic_therapy'                       => 'not_specified',
                                    'homeopathic_therapy_refund'                => '0.00',
                                    'homeopathic_therapy_healthaccount'         => 'not_specified',
                                    'homeopathic_therapy_comment'               => '',
                                    'homeopathic_medicine'                      => 'not_specified',
                                    'homeopathic_medicine_refund'               => '0.00',
                                    'homeopathic_medicine_healthaccount'        => 'not_specified',
                                    'homeopathic_medicine_comment'              => '',
                                    'osteopathy'                                => 'yes',
                                    'osteopathy_refund'                         => '0.00',
                                    'osteopathy_healthaccount'                  => 'not_specified',
                                    'osteopathy_comment'                        => '',
                                    'alternative_cancer_therapy'                => 'yes',
                                    'alternative_cancer_therapy_comment'        => '',
                                    'professional_tooth_cleaning'               => 'no',
                                    'professional_tooth_cleaning_refund'        => '0.00',
                                    'professional_tooth_cleaning_healthaccount' => 'not_specified',
                                    'professional_tooth_cleaning_comment'       => '',
                                    'reduced_dental_prosthesis'                 => 'yes',
                                    'reduced_dental_prosthesis_comment'         => '',
                                    'specific_dental_treatment'                 => 'no',
                                    'specific_dental_treatment_comment'         => '',
                                    'free_choice_hospital'                      => 'yes',
                                    'additional_household_help'                 => 'yes',
                                    'additional_nursing_home_care'              => 'no',
                                    'vaccinations'                              => 'yes',
                                    'additional_checkups_adult'                 => 'yes',
                                    'miscellaneous_services'                    => 'Arzneimitteldatenbank der Stiftung Warentest über das hkk-Online-Center, Hilfsmittel-Vertragspartner-Suchportal, Pflegelotse, Elterntelefon, med. Beratungsaktionen, hkk vivalance Präventionsprogramm, hkk vivalance Sport-Check, hkk bonusaktiv',
                                    'miscellaneous_services_formatted'          => null,
                                    'bonus_program'                             => 'yes',
                                    'bonus_program_money_max'                   => '150',
                                    'bonus_program_money_treatment'             => '7',
                                    'retention_program'                         => 'yes',
                                    'premium_refund'                            => 'no',
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
                            'contribution_month' =>
                                [
                                    'amount'   => '33434',
                                    'currency' => 'EUR',
                                ],
                            'contribution_year'  =>
                                [
                                    'amount'   => '401207',
                                    'currency' => 'EUR',
                                ],
                        ],
                ],
        ];
    }
}
