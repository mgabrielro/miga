<?php

/**
 * Common Translation Configuration File
 *
 * @see http://framework.zend.com/manual/current/en/modules/zend.i18n.translating.html
 */
return array(
    'locale' => 'de_DE',
    'translation_file_patterns' => array(
        array(
            'type'     => 'phparray',
            'base_dir' => __DIR__ . '/../language',
            'pattern'  => '%s.php',
            'text_domain'  => 'mobile',
        ),
    )
);