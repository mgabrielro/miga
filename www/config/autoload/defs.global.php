
<?php

return [
    'check24' => [
        'defs' => [

            'abtest' => [
                'abtest_a' => 'PVPKV_VARIATION_A',
                'abtest_b' => 'PVPKV_VARIATION_B'
            ],

            'product_id' => 1,

            'months' => ['dummy', 'Januar', 'Februar', 'März', 'April', 'Mai', 'Juni', 'Juli', 'August', 'September', 'Oktober', 'November', 'Dezember'],

            'products' => [
                1 => [
                    'key'           => 'miga',
                    'name'          => 'Miga',
                    'url_product'   => 'Miga',
                    'efeedback'     => 6,
                    'lexicon_id'    => 0,
                    'adviser_id'    => 0,
                    'questions_id'  => 0,
                    'blog_id'       => [14,15,16,31,1040],
                    'news_category' => 'versicherungen,krankenzusatzversicherung,gesetzliche-krankenversicherung,private-krankenversicherung',
                    'cseplan_id'    => ['thankyou' => 20, 'offer1' => 30],
                    'email'         => 'mi_ga@yahoo.com',
                    'form_title'        => 'Your dream website | MIGA',
                    'form_desc'         => '',
                    'register_title'    => 'Your dream website | MIGA',
                    'register_desc'     => '',
                    'cct_secret'        => '',
                    'generaltracking' => [
                        'siteid' => 00,
                        'actionids' => [
                            'input1' => '',
                            'input2' => '',
                            'result' => 000,
                            'tariffoverview' => '',
                            'request2' => '',
                            'requestthankyou' => 000,
                            'request_send_offer' => ''
                        ],
                        'areaid_mappings' => [
                            'input1' => 'Input1',
                            'input2' => 'Input2',
                            'result' => 'Vergleichsergebnis',
                            'tariffoverview' => 'Produktdetails',
                            'request2' => 'Expertenberatung',
                            'requestthankyou' => 'Dankeseite',
                            'request_send_offer' => 'Angebotsanforderung'
                        ]
                    ],
                    'google_tag_manager' => [
                        'areaid_mappings' => [
                            'start'           => 'Start',
                            'converted'       => 'ThankYou'
                        ]
                    ]
                ],

            ],
        ]
    ]
];
