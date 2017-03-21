<?php

    namespace classes\register {

        /**
         * Translate
         *
         * Easy token system for mobile version
         *
         * @author Tobias Albrecht <tobias.albrecht@check24.de>
         * @copyright rapidsoft GmbH
         * @version 1.0
         */
        class translation {

            private static $token_set = array(

                // Calculation server PKV

                'INSURE_SUM'                => 'Die Versicherungssumme muss zwischen 5.000 € und 5.000.000 € liegen.',
                'INSURE_PERIOD'             => 'Die Laufzeit muss zwischen 5 und 50 Jahren liegen.',
                'INSURE_PERIOD_MAX_AGE'     => 'Das maximale Alter bei Vertragsende beträgt 75 Jahre. Bitte verringern Sie die Vertragslaufzeit.',
                'BIRTHDATE'                 => 'Bitte geben Sie das Geburtsdatum der zu versichernden Person an.',
                'BIRTHDATE_UNDER_AGE'       => 'Leider können Personen unter 18 Jahre keine Risikolebensversicherung abschließen.',
                'BIRTHDATE_INVALID'         => 'Bitte ein gültiges Geburtsdatum eingeben.',
                'SMOKER'                    => '',
                'OCCUPATION_NAME'           => 'Bitte wählen Sie einen Beruf aus der Liste.',

                // Calculation server PKV
                'PROFESSION' => 'Bitte geben Sie den Berufsstand der zu versichernden Person an.',
                'BIRTHDATE'  => 'Bitte geben Sie das Geburtsdatum der zu versichernden Person an.',
                'BIRTHDATE_UNDER_AGE' => 'Leider können unter 18 Jahre alte Personen keine private Krankenversicherung abschließen. Um ein Kind zu versichern, wählen Sie oben bitte "Kind" aus.',
                'BIRTHDATE_AFTER_LIMIT'  => 'Leider können für über 98 Jahre alte Personen keine Tarife angezeigt werden.',
                'CHILDREN_AGE_NOT_SELECTED' => 'Bitte geben Sie an, wie alt das Kind zum gewünschten Versicherungsbeginn ist.',
                'CONTRIBUTION_CARRIER' => 'Bitte geben Sie den Beihilfeträger an.',
                'CONTRIBUTION_RATE' => 'Bitte geben Sie den Beihilfesatz an.',
                'PARENT1_INSURED_NOT_SELECTED' => 'Bitte geben Sie die private Krankenversicherung mindestens eines Elternteils ein.',
                'PARENT2_INSURED_NOT_SELECTED' => 'Bitte geben Sie die private Krankenversicherung mindestens eines Elternteils ein.',
                'CHILDREN_AGE' => 'Bitte geben Sie das Alter des Kindes zum gewünschten Versicherungsbeginn an.',

                // Step address

                'AGREED_TEL_CONTACT_MANDATORY' => 'Ohne Ihre Einwilligung können wir Ihre Anfrage leider nicht weiter bearbeiten. Bitte stimmen Sie zu, dass wir Sie telefonisch erreichen dürfen.',
                'EMAIL_MANDATORY' => 'Bitte geben Sie Ihre E-Mail-Adresse an.',
                'EMAIL_REPEAT_MANDATORY' => 'Ungültige E-Mail-Adresse.',
                'PASSWORD_MANDATORY' => 'Bitte geben Sie ein Passwort an.',
                'PASSWORD_LENGTH' => 'Prüfen Sie bitte die Passwortlänge.',
                'PASSWORD_REPEAT_MANDATORY' => 'Bitte geben Sie ein Passwort an.',
                'PASSWORD_REPEAT_LENGTH' => 'Prüfen Sie bitte die Passwortlänge.',
                'GENDER_SELECT' => 'Bitte wählen Sie eine Anrede.',
                'GENDER_SELECT_BUSINESS' => 'Sie haben einen gewerblichen Tarif gewählt, bitte wählen Sie als Anrede Firma.',
                'GENDER_SELECT_PRIVATE' => 'Sie haben einen Privatkunden-Tarif gewählt, als Anrede ist Firma somit nicht möglich.',
                'TITLE_SELECT' => 'Bitte wählen Sie.',
                'COMPANY_MANDATORY' => 'Bitte geben Sie einen Firmennamen an.',
                'COMPANY_LENGTH' => 'Sie dürfen max. 50 Zeichen verwenden.',
                'FIRSTNAME_MANDATORY' => 'Bitte geben Sie Ihren Vornamen an.',
                'FIRSTNAME_LENGTH' => 'Der Vorname muss 2-50 Zeichen lang sein.',
                'FIRSTNAME_INVALID_CHARS' => 'Sie haben ungültige Zeichen verwendet.',
                'LASTNAME_MANDATORY' => 'Bitte geben Sie Ihren Nachnamen an.',
                'LASTNAME_LENGTH' => 'Der Nachname muss 2-50 Zeichen lang sein.',
                'LASTNAME_INVALID_CHARS' => 'Sie haben ungültige Zeichen eingegeben.',
                'ADDRESSEXTRA_MANDATORY' => 'Bitte geben Sie einen Adresszusatz an.',
                'ADDRESSEXTRA_LENGTH' => 'Sie dürfen max. 10 Zeichen verwenden.',
                'MOVEIN_SELECT' => 'Bitte wählen Sie.',
                'BILL_DIFF_ADDRESS_SELECT' => 'Bitte wählen Sie.',
                'MOVEIN_FIRST_TIME_USE_SELECT' => 'Bitte wählen Sie.',
                'BILL_GENDER_SELECT' => 'Bitte wählen Sie.',
                'BILL_COMPANY_MANDATORY' => 'Geben Sie einen Firmennamen an.',
                'BILL_COMPANY_LENGTH' => 'Sie dürfen max. 50 Zeichen verwenden.',
                'BILL_TITLE_SELECT' => 'Bitte wählen Sie.',
                'BILL_ADDRESSEXTRA_MANDATORY' => 'Bitte geben Sie einen Adresszusatz an.',
                'BILL_ADDRESSEXTRA_LENGTH' => 'Sie dürfen max. 10 Zeichen verwenden.',
                'BILL_STREET_MANDATORY' => 'Bitte geben Sie eine Straße an.',
                'BILL_STREET_LENGTH' => 'Die Straße darf 1-255 Zeichen lang sein.',
                'BILL_CITY_SELECT' => 'Bitte wählen Sie einen Ort.',
                'PHONE_LENGTH' => 'Eine Telefonnummer darf 1-15 Zeichen lang sein.',
                'PHONEPREFIX_LENGTH' => 'Eine Vorwahl darf 4-6 Zeichen lang sein.',

                'INSUREADDRESSDIFFERS_SELECT' => 'Bitte wählen Sie.',
                'INSURE_GENDER_SELECT' => 'Bitte wählen Sie eine Anrede.',
                'INSURE_FIRSTNAME_MANDATORY' => 'Bitte geben Sie einen Vornamen an.',
                'INSURE_FIRSTNAME_LENGTH' => 'Der Vorname muss 2-50 Zeichen lang sein.',
                'INSURE_LASTNAME_MANDATORY' => 'Bitte geben Sie einen Nachnamen an.',
                'INSURE_LASTNAME_LENGTH' => 'Der Nachname muss 2-50 Zeichen lang sein.',
                'INSURE_FIRSTNAME_CHILD_MANDATORY' => 'Bitte geben Sie den Vornamen des Kindes an.',
                'INSURE_FIRSTNAME_CHILD_LENGTH' => 'Der Vorname des Kindes muss 2-50 Zeichen lang sein.',
                'INSURE_LASTNAME_CHILD_MANDATORY' => 'Bitte geben Sie den Nachnamen des Kindes an.',
                'INSURE_LASTNAME_CHILD_LENGTH' => 'Der Nachname des Kindes muss 2-50 Zeichen lang sein.',
                'INSURE_BIRTHDATE_MANDATORY' => 'Bitte geben Sie ein Geburtsdatum an.',
                'INSURE_LEGAL_AGE' => 'Der Versicherungsnehmer muss volljährig sein.',

                'STREETNUMBER_INVALID_CHARS' => 'Bitte prüfen Sie Ihre Eingabe.',
                'STREET_SELECT' => 'Bitte geben Sie Ihre Straße an.',
                'STREET_MANDATORY' => 'Bitte geben Sie Ihre Straße an.',
                'ZIPCODE_INVALID_CHARS' => 'Ungültige PLZ.',
                'ZIPCODE_MANDATORY' => 'Bitte geben Sie Ihre PLZ an.',
                'MOVEIN_DATE_SELECT' => 'Bitte wählen Sie ein Neueinzugsdatum.',
                'PHONE_MANDATORY' => 'Bitte geben Sie Ihre Mobilnummer an.',
                'PHONEPREFIX_MANDATORY' => 'Bitte geben Sie Ihre Vorwahl an.',
                'MOBILE_MANDATORY' => 'Geben Sie eine Rufnummer an.',
                'MOBILEPREFIX_MANDATORY' => 'Geben Sie eine Vorwahl an.',
                'BILL_FIRSTNAME_MANDATORY' => 'Bitte geben Sie einen Vornamen an.',
                'BILL_LASTNAME_MANDATORY' => 'Bitte geben Sie einen Nachnamen an.',
                'BILL_STREETNUMBER_MANDATORY' => 'Bitte geben Sie eine Hausnummer an.',
                'BILL_STREETNUMBER_INVALID_CHARS' => 'Bitte prüfen Sie Ihre Eingabe.',
                'BILL_ZIPCODE_MANDATORY' => 'Bitte geben Sie eine PLZ an.',
                'BILL_CITY_MANDATORY' => 'Bitte geben Sie einen Ort an.',
                'BILL_EMAIL_MANDATORY' => 'Bitte geben Sie eine E-Mail-Adresse an.',
                'BILL_PHONE_MANDATORY' => 'Geben Sie eine Rufnummer an.',
                'BILL_PHONEPREFIX_MANDATORY' => 'Geben Sie eine Vorwahl an.',
                'BILL_MOBILE_MANDATORY' => 'Geben Sie eine Rufnummer an.',
                'BILL_MOBILEPREFIX_MANDATORY' => 'Geben Sie eine Vorwahl an.',
                'BIRTHDATE_MANDATORY' => 'Bitte geben Sie ein Geburtsdatum an.',
                'BILL_BIRTHDATE_MANDATORY' => 'Bitte geben Sie ein Geburtsdatum an.',
                'STREETNUMBER_MANDATORY' => 'Bitte geben Sie Ihre Hausnummer an.',
                'BILL_EMAIL_INVALID_CHARS' => 'Sie haben ungültige Zeichen in der E-Mail-Adresse.',
                'BIRTHDATE_SELECT' => 'Bitte geben Sie ein gültiges Geburtsdatum an.',
                'EMAIL_INVALID_CHARS' => 'Ungültige E-Mail-Adresse.',

                'BILL_STREET_SELECT' => 'Bitte geben Sie eine Straße an.',
                'STREETNUMBER_LENGTH' => 'Sie dürfen max. 7 Zeichen verwenden.',

                'LEGALFORM_SELECT' => 'Bitte wählen Sie eine Geschäftsform aus.',
                'COMPANY_REGISTER_NUMBER_PREFIX_SELECT' => 'Bitte wählen Sie den Präfix Ihrer Handelsregisternummer aus.',
                'COMPANY_REGISTER_NUMBER_MANDATORY' => 'Bitte geben Sie die Handelsregisternummer Ihrer Firma an.',
                'COMPANY_REGISTER_NAME_MANDATORY' => 'Bitte geben Sie das zuständige Handelsgericht an.',
                'CONTACT_GENDER_SELECT' => 'Bitte geben Sie die Anrede der Kontaktperson in Ihrer Firma an.',

                'COMPANY_REGISTER_TYPE_SELECT' => 'Bitte wählen Sie eine Handelsregisterart aus.',
                'COMPANY_REGISTER_TYPE_MANDATORY' => 'Bitte wählen Sie eine Handelsregisterart aus.',

                'COMPANY_VAT_NUMBER_LENGTH' => 'Kann mit DE beginnen und muss 9 Zahlen aufweisen.',
                'COMPANY_VAT_NUMBER_MANDATORY' => 'Bitte USt-IdNr. (Umsatzsteuer-Identifikationsnummer) angeben.',
                'COMPANY_VAT_NUMBER_INVALID_CHARS' => 'Kann mit DE beginnen und muss 9 Zahlen aufweisen.',

                'COMPANY_TAX_NUMBER_LENGTH' => 'Bitte nur 6 bis 20 Zeichen: 1-9, /, Leerzeichen.',
                'COMPANY_TAX_NUMBER_MANDATORY' => 'Bitte Steuernummer angeben.',

                'CONTACT_POSITION_SELECT' => 'Bitte wählen Sie Ihre Position aus.',
                'CONTACT_POSITION_MANDATORY' => 'Bitte geben Sie Ihre Position an.',
                'CONTACT_POSITION_LENGTH' => 'Kann mit DE beginnen und muss 9 Zahlen aufweisen.',

                // Step bank

                'BANK_CODE_INVALID' => 'Geben Sie eine gültige Bankleitzahl an.',
                'BANK_CODE_BANK_NOT_FOUND' => 'Es konnte keine Bank gefunden werden.',
                'BANK_CODE_ONLY_NUMBERS_ALLOWED' => 'Eine BLZ besteht nur aus Zahlen.',
                'ACCOUNT_NUMBER_INVALID_CHARS' => 'Sie haben ungültige Zeichen verwendet.',
                'ACCOUNT_NUMBER_TOO_SHORT' => 'Ihre Kontonummer ist zu kurz.',
                'ACCOUNT_NUMBER_TOO_LONG' => 'Ihre Kontonummer ist zu lang.',
                'ACCOUNTNUMBER_MANDATORY' => 'Bitte geben Sie eine Kontonummer an.',
                'BANKCODE_MANDATORY' => 'Bitte geben Sie eine Bankleitzahl an.',
                'ACCOUNTNUMBER_INVALID' => 'Ungültige Kontonummer',
                'ACCOUNTOWNER_LASTNAME_MANDATORY' => 'Bitte geben Sie einen Nachnamen an.',
                'ACCOUNTOWNER_FIRSTNAME_MANDATORY' => 'Bitte geben Sie einen Vornamen an.',
                'ACCOUNTOWNER_ZIPCODE_MANDATORY' => 'Bitte die PLZ des Kontoinhabers vervollständigen.',
                'ACCOUNTOWNER_CITY_SELECT' => 'Bitte die Stadt des Kontoinhabers vervollständigen.',
                'ACCOUNTOWNER_STREET_MANDATORY' => 'Bitte die Straße des Kontoinhabers vervollständigen.',
                'ACCOUNTOWNER_STREETNUMBER_MANDATORY' => 'Bitte die Hausnummer des Kontoinhabers vervollständigen.',
                'DEBT_ORDER_MANDATORY' => 'Sie müssen zustimmen, um fortfahren zu können.',
                'PAYMENTTYPE_MANDATORY' => 'Bitte geben Sie eine Zahlweise an.',
                'PAYMENTTYPE_SELECT' => 'Bitte wählen Sie eine Zahlweise aus.',
                'BILL_ZIPCODE_INVALID_CHARS' => 'Bitte geben Sie eine gültige PLZ ein.',
                'BANK_AUTH_KOMBI_MANDATORY' => 'Bitte bestätigen Sie die Erlaubnis zum Lastschriftverfahren.',
                'BANK_AUTH_SEPA_MANDATORY' => 'Bitte bestätigen Sie die Erlaubnis zum Lastschriftverfahren.',
                'BANK_AUTH_CLASSIC_MANDATORY' => 'Bitte bestätigen Sie die Erlaubnis zum Lastschriftverfahren.',

                // C24login

                'EMAIL_LENGTH' => 'Sie dürfen max. 255 Zeichen verwenden.',
                'EMAIL_NOT_FOUND' => 'Bei der Eingabe Ihrer E-Mail-Adresse/Ihres Passworts ist ein Fehler aufgetreten. Bitte versuchen Sie es erneut.',
                'BIRTHDATE_INVALID' => 'Bitte geben Sie ein gültiges Geburtsdatum an.',
                'EMAIL_USER_ACCOUNT_NOT_FOUND' => 'Bei der Eingabe Ihrer E-Mail-Adresse/Ihres Passworts ist ein Fehler aufgetreten. Bitte versuchen Sie es erneut.',
                'EMAIL_REPEAT_NOT_CONTAIN_EMAIL' => 'Die E-Mail-Adressen stimmen nicht überein.',
                'PASSWORD_REPEAT_NOT_CONTAIN_PASSWORD' => 'Die Passwörter stimmen nicht überein.',
                'PASSWORD_ANSWER_MANDATORY' => 'Bitte geben Sie eine Antwort auf die Sicherheits-Frage an.',
                'USER_ACCOUNT_BLOCKED' => 'Dieses CHECK24 Kundenkonto ist zur Zeit gesperrt.',

                // Online offine

                'SUBSCRIPTIONTYPE_MANDATORY' => 'Bitte wählen Sie einen Abschlussweg.',
                'SUBSCRIPTIONTYPE_SELECT' => 'Bitte wählen Sie.',

                // Overview

                'NEWSLETTER_MANDATORY' => 'Bitte geben Sie an, ob Sie einen Newsletter erhalten wollen.',
                'AGB_TARIFF_READ_MANDATORY' => 'Sie müssen den Tarif AGBs zustimmen, um fortfahren zu können.',
                'ACCEPT_CONDITIONS_MANDATORY' => 'Sie müssen den Bedingungen zustimmen, um fortfahren zu können.',
                'AGB_TARIFF_READ_AGREE' => 'Sie müssen den Tarif AGBs zustimmen, um fortfahren zu können.',
                'AGB_READ_AGREE' => 'Sie müssen den CHECK24 AGBs zustimmen, um fortfahren zu können.',
                'ACCEPT_CONDITION_AGREE' => 'Sie müssen den Bedingungen zustimmen, um fortfahren zu können.',

                // Energy Detail

                'FORMATION_MANDATORY' => 'Bitte Gründungsdatum des Unternehmens eingeben.',

            );

            /**
             * Translate token
             *
             * @param string $token Token
             * @return string
             */
            public static function t($token) {

                \shared\classes\common\utils::check_string($token, 'token');

                $t = strtoupper($token);

                if (!isset(self::$token_set[$t])) {

                    // Mostly are now invalid tokens interface spec. stuff and we later fix this to tokens
                    return $token;

                }

                return self::$token_set[$t];

            }

        }

    }
