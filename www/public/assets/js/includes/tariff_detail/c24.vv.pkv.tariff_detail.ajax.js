/**
 * Handels all Ajax calls on the tarrif_detail page
 *
 * Created by ignaz.schlennert on 22.03.2016.
 */
(function ($, document) {

    "use strict";

    var ns = namespace('c24.vv.pkv.tariff_detail');

    /**
     * Id of the choosen tariff
     *
     * @type {string}
     */
    var tariff_version_id = '';

    /**
     * Content from api for the content need for only one request
     *
     * @type {{cure_benefits: {color:"yellow", grade: 2.3, maxpoints:"10.0", points:4}}, ...}
     */
    var tariff_grade_content = {};

    /**
     * Params for the ajax call, temporary save of params for only one request
     *
     * @type {{calculationparameter_id:{string}, mode_id:{int}, provider_id:{string}, tariffversion_id:{string}, tariffversion_variation_key: {string}, tracking_id:{string}}}
     */
    var tariff_details = {};

    /**
     * Content from the api, temporary save for only one request
     *
     *
     * @type {{
     *  tariffversion_id:{string},
     *  tariffversion_variation_key:{string},
     *  calculationparameter_id:{string},
     *  mode_id:{string},
     *  tracking_id:{string},
     *  partner_id:{string},
     *  product_id:{int},
     *  hospital_payout_amount:{int},
     *  hospital_payout_start:{int},
     *  savings:{lifestyle:{comment:{string}, limit:{string}}},
     *  variable_refund:{first_y:{string}, limit:{string}, comment:{string}},
     *  paymentperiod:{},
     *  price:{}
     *  }}
     *
     */
    var tariff_details_content = {};

    /**
     * Content from the api, temporary save for only one request
     * @type {{
     *  content: {
     *      key: {
     *          name: {string}
     *          children: {
     *              key: {
     *                  name: {string},
     *                  comment: {string},
     *                  tooltip: {string}
     *              }
     *          }
     *      }
     *  }
     * }}
     */
    var tariff_features_content = {};

    /**
     * Url for the ajax call for tariff grades
     *
     * @type {string}
     */
    var tariff_grade_url = '/ajax/json/tariffgrade/';

    /**
     * Url for the ajax call for tariff details
     *
     * @type {string}
     */
    var tariff_details_url = '/ajax/json/tariffdetails/';

    /**
     * Url for the ajax call for tariff features
     *
     * @type {string}
     */
    var tariff_features_url = '/ajax/json/tarifffeature/';

    /**
     * Parameter for tariff feature
     *
     * @type {{calculationparameter_id : {string}, product_id: {int}}}
     */
    var tariff_features_params = {};

    ns.ajax = {

        /**
         * Sends the ajax request for tariffgrades to get the grades from api
         *
         * @param {string} tariffversion_id
         */
        get_tariffgrades: function (tariffversion_id) {

            if (tariffversion_id == tariff_version_id && Object.keys(tariff_grade_content).length > 0) {
                ns.generate_tariff_grade( tariff_grade_content);
            } else {

                tariff_version_id = tariffversion_id;
                var url = tariff_grade_url + tariffversion_id + '/';
                ns.ajax.send_request(url, c24.vv.pkv.tariff_detail.generate_tariff_grade, ns.ajax.set_tariff_grade_content);

            }
        },

        /**
         * Send the ajax request for tariff features to get the tree from Api
         *
         * @param {{c24api_calculationparameter_id : {string}, c24api_product_id: {int}, tariff_id: {int}}} params
         */
        get_tarifffeatures: function (params) {

            if (Object.keys(tariff_features_content).length <= 0
                && params.c24api_calculationparameter_id != tariff_features_params.calculationparameter_id) {
                
                var cleared = ns.ajax.remove_c24api_from_string(params);
                tariff_features_params = cleared;

                var url = tariff_features_url +
                        cleared.tariff_id + '/' +
                        cleared.calculationparameter_id + '/'
                    ;
                ns.ajax.send_request(url, c24.vv.pkv.tariff_detail.generate_tariff_features, ns.ajax.set_tariff_features_content);

            }


        },

        /**
         * Sends the ajax request for tariff details to get the details from api
         *
         * @param {{c24api_calculationparameter_id, c24api_mode_id, provider_id, c24api_tariffversion_id, c24api_tariffversion_variation_key, c24api_tracking_id}} params
         */
        get_tariffdetails: function (params) {

            if (Object.keys(tariff_details_content).length <= 0 && tariff_details.tariffversion_id != params.c24api_tariffversion_id) {

                //remove c24api in String
                var cleared = ns.ajax.remove_c24api_from_string(params);
                tariff_features_params = cleared;

                var url = tariff_details_url +
                    cleared.tariffversion_id + '/' +
                    cleared.tariffversion_variation_key + '/' +
                    cleared.calculationparameter_id + '/' +
                    cleared.mode_id + '/' +
                    cleared.tracking_id + '/' +
                    cleared.provider_id + '/';

                ns.ajax.send_request(url, c24.vv.pkv.tariff_detail.generate_tariff_details, ns.ajax.set_tariff_details_content);

            }

        },

        /**
         * Cleared c24api_ from url
         *
         * @param {{c24api_tariffversion_id: {string}, c24api_tariffversion_variation_key: {string}, c24api_calculationparameter_id:{string}, ...}}params
         * @returns {{tariffversion_id: {int}, tariffversion_variation_key: {string}, calculationparameter_id:{string}, ...}}
         */
        remove_c24api_from_string: function (params) {

            $.each(params, function (key, value) {

                var temp_key = key.replace('c24api_', '');
                delete params[key];
                if (value == '') {
                    value = 0;
                }
                params[temp_key] = value;

            });

            return params
        },

        /**
         * Send the ajax request to backend
         *
         *
         * @param {string} url Url for Ajax Call
         * @param {string} callback Callback Function after Success
         * @param {string} setter Setter for Data for send Request only once
         */
        send_request: function (url, callback, setter ) {

            var $blocker = $('#blocker'); 
            
            $.ajax({
                dataType: 'json',
                url: url,
                timeout: 5000,
                beforeSend: function(){
                    $blocker.show();
                },
                success: function (data) {

                    setter(data.content);
                    callback(data.content);

                },
                complete: function () {
                    $blocker.hide();
                },
                error: function () {

                    setter({});
                    callback({});
                    console.warn('Error on Ajax Request for Api call')

                }
            });
        },

        /**
         * Setter for tariff_grade_content with data from api
         *
         * @param {object} data
         */
        set_tariff_grade_content: function (data) {
            tariff_grade_content = data;
        },

        /**
         * Setter for tariff_details_content with data from api
         *
         * @param {object} data
         */
        set_tariff_details_content: function (data) {
            tariff_details_content = data;
        },

        /**
         * Setter for tariff_features_content with data from api
         *
         * @param {object} data
         */
        set_tariff_features_content: function (data) {
            tariff_features_content = data;
        }
    }

})($, document);