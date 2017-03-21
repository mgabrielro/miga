<?php

    namespace classes;

    use \shared\classes\common\exception;

    /**
     * provider
     *
     * Class which represents a provider.
     *
     * @author Stefan Becker
     * @copyright rapidsoft GmbH
     *
     *
     */
    class provider extends \rs_dataobject {

        protected $id = 0;
        protected $name = '';
        protected $synonyms = '';
        protected $versions = 0;
        protected $product_id = '';
        protected $foreign_id = '';
        protected $visible = '';
        protected $analyseresult = 'yes';
        protected $efeedback_award_url = '';
        protected $contact_email = '';
        protected $contact_email_cc = '';
        protected $company_id = NULL;

        protected $version_id = 0;
        protected $validfrom = '';
        protected $validto = '';
        protected $topmonthfrom = '';
        protected $topmonthto = '';
        protected $topmonthurl_power = '';
        protected $topmonthurl_gas = '';
        protected $brand = '';
        protected $brand_provider_id = 0;
        protected $company = '';
        protected $street = '';
        protected $zipcode = '';
        protected $city = '';
        protected $phone = '';
        protected $phone_info = '';
        protected $fax = '';
        protected $email = '';
        protected $leadtransfer_email_test = '';
        protected $leadtransfer_email_productive = '';
        protected $website = '';
        protected $description = '';
        protected $description_pid_other = '';
        protected $description_evaluation = '';
        protected $internal_comment = '';
        protected $withdrawal_address = '';
        protected $cancelation_address = '';
        protected $cancelation_fax = '';
        protected $cancelation_email = '';
        protected $city_description = '';
        protected $city_picture_copyright = '';
        protected $reseller = 'no';
        //protected $logo_salt = 'rs!rocks';
        protected $logo_dir;
        protected $logo = '';
        protected $logo_type = '';

        protected $created = '';
        protected $updated = '';
        protected $status = 'active';
        protected $alternative_billaddress = 'yes';
        protected $owner_more = 'no';
        protected $phpclass = '';
        protected $guidelinematch = '';
        protected $result_grouping = '';
        protected $comparename = '';

        protected $power_max_amount_net = 0;
        protected $power_cancelation_question = 'no';
        protected $power_cancelation_in_month = 'no';
        protected $power_delivery_question = 'no';
        protected $power_delivery_day = 0;
        protected $power_delivery_months = 0;
        protected $power_delivery_workdays = 0;
        protected $power_delivery_in_month = 'no';

        protected $version_list = array();

        protected $cancelation_question = 'no';
        protected $password_question = '';

        protected $bindingoffer = 0;

        protected $leadtransfer_applications_mandatory = 'no';

        protected $mobile_footnotes = '';

        protected $imprint = '';
        protected $show_imprint = 'no';

        protected $auto_tariff_selection = 'no';

        protected $cancelationrate = 0;

        protected $efeedback_ids = '';

        protected $efeedback_review_id = '';

        /**
         * Constructor
         *
         * @param integer $id Master id of provider (provider_id in provider table)
         * @param integer $version_id Version idof provider (providerversion_id in providerversin table)
         * @param boolean $load_last_version If set to true the last version will be loaded IF NO "current" version could be loaded
         * @return void
         */
        public function __construct($id = 0, $version_id = 0, $load_last_version = false) {

            check_int($id, 'id', true);
            check_int($version_id, 'version_id', true);
            check_bool($load_last_version, 'load_last_version');

            $this->db = \vv\db::core_m();

            if ($id != 0 || $version_id != 0) {
                $this->load($id, $version_id, $load_last_version);
            }

        }


        /**
         * Sanitize Filename
         *
         * @param string $string Sanitize string for directory/file name
         *
         * @return string
         */
        protected function sanitize_filename($string) {
            $string = transliterator_transliterate('Any-Latin; Latin-ASCII; Lower()', $string);
            return preg_replace ('/[^0-9a-zA-Z]+/', '-', $string);
        }

        /**
         * Set logo directory
         *
         * @param string $name Set logo dirname
         * @param integer $id Provider id
         *
         * @return void
         */
        public function set_logo_dir($name, $id) {

            check_int($id, 'id', true);
            check_string($name, 'id', true);
            $this->logo_provider_dir = $this->sanitize_filename($name);
            $this->logo_dir = $this->logo_provider_dir . '/' . $id;

            $dirprovider = get_config('paths/filestore_web') . 'provider_logo/' . $this->get_logo_provider_dir();
            $dirname = get_config('paths/filestore_web') . 'provider_logo/' . $this->get_logo_dir();

            if (!file_exists($dirprovider)) {

                if (!mkdir($dirprovider)) {

                    $this->logo_provider_dir = '';
                    throw new \Exception('Failed to create Provider logodir: ' . $dirprovider);

                } else {

                    if (!file_exists($dirname)) {

                        if (!mkdir($dirname)) {

                            $this->logo_dir = '';
                            throw new \Exception('Failed to create logodir: ' . $dirname);

                        }

                    }

                }

            }

        }

        /**
         * Get logo dir
         *
         * @return string Logo dir
         */
        protected function get_logo_dir() {

            if (empty($this->logo_provider_dir)) {
                $this->set_logo_dir($this->name, $this->id);
            }

            return $this->logo_provider_dir . '/' . $this->get_version_id();

        }

        /**
         * Get provider logo dir
         *
         * @return Provider logo dir
         */
        protected function get_logo_provider_dir() {
            return $this->logo_provider_dir;
        }

        /**
         * Changes the logo folder name
         *
         * @param string $oldname Old folder name
         * @param string $newname New folder name
         *
         * @return void
         */
        public function change_logo_dir($oldname, $newname) {

            $oldname = $this->sanitize_filename($oldname);
            $newname = $this->sanitize_filename($newname);
            $dirold = get_config('paths/filestore_web') . 'provider_logo/' . $oldname;
            $dirnew = get_config('paths/filestore_web') . 'provider_logo/' . $newname;

            if (file_exists($dirold) && $dirold != $dirnew) {
                @rename($dirold, $dirnew);
            }

        }

        /**
         * Saves a logo file
         *
         * @param string $filename Filename to use
         * @param string $location Location where to save the file
         * @throws exception\argument Throws an exception if the file does not exist
         * @return void
         */
        protected function save_file($filename, $location) {

            check_string($filename, 'filename');
            check_string($location, 'location');

            if (!empty($filename) && file_exists($filename) == false) {
                throw new exception\argument('File specified "' . $filename . '" does not exist');
            }

            // we need to delete previous logos before saving.
            // logos may exist in other format/extension
            $locationexplode = explode('.', $location);
            $lname = $locationexplode[0] . '.*'; // first element only, there shouldn't exist multiple dots in filename

            $pathinfo_local = pathinfo($filename);
            $lname = $pathinfo_local['filename'] . '*';

            foreach (glob($lname) AS $dfile) {
                rs_unlink($dfile, true);
            }

            copy($filename, $location);

            $pathinfo_filename = pathinfo($filename);
            $fname = $pathinfo_filename['filename'] . '*';

            foreach (glob($fname) AS $dfile) {
                rs_unlink($dfile, true);
            }

        }

        //-------------------------------------------------------
        // Logo handling
        //-------------------------------------------------------

        /**
         * Returns if a logo exists
         *
         * @param integer $providerversion_id Providerversion id (empty for current)
         * @param string $filename_flag Filename Flag
         *
         * @return boolean
         */
        public function get_logo_exist($providerversion_id = 0, $filename_flag = "") {

            check_int($providerversion_id, 'providerversion_id', true);
            $isex = (file_exists($this->get_logo_location($providerversion_id, $filename_flag))
                    && is_file($this->get_logo_location($providerversion_id, $filename_flag)));
            return $isex;

        }

        /**
         * Get logo location
         *
         * @param integer $providerversion_id Providerversion id (empty for current)
         * @param string $filename_flag Additional filename extensions (without "_" )
         *
         * @return string
         */
        public function get_logo_location($providerversion_id = 0, $filename_flag = "") {

            check_int($providerversion_id, 'providerversion_id', true);
            check_string($filename_flag, 'filename_flag', true);

            if ($providerversion_id == 0) {
                $providerversion_id = $this->get_version_id();
            }

            if (strlen($filename_flag) > 0) {
                $fflag =  '_' . $filename_flag;
                $logo_filename = 'logo' . $fflag . '.png';
            } else {
                $logo_filename = 'logo.svg';
            }

            return get_config('paths/filestore_web') . 'provider_logo/' . $this->get_logo_dir() . '/' .  $logo_filename;

        }


        /**
         * Get logo url
         *
         * @param integer $providerversion_id Providerversion id (empty for current)
         * @param string $filename_flag Filename flag
         *
         * @return string Logo URL
         */
        public function get_logo_url($providerversion_id = 0, $filename_flag = "") {

            check_int($providerversion_id, 'providerversion_id', true);
            check_string($filename_flag, 'filename_flag', true);

            if ($providerversion_id == 0) {
                $providerversion_id = $this->get_version_id();
            }

            if (strlen($filename_flag) > 0) {
                $fflag =  '_' . $filename_flag;
                $logo_filename = 'logo' . $fflag . '.png';
            } else {
                $logo_filename = 'logo.svg';
            }

            $logo_url = '';

            try {
                $logo_url = get_config('urls/filestore_web') . 'provider_logo/' . $this->get_logo_dir() . '/' .  $logo_filename;
            } catch (\Exception $ex) {
                \vv\scribe::log('default', 'Exception durign generating provider url for providerversion_id: ' . $providerversion_id . '! ' . $ex->getMessage());
            }

            if ($this->get_logo_exist($providerversion_id)) {
                return add_cdn($logo_url);
            } else {

                // here the provider logo has not been found
                // as this value is being used as img src, no exception/html should be returned
                \vv\scribe::log('default', '');
                return '';

            }

        }

        /**
         * Save logo
         *
         * @param array $vld_file_array Array with file data from POST upload
         *
         * @throws exception\argument Throws an exception if file does not exist.
         * @return void
         */
        public function logo_save($vld_file_array) {

            check_array($vld_file_array, 'vld_file_array', false);
            $this->logo_type = strtolower(end(preg_split('/\./', $vld_file_array['name'])));
            $this->save_file($vld_file_array['tmp_name'], $this->get_logo_location());

            // resize/regenerate various logos
            $this->create_logos($this->get_logo_location());

        }

        /**
         * Create logos in different resolutions
         *
         * @param string $logo Logo filename
         * @throws exception Imagick Exception
         *
         * @return void
         */
        public function create_logos($logo) {

            try {

                $im = new \Imagick();
                $im->setBackgroundColor(new \ImagickPixel('transparent'));
                $im->readImageBlob(file_get_contents($logo));
                $im->setImageFormat('PNG32');

                $sizes = array (array('maxwidth' => 115, 'maxheight' => 40), //result list
                                array('maxwidth' => 150, 'maxheight' => 50)); // comparison, register

                foreach ($sizes AS $size) {

                    $imclone = clone($im);

                    $imclone->scaleImage($size['maxwidth'], 0);

                    $height = $imclone->getImageHeight();

                    if ($height > $size['maxheight']) {
                        $imclone = clone($im);
                        $imclone->scaleImage(0, $size['maxheight']);
                    }

                    $vheight = $imclone->getImageHeight();
                    $dstfile = get_config('paths/filestore_web') . 'provider_logo/' . $this->get_logo_dir() . '/logo_w' . $size['maxwidth'] . '.png';

                    if ($f = fopen($dstfile, 'w')) {
                        $imclone->writeImageFile($f);
                    }

                }

            } catch (\ImagickException $e) {
                throw new \ImagickException($e);
            }

        }


        /**
         * Save withdrawal pdf
         *
         * @param array $vld_file_array Array with file data from POST upload
         * @return void
         */
        public function withdrawal_pdf_save($vld_file_array) {

            check_array($vld_file_array, 'vld_file_array', false);
            $this->save_file($vld_file_array['tmp_name'], $this->get_withdrawal_pdf_location());

        }

        /**
         * Check if withdrawal pdf exists
         *
         * @param integer $providerversion_id Providerversion id
         * @return boolean
         */
        public function get_withdrawal_pdf_exist($providerversion_id = 0) {
            return file_exists($this->get_withdrawal_pdf_location($providerversion_id));
        }

        /**
         * Get withdrawal pdf location
         *
         * @param integer $providerversion_id Providerversion id (empty for current)
         *
         * @return string
         */
        public function get_withdrawal_pdf_location($providerversion_id = 0) {

            check_int($providerversion_id, 'providerversion_id', true);

            if ($providerversion_id == 0) {
                $providerversion_id = $this->get_version_id();
            }

            return get_config('paths/filestore_web') . 'provider_terms/' . md5($providerversion_id . 'rs!rocks') . '_withdrawal.pdf';

        }

        /**
         * Get withdrawal pdf url
         *
         * @param integer $providerversion_id Providerversion id (empty for current)
         *
         * @return string
         */
        public function get_withdrawal_pdf_url($providerversion_id = 0) {

            check_int($providerversion_id, 'providerversion_id', true);

            if ($providerversion_id == 0) {
                $providerversion_id = $this->get_version_id();
            }

            return add_cdn(get_config('urls/filestore_web') . 'provider_terms/' . md5($providerversion_id . 'rs!rocks') . '_withdrawal.pdf');

        }

        /**
         * Delete withdrawal pdf
         *
         * @return void
         */
        public function withdrawal_pdf_delete() {
            rs_unlink($this->get_withdrawal_pdf_location(), true);
        }



        //-------------------------------------------------------
        // Terms (PDF) handling
        //-------------------------------------------------------

        /**
         * Returns true when there are terms present
         *
         * @param integer $providerversion_id Providerversion_id (empty for current)
         *
         * @return boolean
         */
        public function get_terms_exist($providerversion_id = 0) {

            check_int($providerversion_id, 'providerversion_id', true);

            return file_exists($this->get_terms_location($providerversion_id));

        }

        /**
         * Get an accessible path to the provider terms
         *
         * @return string
         */
        public function get_terms_url() {
            return get_config('baseurl') . 'filestore/provider_terms/' . md5($this->get_version_id() . 'rs$rocks') . '.pdf';
        }

        /**
         * Get the filename with path from the provider terms
         *
         * @param integer $providerversion_id Providerversion id (empty for current)
         *
         * @return string
         */
        public function get_terms_location($providerversion_id = 0) {

            check_int($providerversion_id, 'providerversion_id', true);

            if ($providerversion_id == 0) {
                $providerversion_id = $this->get_version_id();
            }

            return get_config('paths/filestore_web') . 'provider_terms/' . md5($providerversion_id . 'rs$rocks') . '.pdf';

        }

        /**
         * Adds a new synonym of the provider name and returns the list of all synonyms.
         *
         * @param string $synonym Provider synonym
         * @return array
         */
        public function add_synonym($synonym) {

            check_string($synonym, 'synonym');
            $this->synonyms .= ';' . $synonym;

            return $this->get_synonyms();

        }

        /**
         * Returns the list of all currently defined provider name synonyms.
         *
         * @return array
         */
        public function get_synonyms() {
            return array_map('trim', explode(';', $this->synonyms));
        }

        /**
         * Delete saved terms physically
         *
         * @return void
         */
        public function terms_delete() {
            rs_unlink($this->get_terms_location(), true);
        }

        /**
         * Save provider terms
         *
         * @param array $vld_file_array Array with file data from POST upload
         *
         * @throws exception\argument Throws exception if file does not exists
         * @return boolean
         */
        public function terms_save($vld_file_array) {

            check_array($vld_file_array, 'vld_file_array', false);

            if (!empty($vld_file_array['tmp_name']) && file_exists($vld_file_array['tmp_name']) == false) {
                throw new exception\argument('File specified "' . $vld_file_array['tmp_name'] . '" does not exist');
            }

            $targetfile = $this->get_terms_location();

            @rs_unlink($targetfile, true);

            // Automatic convert using pdftk. Open document and cat all pages
            // into new document. cat-operation creates new file without compressed
            // xref or other "special" items that fpdi does not implement

            $output = '';
            $return_value = '';

            exec('/usr/bin/pdftk A=' . $vld_file_array['tmp_name'] . ' cat A1-end output ' . $targetfile, $output, $return_value);

            if (file_exists($targetfile) == true) {
                return true;
            } else { // Fallback convert did not work take original file and move it
                $return = rename($vld_file_array['tmp_name'], $targetfile);
            }

            return $return;

        }

        //-------------------------------------------------------
        // Dataobject / versioning
        //-------------------------------------------------------

        /**
         * Saves object members to database
         *
         * @param boolean $versioning Save as new version or not
         *
         * @return void
         */
        public function save($versioning = false) {

            check_bool($versioning, 'versioning');

            $trx = $this->get_db()->trx();

            $field_names = array('synonyms', 'validfrom', 'validto', 'topmonthfrom',
                                 'topmonthto', 'topmonthurl_power', 'topmonthurl_gas',
                                 'company', 'street', 'zipcode',
                                 'city', 'phone', 'phone_info',
                                 'fax', 'email', 'internal_comment',
                                 'leadtransfer_email_test', 'leadtransfer_email_productive',
                                 'website', 'description', 'description_pid_other', 'city_description',
                                 'description_evaluation',
                                 'withdrawal_address', 'cancelation_address', 'cancelation_fax',
                                 'cancelation_email', 'city_picture_copyright', 'reseller',
                                 'phpclass', 'alternative_billaddress',
                                 'owner_more', 'status',
                                 'power_max_amount_net', 'power_cancelation_question',
                                 'power_delivery_question', 'power_delivery_day', 'power_delivery_workdays', 'power_delivery_in_month',
                                 'power_delivery_months',
                                 'cookiedrop_result', 'cookiedrop_checkedresult',
                                 'cookiedrop_register', 'cookiedrop_provider', 'cookiedrop_tariffdetail',
                                 'cookiedrop_tariffcompare', 'cookiedrop_availabilitycheck', 'cookiedrop_providerevaluation',
                                 'cancelation_question', 'password_question', 'bindingoffer', 'guidelinematch',
                                 'leadtransfer_applications_mandatory',
                                 'mobile_footnotes', 'brand', 'result_grouping', 'brand_provider_id',
                                 'imprint', 'show_imprint',
                                 'power_cancelation_in_month', 'comparename', 'auto_tariff_selection',
            );


            if ($this->id == 0) {

                // First save
                //
                // Save parent and one version

                $data = $this->to_array(array('name', 'product_id', 'foreign_id', 'visible', 'analyseresult', 'efeedback_award_url', 'contact_email', 'contact_email_cc', 'company_id', 'efeedback_ids', 'efeedback_review_id'), NULL, NULL, 'provider_');

                if ($data['provider_company_id'] == '') {
                    $data['provider_company_id'] = NULL;
                }

                $this->get_db()->insert_query('provider', $data);
                $this->id = $this->get_db()->insert_id();

                $data = $this->to_array($field_names, NULL, NULL, 'providerversion_');

                $data['providerversion_provider_id'] = $this->id;
                $data['.providerversion_created'] = 'NOW()';
                $data['.providerversion_updated'] = 'NOW()';

                if ($data['providerversion_validto'] == '') {
                    $data['providerversion_validto'] = NULL;
                }

                if (empty($data['providerversion_power_max_amount_net'])) {
                    $data['providerversion_power_max_amount_net'] = NULL;
                }

                if ($data['providerversion_brand_provider_id'] == '') {
                    $data['providerversion_brand_provider_id'] = NULL;
                }

                if ($data['providerversion_comparename'] == '') {
                    $data['providerversion_comparename'] = NULL;
                }

                /*
                To avoid unexpected problems this is currently disabled
                due to previous fail value assignment ($var == '').

                if ($data['providerversion_phpclass'] == NULL) {
                    $data['providerversion_phpclass'] = '';
                }
                */

                $this->get_db()->insert_query('providerversion', $data);
                $this->version_id = $this->get_db()->insert_id();

                // Provider fields

                $pf = new \vv\register\providerfields(
                    $this->version_id, new \vv\register\dal\providerfields()
                );

                $pf->load_defaults();
                $pf->save();

            } else {

                if ($versioning) {

                    // Save parent

                    $data = $this->to_array(array('name', 'visible', 'analyseresult', 'efeedback_award_url', 'contact_email', 'contact_email_cc', 'company_id', 'efeedback_ids', 'efeedback_review_id'), NULL, NULL, 'provider_');

                    if ($data['provider_company_id'] == '') {
                        $data['provider_company_id'] = NULL;
                    }

                    $this->get_db()->update_query('provider', $data, 'provider_id = ' . $this->id);

                    // Save as new \vv\version

                    $data = $this->to_array($field_names, NULL, NULL, 'providerversion_');

                    $data['providerversion_provider_id'] = $this->id;
                    $data['.providerversion_created'] = 'NOW()';
                    $data['.providerversion_updated'] = 'NOW()';

                    if ($data['providerversion_validto'] == '') {
                        $data['providerversion_validto'] = NULL;
                    }

                    if (empty($data['providerversion_power_max_amount_net'])) {
                        $data['providerversion_power_max_amount_net'] = NULL;
                    }

                    if ($data['providerversion_brand_provider_id'] == '') {
                        $data['providerversion_brand_provider_id'] = NULL;
                    }

                    if ($data['providerversion_comparename'] == '') {
                        $data['providerversion_comparename'] = NULL;
                    }

                    $this->get_db()->insert_query('providerversion', $data);

                    $old_version_id = $this->version_id;
                    $this->version_id = $this->get_db()->insert_id();

                    // Provider fields
                    \vv\register\providerfields::copy_db(
                        $old_version_id, $this->version_id,
                        new \vv\register\dal\providerfields()
                    );

                    // Files

                    if ($this->get_terms_exist($old_version_id)) {
                        @copy($this->get_terms_location($old_version_id), $this->get_terms_location($this->version_id));
                    }

                    if ($this->get_logo_exist($old_version_id)) {
                        @copy($this->get_logo_location($old_version_id), $this->get_logo_location($this->version_id));
                    }

                    // auto align

                    $this->auto_align();

                    // Testing

                    $this->test();

                    // Callback if a new \vv\pv\pkv\tariff is created

                    $this->handle_new_version($old_version_id);

                } else {

                    // Save parent

                    $data = $this->to_array(array('name', 'visible', 'analyseresult', 'efeedback_award_url', 'contact_email', 'contact_email_cc', 'company_id', 'efeedback_ids', 'efeedback_review_id'), NULL, NULL, 'provider_');

                    if ($data['provider_company_id'] == '') {
                        $data['provider_company_id'] = NULL;
                    }

                    $this->get_db()->update_query('provider', $data, 'provider_id = ' . $this->id);

                    // Do a hard update

                    $data = $this->to_array($field_names, NULL, NULL, 'providerversion_');

                    $data['.providerversion_updated'] = 'NOW()';

                    if ($data['providerversion_validto'] == '') {
                        $data['providerversion_validto'] = NULL;
                    }

                    if (empty($data['providerversion_power_max_amount_net'])) {
                        $data['providerversion_power_max_amount_net'] = NULL;
                    }

                    if ($data['providerversion_brand_provider_id'] == '') {
                        $data['providerversion_brand_provider_id'] = NULL;
                    }

                    if ($data['providerversion_comparename'] == '') {
                        $data['providerversion_comparename'] = NULL;
                    }

                    $this->get_db()->update_query('providerversion', $data, 'providerversion_id = ' . $this->version_id);

                    // auto align

                    $this->auto_align();

                    // Testing

                    $this->test();

                }

            }

            // Update datawarehouse
            \vv\datawarehouse\manager::update_provider($this);

            // commit

            $trx->complete();

        }

        /**
         * Auto aligning (see docs)
         *
         * @throws exception\logic Throws an exception if inconsistent data is given
         * @return void
         */
        public function auto_align() {

            check_int($this->version_id, 'this->version_id');

            $data = $this->get_db()->get_all('SELECT providerversion_id, providerversion_validfrom, providerversion_validto FROM providerversion WHERE providerversion_provider_id = ' . $this->id . ' AND providerversion_status = "active" ORDER BY providerversion_validfrom ASC');

            if ($data === NULL) {
                throw new exception\logic('Inconsistent data (id = ' . $this->id . ', version_id = ' . $this->version_id . ')');
            }

            $last_null_version_id = 0;

            for ($i = 0, $max = count($data); $i < $max; ++$i) {

                if ($last_null_version_id != 0) {
                    $this->get_db()->query('UPDATE providerversion SET providerversion_validto = "' . $data[$i]['providerversion_validfrom'] . '" - INTERVAL 1 SECOND, providerversion_updated = NOW() WHERE providerversion_id = ' . $last_null_version_id . ' AND "' . $data[$i]['providerversion_validfrom'] . '" - INTERVAL 1 MINUTE > providerversion_validfrom');
                    $last_null_version_id = 0;
                }

                if ($data[$i]['providerversion_validto'] === NULL) {
                    $last_null_version_id = $data[$i]['providerversion_id'];
                }

            }

        }

        /**
         * Loads object members with data from database
         *
         * @param integer $id Id
         * @param integer $version_id Version id
         * @param boolean $load_last_version If set to true the last version will be loaded IF NO "current" version could be loaded
         * @throws exception\logic Throws an exception he current provider has no version
         * @throws exception\argument Throws an exception if $id or $version_id does not match the criteria
         * @return boolean
         */
        public function load($id, $version_id, $load_last_version = false) {

            check_int($id, 'id', true);
            check_int($version_id, 'version_id', true);
            check_bool($load_last_version, 'load_last_version');

            if ($id == 0 && $version_id == 0) {
                throw new exception\argument('Either $id or $version_id has to be set');
            }

            if ($id != 0 && $version_id != 0) {
                throw new exception\argument('Only $id or $version_id can be set');
            }

            // Load by "main" id

            if ($id != 0) {

                $data = $this->get_db()->get_row('SELECT * FROM provider
                    LEFT JOIN providerversion ON (
                        provider_id = providerversion_provider_id
                        AND providerversion_validfrom <= NOW()
                        AND (providerversion_validto IS NULL OR providerversion_validto >= NOW())
                        AND providerversion_status = "active"
                    )

                    WHERE provider_id = ' . $id);

                if ($data === NULL) {
                    return false;
                }

                if ($data['providerversion_id'] != '') {

                    // "Current" version could be found

                    $this->set_version_id($data['providerversion_id']);
                    $this->fill($data, 'providerversion_');

                } else if ($load_last_version) {

                    // No "current" version found, load last one

                    $version_data = $this->get_db()->get_row('SELECT * FROM providerversion WHERE providerversion_provider_id = ' . $id . ' ORDER BY providerversion_validfrom DESC LIMIT 1');

                    if ($version_data === NULL) {
                        throw new exception\logic('Every provider should have at least one version');
                    }

                    $this->set_version_id($version_data['providerversion_id']);
                    $this->fill($version_data, 'providerversion_');

                }

                $this->set_id($data['provider_id']);
                $this->set_company_id($data['provider_company_id']);
                $this->set_product_id($data['provider_product_id']);
                $this->set_name($data['provider_name']);
                $this->set_visible($data['provider_visible']);
                $this->set_product_id($data['provider_product_id']);
                $this->set_versions($data['provider_versions']);
                $this->set_analyseresult($data['provider_analyseresult']);
                $this->set_efeedback_award_url($data['provider_efeedback_award_url']);
                $this->set_contact_email($data['provider_contact_email']);
                $this->set_contact_email_cc($data['provider_contact_email_cc']);
                $this->set_cancelationrate($data['provider_cancelationrate']);

                $this->set_efeedback_ids($data['provider_efeedback_ids']);
                $this->set_efeedback_review_id($data['provider_efeedback_review_id']);

            }

            // Load by version id

            if ($version_id != 0) {

                $data = $this->get_db()->get_row('SELECT * FROM providerversion INNER JOIN provider ON (providerversion_provider_id = provider_id) WHERE providerversion_id = ' . $version_id);

                if ($data === NULL) {
                    return false;
                }

                $this->set_version_id($data['providerversion_id']);
                $this->fill($data, 'providerversion_');
                $this->set_id($data['provider_id']);
                $this->set_company_id($data['provider_company_id']);
                $this->set_name($data['provider_name']);
                $this->set_visible($data['provider_visible']);
                $this->set_versions($data['provider_versions']);
                $this->set_product_id($data['provider_product_id']);
                $this->set_analyseresult($data['provider_analyseresult']);
                $this->set_efeedback_award_url($data['provider_efeedback_award_url']);
                $this->set_contact_email($data['provider_contact_email']);
                $this->set_contact_email_cc($data['provider_contact_email_cc']);
                $this->set_cancelationrate($data['provider_cancelationrate']);
                $this->set_efeedback_ids($data['provider_efeedback_ids']);
                $this->set_efeedback_review_id($data['provider_efeedback_review_id']);

            }

            // Cut seconds from valid range

            if ($this->validfrom != '') {
                $this->validfrom = substr($this->validfrom, 0, -3);
            }

            if ($this->validto != '') {
                $this->validto = substr($this->validto, 0, -3);
            }

            return true;

        }

        /**
         * Returns all versions as objects for this provider
         *
         * @throws exception\logic Throws an exception if the current object wasnt loaded before
         * @return array Array containing provider objects
         */
        public function get_version_list() {

            if ($this->get_id() == 0) {
                throw new exception\logic('Object not loaded');
            }

            if ($this->version_list === NULL) {
                return NULL;
            }

            if (count($this->version_list) == 0) {

                $data = $this->get_db()->get_all('SELECT * FROM providerversion WHERE providerversion_provider_id = ' . $this->get_id() . ' ORDER BY providerversion_validfrom DESC');

                if ($data !== NULL) {

                    for ($i = 0, $max = count($data); $i < $max; ++$i) {

                        $tmp = new \vv\provider();

                        $tmp->set_version_id($data[$i]['providerversion_id']);
                        $tmp->fill($data[$i], 'providerversion_');

                        $tmp->set_id($this->id);
                        $tmp->set_name($this->name);
                        $tmp->set_versions($this->versions);

                        $this->version_list[] = $tmp;

                    }

                } else {
                    $this->version_list = NULL;
                }

            }

            return $this->version_list;

        }


        /**
         * Runs a test on current provider
         *
         * @throws exception\logic Throws an exception if test failed
         * @return void
         */
        public function test() {

            check_int($this->id, 'this->id');

            $testing = new \vv\testing();

            $res = $testing->provider_aligning($this->id);

            if ($res !== true) {
                $testing->log_report();
                throw new exception\logic('Test failed');
            }

        }


        /**
         * Returns version timeline html
         *
         * @return string Html
         */
        public function get_version_timeline_html() {

            check_int($this->id, 'this->id');

            $versionchecking = new \vv\versionchecking();

            $data = $versionchecking->get_timeline_data($this->id, 'provider');

            if ($data === NULL) {
                return 'Keine Versionen vorhanden';
            }

            return $versionchecking->build_timeline_html($data, 'provider');

        }

        /**
         * Deletes a provider
         *
         * Currently this is only possible if the provider does not have any
         * tariffs.
         *
         * @return void
         */
        public function delete() {

            check_int($this->id, 'this->id');

            $count = $this->db->get_value('SELECT COUNT(*) FROM tariff WHERE tariff_provider_id = ' . $this->id);

            if ($count != 0) {
                return;
            }

            $trx = $this->db->trx();

            $versions = $this->db->get_all('SELECT providerversion_id FROM providerversion WHERE providerversion_provider_id = ' . $this->id, NULL, '', 'providerversion_id');

            for ($i = 0, $max = count($versions); $i < $max; ++$i) {

                $p = new \vv\provider(0, $versions[$i]);
                $p->terms_delete();

            }

            $this->db->query('DELETE FROM provider WHERE provider_id = ' . $this->id);
            $this->db->query('DELETE FROM providerversion WHERE providerversion_provider_id = ' . $this->id);

            $trx->complete();

        }

        /**
         * Returns formatted visible
         *
         * @return string
         */
        public function get_visible_f() {

            check_int($this->id, 'this->id');

            $filter = get_def('provider_visible');

            return $filter[$this->visible];

        }

        /**
         * Returns formatted visible
         *
         * @return string
         */
        public function get_visible_colored() {

            check_int($this->id, 'this->id');

            $filter = get_def('provider_visible');
            $html = $filter[$this->visible];

            if ($this->visible == 'yes') {
                $html = '<span style="font-weight: bold; color: #00C000">' . $html . '</span>';
            } else {
                $html = '<span style="font-weight: bold; color: #C00000">' . $html . '</span>';
            }

            return $html;

        }

        /**
         * Get the provider name
         *
         * @return string
         */
        public function get_name() {
            return $this->name;
        }

        /**
         * Get an url safe name
         *
         * @return string
         */
        public function get_name_urlsafe() {
            return format_url($this->get_name());
        }

        /**
         * Returns formatted status
         *
         * @return string
         */
        public function get_status_f() {

            check_int($this->id, 'this->id');

            $filter = get_def('status');

            return $filter[$this->status];

        }

        /**
         * Check topmonth dates to urls
         *
         * @param array $form_data Form data
         * @param \vv\provider $provider Provider
         * @return array
         */
        public static function check_topmonth_dates($form_data, $provider = NULL) {

            $db = \vv\db::core_m();

            check_array($form_data, 'form_data');
            check_object($provider, 'provider', '', true);

            if ($form_data['topmonthto'] != '' && $form_data['topmonthfrom'] > $form_data['topmonthto']) {
                return array('field' => 'topmonthto', 'error' => 'Datum muss vor "Bis" Datum liegen oder gleiches Datum sein');
            }

            // Check on collisions

            if (!empty($form_data['topmonthurl_power'])) {

                $from = $form_data['topmonthfrom'];
                $to = $form_data['topmonthto'];

                // Collision checking for provider

                $query = 'SELECT COUNT(*) FROM providerversion WHERE "' . $from . '" BETWEEN providerversion_topmonthfrom AND providerversion_topmonthto AND providerversion_status = "active" AND providerversion_topmonthurl_power != ""';

                if ($provider !== NULL) {
                    $query .= ' AND providerversion_id != ' . $provider->get_version_id();
                }

                $count = $db->get_value($query);

                if ($count != 0) {
                    return array('field' => 'topmonthfrom', 'error' => 'Datum kollidiert mit einer anderen Version');
                }

                $query = 'SELECT COUNT(*) FROM providerversion WHERE providerversion_topmonthfrom = "' . $from . '" AND providerversion_status = "active" AND providerversion_topmonthurl_power != ""';

                if ($provider !== NULL) {
                    $query .= ' AND providerversion_id != ' . $provider->get_version_id();
                }

                $count = $db->get_value($query);

                if ($count != 0) {
                    return array('field' => 'topmonthfrom', 'error' => 'Datum kollidiert mit einer anderen Version');
                }

                if ($to != '') {

                    $query = 'SELECT COUNT(*) FROM providerversion WHERE "' . $to . '" BETWEEN providerversion_topmonthfrom AND providerversion_topmonthto AND providerversion_status = "active" AND providerversion_topmonthurl_power != ""';

                    if ($provider !== NULL) {
                        $query .= ' AND providerversion_id != ' . $provider->get_version_id();
                    }

                    $count = $db->get_value($query);

                    if ($count != 0) {
                        return array('field' => 'topmonthto', 'error' => 'Datum kollidiert mit einer anderen Version');
                    }

                    $query = 'SELECT COUNT(*) FROM providerversion WHERE providerversion_topmonthfrom = "' . $to . '" AND providerversion_status = "active" AND providerversion_topmonthurl_power != ""';

                    if ($provider !== NULL) {
                        $query .= ' AND providerversion_id != ' . $provider->get_version_id();
                    }

                    $count = $db->get_value($query);

                    if ($count != 0) {
                        return array('field' => 'topmonthto', 'error' => 'Datum kollidiert mit einer anderen Version');
                    }

                    // Check if old version is between the new version we are checking for

                    $query = 'SELECT COUNT(*) FROM providerversion WHERE (providerversion_topmonthfrom BETWEEN "' . $from . '" AND "' . $to . '" OR providerversion_topmonthto BETWEEN "' . $from . '" AND "' . $to . '") AND providerversion_status = "active" AND providerversion_topmonthurl_power != ""';

                    if ($provider !== NULL) {
                        $query .= ' AND providerversion_id != ' . $provider->get_version_id();
                    }

                    $count = $db->get_value($query);

                    if ($count != 0) {
                        return array('field' => 'topmonthfrom', 'error' => 'Von-Bis überlappt eine andere Version');
                    }

                }

                return true;

            }

            if (!empty($form_data['topmonthurl_gas'])) {

                // Check existing provider version

                $from = $form_data['topmonthfrom'];
                $to = $form_data['topmonthto'];

                // Collision checking for provider

                $query = 'SELECT COUNT(*) FROM providerversion WHERE "' . $from . '" BETWEEN providerversion_topmonthfrom AND providerversion_topmonthto AND providerversion_status = "active" AND providerversion_topmonthurl_gas != ""';

                if ($provider !== NULL) {
                    $query .= ' AND providerversion_id != ' . $provider->get_version_id();
                }

                $count = $db->get_value($query);

                if ($count != 0) {
                    return array('field' => 'topmonthfrom', 'error' => 'Datum kollidiert mit einer anderen Version');
                }

                $query = 'SELECT COUNT(*) FROM providerversion WHERE providerversion_topmonthfrom = "' . $from . '" AND providerversion_status = "active" AND providerversion_topmonthurl_gas != ""';

                if ($provider !== NULL) {
                    $query .= ' AND providerversion_id != ' . $provider->get_version_id();
                }

                $count = $db->get_value($query);

                if ($count != 0) {
                    return array('field' => 'topmonthfrom', 'error' => 'Datum kollidiert mit einer anderen Version');
                }

                if ($to != '') {

                    $query = 'SELECT COUNT(*) FROM providerversion WHERE "' . $to . '" BETWEEN providerversion_topmonthfrom AND providerversion_topmonthto AND providerversion_status = "active" AND providerversion_topmonthurl_gas != ""';

                    if ($provider !== NULL) {
                        $query .= ' AND providerversion_id != ' . $provider->get_version_id();
                    }

                    $count = $db->get_value($query);

                    if ($count != 0) {
                        return array('field' => 'topmonthto', 'error' => 'Datum kollidiert mit einer anderen Version');
                    }

                    $query = 'SELECT COUNT(*) FROM providerversion WHERE providerversion_topmonthfrom = "' . $to . '" AND providerversion_status = "active" AND providerversion_topmonthurl_gas != ""';

                    if ($provider !== NULL) {
                        $query .= ' AND providerversion_id != ' . $provider->get_version_id();
                    }

                    $count = $db->get_value($query);

                    if ($count != 0) {
                        return array('field' => 'topmonthto', 'error' => 'Datum kollidiert mit einer anderen Version');
                    }

                    // Check if old version is between the new version we are checking for

                    $query = 'SELECT COUNT(*) FROM providerversion WHERE (providerversion_topmonthfrom BETWEEN "' . $from . '" AND "' . $to . '" OR providerversion_topmonthto BETWEEN "' . $from . '" AND "' . $to . '") AND providerversion_status = "active" AND providerversion_topmonthurl_gas != ""';

                    if ($provider !== NULL) {
                        $query .= ' AND providerversion_id != ' . $provider->get_version_id();
                    }

                    $count = $db->get_value($query);

                    if ($count != 0) {
                        return array('field' => 'topmonthfrom', 'error' => 'Von-Bis überlappt eine andere Version');
                    }

                }

                return true;

            }

            return true;

        }

        /**
         * Called when new version is created
         *
         * @param integer $old_version_id Version id of previous version
         * @return void
         */
        protected function handle_new_version($old_version_id) {

            check_int($old_version_id, 'old_version_id');

            // text data

            $data = $this->db->get_all('SELECT text_id, text_link_ids FROM text WHERE text_link = "providerversion"');

            if ($data !== NULL) {

                $user = new \vv\myuser();

                for ($i = 0, $max = count($data); $i < $max; ++$i) {

                    if (!empty($data[$i]['text_link_ids'])) {

                        $ids = unserialize($data[$i]['text_link_ids']);

                        if (in_array($old_version_id, $ids)) {

                            $ids[] = $this->version_id;

                            $this->db->query('UPDATE text SET text_link_ids = "' . $this->db->escape(serialize($ids)) . '", text_user_id = ' . $user->get('id') . ', text_updated = NOW() WHERE text_id = ' . $data[$i]['text_id']);

                        }

                    }

                }

            }

        }

        /**
         * Get withdrawal address
         *
         * @param string $seperator Address part separator (default ',')
         *
         * @return string
         */
        public function get_withdrawal_address_final($seperator = ',') {

            check_string($seperator, 'seperator');

            if ($this->get_withdrawal_address() != '') {
                $text = implode($seperator, explode("\n", $this->get_withdrawal_address()));
            } else {
                $text = $this->get_company() . $seperator . $this->get_street() . $seperator . $this->get_zipcode() . ' ' . $this->get_city();
            }

            return $text;

        }

        /**
         * Get cancelation address
         *
         * @param string $seperator Address part separator (default ',')
         *
         * @return string
         */
        public function get_cancelation_address_final($seperator = ',') {

            check_string($seperator, 'seperator');

            if ($this->get_cancelation_address() != '') {
                $text = implode($seperator, explode("\n", $this->get_cancelation_address()));
            } else {
                $text = $this->get_company() . $seperator . $this->get_street() . $seperator . $this->get_zipcode() . ' ' . $this->get_city();
            }

            return $text;

        }

        /**
         * Create a copy of a provider
         *
         * @param integer $product_id Product id
         * @throws exception\logic Throws an exception if an unkown product was found
         * @return provider
         */
        public function copy($product_id) {

            check_id($product_id, 'product_id');

            $trx = $this->get_db()->trx();

            $check = $this->get_db()->get_value('SELECT COUNT(*) FROM product WHERE product_id = ' . $product_id);

            if ($check == 0) {
                throw new exception\logic('Unknown product');
            }

            $clone = clone($this);

            $clone->set_id(0);
            $clone->set_version_id(0);

            $clone->set_product_id($product_id);

            $clone->save();

            // Copy logos

            if ($this->get_logo_exist() && copy($this->get_logo_location(), $clone->get_logo_location())) {
                $clone->set_logo('yes');
            } else {
                $clone->set_logo('no');
            }

            $trx->complete();

            return $clone;

        }

        /**
         * Get description partner id based
         * Fallback is description field
         *
         * @return string
         */
        public function get_description() {

            $app = get_application();

            if ($app !== NULL && method_exists($app, 'get_session')) {

                // Get application based description

                if ($app->get_name() == 'form') {

                    $session = $app->get_session();

                    // On app form we have to handle via pid

                    if ($session->exists('partner_id')) {

                        switch ($session->get('partner_id')) {

                            case 24:

                                $text = $this->description;
                                break;

                            default:

                                $text = $this->description_pid_other;
                                break;

                        }

                    } else {
                        $text = $this->description;
                    }

                } else if ($app->get_name() == 'check24') {
                    $text = $this->description;
                } else {
                    $text = $this->description_pid_other;
                }

                // Fallback is always default text

                if ($text == '') {
                    $text = $this->description;
                }

            } else {
                $text = $this->description;
            }

            if ($this->auto_utf8_decode_getter == true) {
                $text = utf8_decode($text);
            }

            return $text;

        }

        /**
         * Returns all tariff ids for this provider
         *
         * @return array
         */
        public function get_active_tariff_ids() {

            $sql = 'SELECT tariff_id FROM tariff LEFT JOIN provider ON tariff_provider_id = provider_id LEFT JOIN tariffversion ON tariffversion_tariff_id = tariff_id WHERE provider_id = ' . $this->id . ' AND tariff_visible = "yes" AND tariffversion_status = "active" AND tariffversion_validfrom < NOW() AND (tariffversion_validto > NOW() OR tariffversion_validto IS NULL)';

            $dbslave = \vv\db::core_s();

            $data = $dbslave->get_all($sql);

            $return = array();

            for ($i = 0, $max = count($data); $i < $max; ++$i) {
                $return[] = $data[$i]['tariff_id'];
            }

            return $return;

        }

        /**
         * Get used interfaces from providerversion table
         *
         * @throws exception\logic Throws exception if not interfaces were found
         * @return array
         */
        public static function get_used_interfaces() {

            $dbslave = \vv\db::core_s();

            // Get all interfaces grouped by provider using same export interface

            $interfaces = $dbslave->get_all('SELECT providerversion_phpclass, GROUP_CONCAT(provider_name SEPARATOR ", ") AS providers
                FROM provider
                INNER JOIN providerversion ON (providerversion_provider_id = provider_id)
                WHERE providerversion_phpclass != ""
                AND providerversion_validfrom < NOW()
                AND (providerversion_validto >= NOW() OR providerversion_validto IS NULL)
                GROUP BY providerversion_phpclass
            ', NULL, 'providerversion_phpclass', 'providers');

            if ($interfaces === NULL) {
                throw new exception\logic('Missing any interfaces');
            }

            return $interfaces;

        }

        /**
         * Get evaluation data
         *
         * @param string $field Evaluation field
         *
         * @return array|NULL
         */
        public function get_companyevaluation_data($field = 'total') {

            check_string($field, 'field', false, array('total', 'terms', 'tariff', 'speed', 'team'));

            if ($this->company_id == 0) {
                return NULL;
            }

            $data = \vv\db::core_s()->get_row('SELECT companyevaluation_' . $field . '_sum "sum", companyevaluation_' . $field . '_count "count", companyevaluation_' . $field . '_avg "avg", 6 - companyevaluation_' . $field . '_avg "score", companyevaluation_' . $field . '_1 "1", companyevaluation_' . $field . '_2 "2", companyevaluation_' . $field . '_3 "3", companyevaluation_' . $field . '_4 "4", companyevaluation_' . $field . '_5 "5" FROM companyevaluation WHERE companyevaluation_company_id = ' . (int)$this->company_id);

            return $data;

        }

        /**
         * Returns alternative bill address
         *
         * @return string
         */
        public function get_alternative_billaddress() {
            return $this->alternative_billaddress;
        }

        /**
         * Returns analyse resukt
         *
         * @return string
         */
        public function get_analyseresult() {
            return $this->analyseresult;
        }

        /**
         * Returns automatic tariff selection
         *
         * @return string
         */
        public function get_auto_tariff_selection() {
            return $this->auto_tariff_selection;
        }


        /**
         * Retuns the binding offer
         *
         * @return integer
         */
        public function get_bindingoffer() {
            return $this->bindingoffer;
        }

        /**
         * Returns the brand
         *
         * @return string
         */
        public function get_brand() {
            return $this->brand;
        }

        /**
         * Returns brand provider id
         *
         * @return integer
         */
        public function get_brand_provider_id() {
            return $this->brand_provider_id;
        }

        /**
         * Returns cancelation address
         *
         * @return string
         */
        public function get_cancelation_address() {
            return $this->cancelation_address;
        }

        /**
         * Returns cancelation email
         *
         * @return string
         */
        public function get_cancelation_email() {
            return $this->cancelation_email;
        }

        /**
         * Returns cancelation fax
         *
         * @return string
         */
        public function get_cancelation_fax() {
            return $this->cancelation_fax;
        }

        /**
         * Returns cancelation question
         *
         * @return string
         */
        public function get_cancelation_question() {
            return $this->cancelation_question;
        }

        /**
         * Returns cancelation rate
         *
         * @return integer
         */
        public function get_cancelationrate() {
            return $this->cancelationrate;
        }

        /**
         * Returns city
         *
         * @return string
         */
        public function get_city() {
            return $this->city;
        }

        /**
         * Returns city description
         *
         * @return string
         */
        public function get_city_description() {
            return $this->city_description;
        }

        /**
         * Returns city picture copyright
         *
         * @return string
         */
        public function get_city_picture_copyright() {
            return $this->city_picture_copyright;
        }

        /**
         * Returns company
         *
         * @return string
         */
        public function get_company() {
            return $this->company;
        }

        /**
         * Returns company id
         *
         * @return integer
         */
        public function get_company_id() {
            return $this->company_id;
        }

        /**
         * Returns comparename
         *
         * @return string
         */
        public function get_comparename() {
            return $this->comparename;
        }

        /**
         * Returns contact email
         *
         * @return string
         */
        public function get_contact_email() {
            return $this->contact_email;
        }

        /**
         * Returns the created date
         *
         * @return string
         */
        public function get_created() {
            return $this->created;
        }

        /**
         * Returns description evalulation
         *
         * @return string
         */
        public function get_description_evaluation() {
            return $this->description_evaluation;
        }

        /**
         * Returns description pid
         *
         * @return string
         */
        public function get_description_pid_other() {
            return $this->description_pid_other;
        }

        /**
         * Returns efeedback award url
         *
         * @return string
         */
        public function get_efeedback_award_url() {
            return $this->efeedback_award_url;
        }

        /**
         * Returns a commasepeated list of efeedback ids
         *
         * @return string
         */
        public function get_efeedback_ids() {
            return $this->efeedback_ids;
        }

        /**
         * Returns a efeedback review id
         *
         * @return integer
         */
        public function get_efeedback_review_id() {
            return $this->efeedback_review_id;
        }

        /**
         * Returns the email
         *
         * @return string
         */
        public function get_email() {
            return $this->email;
        }

        /**
         * Returns the fax
         *
         * @return string
         */
        public function get_fax() {
            return $this->fax;
        }

        /**
         * Returns the guidelinematch
         *
         * @return string
         */
        public function get_guidelinematch() {
            return $this->guidelinematch;
        }

        /**
         * Returns the provider id
         *
         * @return integer
         */
        public function get_id() {
            return $this->id;
        }

        /**
         * Returns the imprint
         *
         * @return string
         */
        public function get_imprint() {
            return $this->imprint;
        }

        /**
         * Return the internal comment
         *
         * @return string
         */
        public function get_internal_comment() {
            return $this->internal_comment;
        }

        /**
         * Returns logo
         *
         * @return string
         */
        public function get_logo() {
            return $this->get_logo_url();
        }


        /**
         * Returns mobile footnoes
         *
         * @return string
         */
        public function get_mobile_footnotes() {
            return $this->mobile_footnotes;
        }

        /**
         * Returns owner more
         *
         * @return string
         */
        public function get_owner_more() {
            return $this->owner_more;
        }

        /**
         * Returns password question
         *
         * @return string
         */
        public function get_password_question() {
            return $this->password_question;
        }

        /**
         * Returns phone number
         *
         * @return string
         */
        public function get_phone() {
            return $this->phone;
        }

        /**
         * Returns phone info
         *
         * @return string
         */
        public function get_phone_info() {
            return $this->phone_info;
        }

        /**
         * Returns the specific phpclass
         *
         * @return string
         */
        public function get_phpclass() {
            return $this->phpclass;
        }

        /**
         * Return power cancelation in month
         *
         * @return string
         */
        public function get_power_cancelation_in_month() {
            return $this->power_cancelation_in_month;
        }

        /**
         * Returns power cancelation question
         *
         * @return string
         */
        public function get_power_cancelation_question() {
            return $this->power_cancelation_question;
        }

        /**
         * Returns power delivery day
         *
         * @return integer
         */
        public function get_power_delivery_day() {
            return $this->power_delivery_day;
        }

        /**
         * Returns power delivery in month
         *
         * @return string
         */
        public function get_power_delivery_in_month() {
            return $this->power_delivery_in_month;
        }

        /**
         * Returns power deliviery months
         *
         * @return integer
         */
        public function get_power_delivery_months() {
            return $this->power_delivery_months;
        }

        /**
         * Returns power delivery question
         *
         * @return string
         */
        public function get_power_delivery_question() {
            return $this->power_delivery_question;
        }

        /**
         * Returns power delivery workdays
         *
         * @return integer
         */
        public function get_power_delivery_workdays() {
            return $this->power_delivery_workdays;
        }

        /**
         * Returns power max amout net
         *
         * @return integer
         */
        public function get_power_max_amount_net() {
            return $this->power_max_amount_net;
        }

        /**
         * Returns product id
         *
         * @return string
         */
        public function get_product_id() {
            return $this->product_id;
        }

        /**
         * Returns the reseller
         *
         * @return string
         */
        public function get_reseller() {
            return $this->reseller;
        }

        /**
         * Returns result grouping
         *
         * @return string
         */
        public function get_result_grouping() {
            return $this->result_grouping;
        }

        /**
         * Returns a value if imprint will be shown [yes, no]
         *
         * @return string
         */
        public function get_show_imprint() {
            return $this->show_imprint;
        }

        /**
         * Returns the status [inactive, active]
         *
         * @return string
         */
        public function get_status() {
            return $this->status;
        }

        /**
         * Returns the street
         *
         * @return string
         */
        public function get_street() {
            return $this->street;
        }

        /**
         * Returns topmonthfrom
         *
         * @return string
         */
        public function get_topmonthfrom() {
            return $this->topmonthfrom;
        }

        /**
         * Returns topmonthto
         *
         * @return string
         */
        public function get_topmonthto() {
            return $this->topmonthto;
        }

        /**
         * Returns topmonthurl gat
         *
         * @return string
         */
        public function get_topmonthurl_gas() {
            return $this->topmonthurl_gas;
        }

        /**
         * Returns topmothurl power
         *
         * @return string
         */
        public function get_topmonthurl_power() {
            return $this->topmonthurl_power;
        }

        /**
         * Returns last updated date
         *
         * @return string
         */
        public function get_updated() {
            return $this->updated;
        }

        /**
         * Returns valid from
         *
         * @return string
         */
        public function get_validfrom() {
            return $this->validfrom;
        }

        /**
         * Returns valid to
         *
         * @return string
         */
        public function get_validto() {
            return $this->validto;
        }

        /**
         * Returns the version id
         *
         * @return integer
         */
        public function get_version_id() {
            return $this->version_id;
        }

        /**
         * Returns the amount of existing provider versions
         *
         * @return integer
         */
        public function get_versions() {
            return $this->versions;
        }

        /**
         * Returns visible
         *
         * @return string
         */
        public function get_visible() {
            return $this->visible;
        }

        /**
         * Returns the website
         *
         * @return string
         */
        public function get_website() {
            return $this->website;
        }

        /**
         * Returns the withdrawal address
         *
         * @return string
         */
        public function get_withdrawal_address() {
            return $this->withdrawal_address;
        }

        /**
         * Returns the zipcode
         *
         * @return string
         */
        public function get_zipcode() {
            return $this->zipcode;
        }


        /**
         * Sets the version id
         *
         * @param integer $version_id Version id
         * @return void
         */
        public function set_version_id($version_id) {

            check_int($version_id, 'providerversion_id');
            $this->version_id = $version_id;

        }

        /**
         * Sets the id
         *
         * @param integer $id Id
         * @return void
         */
        public function set_id($id) {

            check_int($id, 'Id');
            $this->id = $id;

        }

        /**
         * Sets the company id
         *
         * @param integer $company_id Company id
         * @return void
         */
        public function set_company_id($company_id) {

            check_int($company_id, 'company_id');
            $this->company_id = $company_id;

        }

        /**
         * Sets the provider name
         *
         * @param string $name Provider name
         * @return void
         */
        public function set_name($name) {

            check_string($name, 'name');
            $this->name = $name;

        }

        /**
         * Sets visible state of provider
         *
         * @param string $visible Visible state [yes, no]
         * @return void
         */
        public function set_visible($visible) {

            check_string($visible, 'visible', false, ['yes', 'no']);
            $this->visible = $visible;

        }

        /**
         * Set the amount of existing versions
         *
         * @param integer $version Amount of versions
         * @return void
         */
        public function set_versions($version) {

            check_int($version, 'version', true);
            $this->versions = $version;

        }

        /**
         * Sets the product id
         *
         * @param integer $product_id Product id
         * @return void
         */
        public function set_product_id($product_id) {

            check_int($product_id, 'product_id');
            $this->product_id = $product_id;

        }

        /**
         * Sets the anaylse result
         *
         * @param integer $anaylseresult Analyse result
         * @return void
         */
        public function set_analyseresult($anaylseresult) {
            $this->analyseresult = $anaylseresult;
        }

        /**
         * Sets the efeedback award url
         *
         * @param string $efeedback_award_url EFeedback Award url
         * @return void
         */
        public function set_efeedback_award_url($efeedback_award_url) {

            check_string($efeedback_award_url, 'efeedback_award_url', true);
            $this->efeedback_award_url = $efeedback_award_url;

        }

        /**
         * Sets the contact email
         *
         * @param string $contact_email Contact email
         * @return void
         */
        public function set_contact_email($contact_email) {

            check_string($contact_email, 'contact_email', true);
            $this->contact_email = $contact_email;

        }

        /**
         * Sets the cancelation rate
         *
         * @param integer $cancelationrate Cancelation rate
         * @return void
         */
        public function set_cancelationrate($cancelationrate) {

            check_string($cancelationrate, 'cancelationrate', true);
            $this->cancelationrate = $cancelationrate;

        }

        /**
         * Sets a list of comma seperated efeedback ids
         *
         * @param string $efeedback_ids List of id
         * @return void
         */
        public function set_efeedback_ids($efeedback_ids) {

            if ($efeedback_ids !== NULL) {

                $ids = explode(',', $efeedback_ids);

                foreach ($ids AS $id) {
                    check_int($id, 'efeedback id', true);
                }

            }

            $this->efeedback_ids = $efeedback_ids;

        }

        /**
         * Sets the efeedback review id
         *
         * @param integer $efeedback_review_id Review id
         * @return void
         */
        public function set_efeedback_review_id($efeedback_review_id) {
            $this->efeedback_review_id = $efeedback_review_id;
        }

        /**
         * Sets a value if logo is available
         *
         * @param string $logo String value [yes, no]
         * @return void
         */
        public function set_logo($logo) {
            check_string($logo, 'logo', false, ['yes', 'no']);
            $this->logo = $logo;
        }


        /**
         * Sets the foreign id
         *
         * @param integer $foreign_id Foreign id
         * @return void
         */
        public function set_foreign_id($foreign_id) {

            check_int($foreign_id, 'foreign_id', true);
            $this->foreign_id = $foreign_id;

        }

        /**
         * Sets the synonyms
         *
         * @param string $synonyms Synonyms
         * @return void
         */
        public function set_synonyms($synonyms) {

            check_string($synonyms, 'synonyms', true);
            $this->synonyms = $synonyms;

        }

        /**
         * Sets the result grouping
         *
         * @param string $result_grouping Result grouping
         * @return void
         */
        public function set_result_grouping($result_grouping) {

            check_string($result_grouping, 'result_grouping', true);
            $this->result_grouping = $result_grouping;

        }

        /**
         * Sets the valid from
         *
         * @param string $validfrom Valid from
         * @return void
         */
        public function set_validfrom($validfrom) {

            check_string($validfrom, 'validfrom');
            $this->validfrom = $validfrom;

        }

        /**
         * Sets the valid to
         *
         * @param string $validto Valid to
         * @return void
         */
        public function set_validto($validto) {
            $this->validto = $validto;
        }

        /**
         * Sets top month from
         *
         * @param string $topmonthfrom Topmonth from
         * @return void
         */
        public function set_topmonthfrom($topmonthfrom) {

            check_string($topmonthfrom, 'topmonthfrom');
            $this->topmonthfrom = $topmonthfrom;

        }

        /**
         * Sets top month to
         *
         * @param string $topmonthto Topmonth to
         * @return void
         */
        public function set_topmonthto($topmonthto) {

            check_string($topmonthto, 'topmonthto');
            $this->topmonthto = $topmonthto;

        }

        /**
         * Sets
         *
         * @param string $url Url
         * @return void
         */
        public function set_topmonthurl_power($url) {

            check_string($url, 'topmonthurl_power', true);
            $this->topmonthurl_power = $url;

        }

        /**
         * Sets
         *
         * @param string $url Url
         * @return void
         */
        public function set_topmonthurl_gas($url) {

            check_string($url, 'topmonthurl_gas', true);
            $this->topmonthurl_gas = $url;

        }

        /**
         * Sets the brand
         *
         * @param string $brand Brand
         * @return void
         */
        public function set_brand($brand) {

            check_string($brand, 'brand', true);
            $this->brand = $brand;

        }

        /**
         * Sets the brand provider id
         *
         * @param integer $id Brand provider id
         * @return void
         */
        public function set_brand_provider_id($id) {
            $this->brand_provider_id = $id;
        }

        /**
         * Sets the company
         *
         * @param string $company Company
         * @return void
         */
        public function set_company($company) {

            check_string($company, 'company');
            $this->company = $company;

        }

        /**
         * Sets the street
         *
         * @param string $street Street
         * @return void
         */
        public function set_street($street) {

            check_string($street, 'street');
            $this->street = $street;

        }

        /**
         * Sets the zipcode
         *
         * @param string $zipcode Zipcode
         * @return void
         */
        public function set_zipcode($zipcode) {

            check_string($zipcode, 'zipcode');
            $this->zipcode = $zipcode;

        }

        /**
         * Sets the city
         *
         * @param string $city City
         * @return void
         */
        public function set_city($city) {

            check_string($city, 'city');
            $this->city = $city;

        }

        /**
         * Sets the phone
         *
         * @param string $phone Phone
         * @return void
         */
        public function set_phone($phone) {

            check_string($phone, 'phone', true);
            $this->phone = $phone;

        }

        /**
         * Sets the phone info
         *
         * @param string $phone_info Phone info
         * @return void
         */
        public function set_phone_info($phone_info) {

            check_string($phone_info, 'phone_info', true);
            $this->phone_info = $phone_info;

        }

        /**
         * Sets the fax
         *
         * @param string $fax Fax
         * @return void
         */
        public function set_fax($fax) {

            check_string($fax, 'fax', true);
            $this->fax = $fax;

        }

        /**
         * Sets the email
         *
         * @param string $email Email
         * @return void
         */
        public function set_email($email) {

            check_string($email, 'email', true);
            $this->email = $email;

        }

        /**
         * Sets lead transfere email
         *
         * @param string $email Lead transfere email
         * @return void
         */
        public function set_leadtransfer_email_test($email) {

            check_string($email, 'leadtransfere_email_test', true);
            $this->leadtransfer_email_test = $email;

        }

        /**
         * Sets lead transfere email
         *
         * @param string $email Lead transfere email
         * @return void
         */
        public function set_leadtransfer_email_productive($email) {

            check_string($email, 'leadtransfer_email_productive', true);
            $this->leadtransfer_email_productive = $email;

        }

        /**
         * Sets the website
         *
         * @param string $website Website
         * @return void
         */
        public function set_website($website) {

            check_string($website, 'website', true);
            $this->website = $website;

        }

        /**
         * Sets the description
         *
         * @param string $description Description
         * @return void
         */
        public function set_description($description) {

            check_string($description, 'description', true);
            $this->description = $description;

        }

        /**
         * Sets the pid
         *
         * @param string $pid Pid
         * @return void
         */
        public function set_description_pid_other($pid) {

            check_string($pid, 'description_pid_other', true);
            $this->description_pid_other = $pid;

        }

        /**
         * Sets the description evaluation
         *
         * @param string $eval Description evaluation
         * @return void
         */
        public function set_description_evaluation($eval) {

            check_string($eval, 'description_evaluation', true);
            $this->description_evaluation = $eval;

        }

        /**
         * Sets the internal comment
         *
         * @param string $comment Comment
         * @return void
         */
        public function set_internal_comment($comment) {

            check_string($comment, 'internal_comment', true);
            $this->internal_comment = $comment;

        }

        /**
         * Sets withdrawal address
         *
         * @param string $address Address
         * @return void
         */
        public function set_withdrawal_address($address) {

            check_string($address, 'withdrawal_address', true);
            $this->withdrawal_address = $address;

        }

        /**
         * Sets cancelation address
         *
         * @param string $address Address
         * @return void
         */
        public function set_cancelation_address($address) {

            check_string($address, 'cancelation_address', true);
            $this->cancelation_address = $address;

        }

        /**
         * Sets cancelation fax
         *
         * @param string $fax Fax
         * @return void
         */
        public function set_cancelation_fax($fax) {

            check_string($fax, 'cancelation_fax', true);
            $this->cancelation_fax = $fax;

        }

        /**
         * Sets cancelation email
         *
         * @param string $email Email
         * @return void
         */
        public function set_cancelation_email($email) {

            check_string($email, 'cancelation_email', true);
            $this->cancelation_email = $email;

        }


        /**
         * Sets city description
         *
         * @param string $description Description
         * @return void
         */
        public function set_city_description($description) {

            check_string($description, 'city_description', true);
            $this->city_description = $description;

        }

        /**
         * Sets picture copyright
         *
         * @param string $copyright Copyright
         * @return void
         */
        public function set_city_picture_copyright($copyright) {

            check_string($copyright, 'city_picture_copyright', true);
            $this->city_picture_copyright = $copyright;

        }

        /**
         * Sets reseller
         *
         * @param string $reseller Reseller
         * @return void
         */
        public function set_reseller($reseller) {

            check_string($reseller, 'reseller');
            $this->reseller = $reseller;

        }

        /**
         * Sets created date
         *
         * @param string $created Created
         * @return void
         */
        public function set_created($created) {

            check_string($created, 'created');
            $this->created = $created;

        }

        /**
         * Sets updated date
         *
         * @param string $updated Updated
         * @return void
         */
        public function set_updated($updated) {

            check_string($updated, 'updated');
            $this->updated = $updated;

        }

        /**
         * Sets status
         *
         * @param string $status Status
         * @return void
         */
        public function set_status($status) {

            check_string($status, 'status');
            $this->status = $status;

        }

        /**
         * Sets bill address
         *
         * @param string $address Address
         * @return void
         */
        public function set_alternative_billaddress($address) {

            check_string($address, 'alternative_billaddress');
            $this->alternative_billaddress = $address;

        }

        /**
         * Sets owner more
         *
         * @param string $owner Owner
         * @return void
         */
        public function set_owner_more($owner) {

            check_string($owner, 'owner_more');
            $this->owner_more = $owner;

        }

        /**
         * Sets php class
         *
         * @param string $phpclass PHPClass
         * @return void
         */
        public function set_phpclass($phpclass) {

            check_string($phpclass, 'phpclass', true);
            $this->phpclass = $phpclass;

        }

        /**
         * Sets guideline match
         *
         * @param string $match Match
         * @return void
         */
        public function set_guidelinematch($match) {

            check_string($match, 'guidelinematch');
            $this->guidelinematch = $match;

        }

        /**
         * Sets power max amount
         *
         * @param string $amount Amount
         * @return void
         */
        public function set_power_max_amount_net($amount) {
            $this->power_max_amount_net = $amount;
        }

        /**
         * Sets cancelation question
         *
         * @param string $question Question
         * @return void
         */
        public function set_power_cancelation_question($question) {

            check_string($question, 'cancelation_question');
            $this->power_cancelation_question = $question;

        }

        /**
         * Sets cancelation in month
         *
         * @param string $cancelation Cancelation
         * @return void
         */
        public function set_power_cancelation_in_month($cancelation) {

            check_string($cancelation, 'power_cancelation_in_month');
            $this->power_cancelation_in_month = $cancelation;

        }

        /**
         * Sets power delivery question
         *
         * @param string $question Description
         * @return void
         */
        public function set_power_delivery_question($question) {

            check_string($question, 'power_delivery_question');
            $this->power_delivery_question = $question;

        }

        /**
         * Sets power delivery day
         *
         * @param integer $day Day
         * @return void
         */
        protected  function set_power_delivery_day($day) {

            check_int($day, 'power_delivery_day', true);
            $this->power_delivery_day = $day;

        }

        /**
         * Sets power delivery months
         *
         * @param integer $months Months
         * @return void
         */
        public function set_power_delivery_months($months) {

            check_int($months, 'power_delivery_months', true);
            $this->power_delivery_months = $months;

        }

        /**
         * Sets power delivery workdays
         *
         * @param integer $workdays Workdays
         * @return void
         */
        public function set_power_delivery_workdays($workdays) {

            check_int($workdays, 'power_delivery_workdays', true);
            $this->power_delivery_workdays = $workdays;

        }

        /**
         * Sets power delivery in month
         *
         * @param string $delivery Delivery
         * @return void
         */
        public function set_power_delivery_in_month($delivery) {

            check_string($delivery, 'power_delivery_in_month');
            $this->power_delivery_in_month = $delivery;

        }

        /**
         * Sets canelcation question
         *
         * @param string $question Question
         * @return void
         */
        public function set_cancelation_question($question) {

            check_string($question, 'cancelation_question');
            $this->cancelation_question = $question;

        }

        /**
         * Sets password question
         *
         * @param string $question Question
         * @return void
         */
        public function set_password_question($question) {

            check_string($question, 'password_question', true);
            $this->password_question = $question;

        }

        /**
         * Sets applications mandatory
         *
         * @param string $mandatory Mandatory
         * @return void
         */
        public function set_leadtransfer_applications_mandatory($mandatory) {

            check_string($mandatory, 'leadtransfer_applications_mandatory');
            $this->leadtransfer_applications_mandatory = $mandatory;

        }

        /**
         * Sets binding offer
         *
         * @param integer $bindingoffer Bindingoffer
         * @return void
         */
        public function set_bindingoffer($bindingoffer) {
            check_int($bindingoffer, 'bindingoffer', true);
            $this->bindingoffer = $bindingoffer;
        }

        /**
         * Sets mobile footnotes
         *
         * @param string $footnotes Footnotes
         * @return void
         */
        public function set_mobile_footnotes($footnotes) {

            check_string($footnotes, 'mobile_footnotes', true);
            $this->mobile_footnotes = $footnotes;

        }

        /**
         * Sets if imprint should be shown
         *
         * @param string $show_imprint Show imprint
         * @return void
         */
        public function set_show_imprint($show_imprint) {

            check_string($show_imprint, 'show_imprint', true);
            $this->show_imprint = $show_imprint;

        }

        /**
         * Sets imprint
         *
         * @param string $imprint Imprint
         * @return void
         */
        public function set_imprint($imprint) {

            check_string($imprint, 'imprint', true);
            $this->imprint = $imprint;

        }

        /**
         * Sets auto tariff selection
         *
         * @param string $selection Selection
         * @return void
         */
        public function set_auto_tariff_selection($selection) {

            check_string($selection, 'auto_tariff_selection');
            $this->auto_tariff_selection = $selection;

        }

        /**
         * Sets comparename
         *
         * @param string $comparename Comparename
         * @return void
         */
        public function set_comparename($comparename) {
            $this->comparename = $comparename;
        }

        /**
         * Set contact email cc
         *
         * @param string $contact_email_cc Contact email cc
         * @return void
         */
        public function set_contact_email_cc($contact_email_cc) {

            check_string($contact_email_cc, 'contact_email_cc', true);
            $this->contact_email_cc = $contact_email_cc;

        }

    }
