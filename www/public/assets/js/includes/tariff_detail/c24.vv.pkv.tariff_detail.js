/**
 * Created by ignaz.schlennert on 22.03.2016.
 */
(function ($, document, window) {
    
    "use strict";
    
    var ns = namespace('c24.vv.pkv');

    /**
     * Matching Object for tariff grade Api Key to Text for Gui
     *
     * @type {{outpatient_benefits: string, inpatient_benefits: string, dental_benefits: string, general_tariff_provision: string, insurance_evaluation: string, cure_benefits: string, hospital_per_diem: string}}
     */
    var grade_values = {
        outpatient_benefits : 'Ambulante Leistungen',
        inpatient_benefits: 'Stationäre Leistungen',
        dental_benefits: 'Zahnleistungen',
        general_tariff_provision : 'Allgemeine Tarifbestimmungen',
        insurance_evaluation : 'CHECK24-Bewertung des Versicherers',
        reimbursement: 'Rückerstattung und Bonus',
        cure_benefits: 'Kurleistungen',
        hospital_per_diem : 'Krankentagegeld'
    };

    /**
     * Matching Object for tariff details Api Key to Text for Gui
     *
     * @type {{Ambulant: string, Stationaer: string, Krankentagegeld: string, PflegePflicht: string, Zahn: string, BeihilfeErgaenzung: string}}
     */
    var tariff_details_details_values = {
        Ambulant: 'Grundtarif',
        Stationaer: 'Stationäre Leistungen',
        Zahn: 'Zahnleistungen',
        Krankentagegeld: 'Krankentagegeld',
        BeihilfeErgaenzung: 'Beihilfeergänzung',
        PflegePflicht: 'Pflegepflichtversicherung'

    };

    /**
     * Matching Object for Bonus. Api Key to Text for Gui
     *
     * @type {{lifestyle: string, variable_refund: string, garanty_refund: string}}
     */
    var tariff_details_bonus_values = {
        lifestyle: 'Bonus für gesunden Lebensstil',
        variable_refund : 'Variable Beitragsrückerstattung',
        garanty_refund: 'Garantierte Beitragsrückerstattung',
        provision_refund_child: 'Beitragsrückerstattung für Kinder'
    };

    /**
     * Matching Object for tariff grade details (display text and css class)
     *
     * @type {object}
     */
    var mapping_tariff_grade_details = {
        excellent: {
            display_text: 'exzellent'
        },
        very_good: {
            display_text: 'sehr gut'
        },
        good: {
            display_text: 'gut'
        },
        satisfying: {
            display_text: 'befriedigend'
        },
        sufficient: {
            display_text: 'ausreichend'
        }
    };

    /**
     * Const for text for employers contribution
     *
     * @type {string}
     */
    var employers_contribution = 'Arbeitgeberanteil';

    /**
     * Const for text for employees contribution
     *
     * @type {string}
     */
    var employees_contribution = 'Ihr Anteil (Arbeitnehmeranteil)**';

    /**
     * Const for text hospital per diem
     *
     * @type {string}
     */
    var hospital_per_diem = 'Krankentagegeld';

    /**
     * Const for profession freelancer
     *
     * @type {string}
     */
    var profession_freelancer = 'freelancer';

    /**
     * Const for profession employee
     *
     * @type {string}
     */
    var profession_employee = 'employee';

    /**
     * Const for inured person adult
     *
     * @type {string}
     */
    var insured_person_adult = 'adult';

    ns.tariff_detail = {

        /**
         * Init function
         */
        init: function () {

            $('.tariff-box').click(ns.tariff_detail.toggle_view);
            $('.back_to_top').click(ns.tariff_detail.scrollToTop);
            $('.c24-result-top-row .grade_tariffheader').click(ns.tariff_detail.click_on_top_grade);

        },

        /**
         * Init event trigger to elements which will create on runtime
         */
        init_late_events: function() {

            $('.tariff_feature_row_head').click(ns.tariff_detail.toggle_features);
            $('.tariff_feature_info_icon, .c24-info-close-row').click(ns.tariff_detail.toggle_tooltip)

        },

        /**
         * Toggle the tooltip Element
         */
        toggle_tooltip: function () {

            var $element = $(this);
            var $parent = $element.parents('.tariff_feature_row');
            var $hidden = $parent.find('.c24-content-row-block-infobox');
            var $icon = $parent.find('.tariff_feature_info_icon');
            $icon.toggleClass('c24-info-icon-open');
            $hidden.toggle();

        },

        /**
         * Toggles the view of the tariff details and start the request if needed for data
         */
        toggle_view: function(ev) {

            if ($(ev.target).hasClass('.tariff-row-hidden') || $(ev.target).parents('.tariff-row-hidden').length > 0) {
                return;
            }

            var _this = this;
            var toggle_view = $(_this).find('.toggle-view');
            var parent = $(_this);
            var element = parent.children('.tariff-row-hidden');
            var display = element.css('display');
            var action_id = toggle_view.attr('id');

            if (display  == 'none') {

                switch (action_id) {

                    case 'tariff_node':
                        ns.tariff_detail.get_tariff_grades();
                        ns.tracking.piwik.trackEvent('CHECK24 Tarifnote', 'open' , 'Tarifnote');
                        break;

                    case 'tariff_details':
                        ns.tariff_detail.get_tariff_details();
                        ns.tracking.piwik.trackEvent('Beitragsdetails', 'open', 'Beitrag');
                        break;

                    case 'tariff_feature':
                        ns.tariff_detail.get_tariff_feature();
                        ns.tracking.piwik.trackEvent('Produktdetails', 'open', 'Produkt');
                        break;

                    default:
                        break;

                }
                
            }

            element.slideToggle(600);
            $('span', toggle_view).toggle();
            var div = toggle_view.find('div');

            if (display == 'none') {
                div.attr('class', 'tariff_details_arrow_up');
            } else {
                div.attr('class', 'tariff_details_arrow_down');
            }

            try {
                c24.vv.shared.util.scroll_top($(parent).offset().top);
            } catch(e){}

        },

        /**
         * Toggle the tariff features.
         */
        toggle_features: function () {

            var $element = $(this);
            var $parent = $element.parent();
            var $collapse = $element.children('.collapse');
            var $hidden = $parent.children('.tariff_feature_content_part');
            var state = $hidden.is(':visible');

            $hidden.slideToggle(600);
            $collapse.toggleClass('collapse_down', state).toggleClass('collapse_up', !state);

        },
        /**
         * Get one or more Url Params an return this
         *
         * @param {string|object} param
         * @returns {string|object}
         */
        get_url_param: function (param) {

            var query_string = {};
            var query = window.location.search.substring(1);
            var params_array = query.split('&');

            for (var i = 0; i < params_array.length; i++) {
                var pair = params_array[i].split('=');
                query_string[pair[0]] = pair[1];
            }

            if (!Array.isArray(param)) {
                return query_string[param];
            } else {

                var return_object = {};

                for (var a = 0; a < param.length; a++) {
                    if (typeof query_string[param[a]] != 'undefined') {
                        return_object[param[a]] = query_string[param[a]]
                    }
                }

                return return_object;

            }

        },

        /**
         * Handle all parts for the tariff grades
         */
        get_tariff_grades: function () {

            var params = ns.tariff_detail.get_url_param('c24api_tariffversion_id');
            ns.tariff_detail.ajax.get_tariffgrades(params);

        },

        /**
         * Get the related tariff grade value text
         *
         * @param {int} grade_value  The tariff grade value
         * @returns {object}         The related grade value details
         */
        get_tariff_grade_details: function (grade_value) {

            var ranges = {
                excellent: 1.0,
                very_good: 1.5,
                good: 2.5,
                satisfying: 3.5
            };

            for (var key in ranges) {
                if (grade_value <= ranges[key]) {
                    return mapping_tariff_grade_details[key];
                }
            }

            // grade_value > 3.5
            return mapping_tariff_grade_details.sufficient;

        },

        /**
         * Generate from api object the html Part for the tariff grades
         *
         * @param {object} data
         */
        generate_tariff_grade: function(data) {

            var content = '';
            var total_points = 0;
            var total_max_points = 0;

            $.each(data, function(key, value) {

                if (typeof grade_values[key]  !==  'undefined') {

                    var show = false;

                    /**
                     * Show only hospital per diem for freelancer and employees
                     */
                    if (grade_values[key] == hospital_per_diem) {

                        var profession = $('#profession').val();

                        if ((profession == profession_freelancer || profession == profession_employee) && $('#insured_person').val() == insured_person_adult) {
                            show = true
                        }

                    } else {
                        show = true;
                    }

                    if (show) {

                        var round = Math.round(value.points);
                        total_points = total_points + round;
                        total_max_points = total_max_points + Math.round(value.maxpoints);
                        var grade = value.grade.toFixed(1);

                        var grade_details = ns.tariff_detail.get_tariff_grade_details(grade);

                        content += '<ul class="tariff_grade_table_row">' +
                            '<li class="column_first">' + grade_values[key]+ '</li>' +
                            '<li class="' + value.color + ' column_second ">' + grade_details.display_text + '</li></ul>';

                    }

                }

            });

            $('#tariff_grade_table_body').html(content);
            $('.points').html(total_points + ' / ' + total_max_points);

        },

        /**
         * Handle all for get tariff details
         */
        get_tariff_details: function () {
            
            var params = ns.tariff_detail.get_url_param([
                'c24api_tariffversion_id',
                'c24api_tariffversion_variation_key',
                'c24api_calculationparameter_id'
            ]);
            params.c24api_mode_id = $('#mode_id').val();
            params.c24api_tracking_id = $('#tracking_id').val();
            params.c24api_provider_id = $('#provider_id').val();
            
            ns.tariff_detail.ajax.get_tariffdetails(params);

        },

        /**
         * Generate the tariff details html from api object
         *
         * @param {object} data
         */
        generate_tariff_details: function(data) {

            if (Object.keys(data).length > 0) {

                ns.tariff_detail.generate_tariff_details_details(data);
                ns.tariff_detail.generate_tariff_details_parts(data.price);
                ns.tariff_detail.generate_save_bonus(data.price.net.saving, data.savings);

            }

        },

        /**
         * Generates the tariff details details html
         *
         * @param {object} data
         */
        generate_tariff_details_details: function (data) {

            $('#tariff_detail_total').html(ns.tariff_detail.clean_up_amount(data.paymentperiod.size.net.total.toFixed(2)) + ' €');

            $.each(tariff_details_details_values, function(key, value) {

                if (typeof data.price.details.PriceParts[key] != 'undefined' &&
                    data.price.details.PriceParts[key] != undefined
                ) {

                    var detail = data.price.details.PriceParts[key];
                    var content = '<ul class="cost_details"><li>' + value + ' (';
                    var name = '';
                    var amount = 0;

                    $.each(detail, function(detail_key, detail_value){

                        if (key == hospital_per_diem) {

                            var split_value = detail_value.name.split('/');

                            if (split_value.length > 1) {

                                name = split_value[1] + ' € ab dem ' + split_value[0].replace('T','') + '. Tag';

                            } else {
                                name = data.hospital_payout_amount + ' € ab dem ' + data.hospital_payout_start + '. Tag';
                            }

                        } else {
                            name += detail_value.name + ', ';
                        }

                        amount +=  detail_value.Tarifbeitrag + detail_value.GZuschlag;

                    });

                    if (name.slice(-2) == ', ') {
                        name = name.slice(0, -2);
                    }

                    content += name + ')</li><li class="amount">';
                    content += ns.tariff_detail.clean_up_amount(Number(amount).toFixed(2)) + ' € </li></ul>';
                    $('.tariff_details_details').append(content)

                }

            });

        },

        /**
         * Generates tariff details amount part to html 
         *
         * @param {object} data
         */
        generate_tariff_details_parts: function (data) {

            if ($('#profession').val() == profession_employee && $('#insured_person').val() == insured_person_adult) {

                var employer_part = data.details.Total.amount - data.net.contribution;
                var content = '<ul class="part"><li>' + employers_contribution +'</li><li class="amount">' + ns.tariff_detail.clean_up_amount(employer_part.toFixed(2)) + ' €</li></ul>';
                content += '<ul class="part employee"><li>' + employees_contribution + '</li><li class="amount">' + ns.tariff_detail.clean_up_amount(data.net.contribution) + ' €</li></ul>';
                $('.tariff_details_parts').append(content);
                $('#employee_block').show();

            } else {
                $('#employee_block').hide();
            }

        },

        /**
         * Generate the html for tariff details savings 
         * 
         * @param {int} saving
         * @param {object} data
         */
        generate_save_bonus: function (saving, data) {

            if (saving > 0 && $('#profession').val() == profession_employee && $('#insured_person').val() == insured_person_adult) {

                var yearly_saving = parseFloat(saving) * 12;
                $('#saving_amount').html(yearly_saving.formatMoneyDe('2', ',', '.') + ' €');
                $('.saving_row').show();

            } else {

                $('.saving_row').hide();

            }

            if(data) {

                $('#saving_row_headline').show();

                $.each(data, function(key, value){

                    if (typeof tariff_details_bonus_values[key] != 'undefined' &&
                        tariff_details_bonus_values[key] != undefined) {

                        var content = '<div class="table_row"><ul><li class="amount_text">' + tariff_details_bonus_values[key] + '</li>';
                        content += '<li class="amount">' + value.limit + '</li></ul>' +
                            '<ul><li class="double_cell">' + value.comment + '</li></ul></div>';

                        $('.tariff_details_saving').append(content);

                    }

                });

            } else {
                $('#saving_row_headline').hide();
            }

        },

        /**
         * Cleans amount and replace . with , and convert to string
         *
         * @param {number|string} amount
         * @returns {string}
         */
        clean_up_amount: function(amount) {

            amount = parseFloat(amount).toFixed(2);
            return amount.toString().replace('.', ',')

        },

        /**
         * Scrolls to Top of Page
         */
        scrollToTop: function () {
            window.scrollTo(0, 0);
        },

        /**
         * Send the ajax request for the tariff features
         */
        get_tariff_feature: function () {

            var params = ns.tariff_detail.get_url_param([
                'c24api_calculationparameter_id'
            ]);
            params['tariff_id'] = $('#tariff_id').val();
            ns.tariff_detail.ajax.get_tarifffeatures(params);

        },

        /**
         * Callback function for ajax request generate the tariff features on the gui
         * 
         * @param {{key:{name:{string}, children:{object}}}} data
         */
        generate_tariff_features: function (data) {
            
            var content = '';

            $.each(data, function(key, value){

                content += '<div class="tariff_feature_part">';
                content += '<div class="tariff_feature_row_head">';
                content += '<h3>' + key + '</h3>';
                content += '<div class="collapse_down collapse"></div>';
                content += '</div>';
                content += '<div class ="tariff_feature_content_part">';


                /**
                 * @param {{name:{string}, {comment:{string}, tooltip:{string}, tooltip_tariff: {string}}} child_value
                 */
                $.each(value.children, function (child_key, child_value) {

                    content += '<div class="tariff_feature_row">';
                    content += '<div class ="tariff_feature_row_content">';
                    content += '<div class ="tariff_feature_content_name">' + child_value.name + '</div>';
                    content += '<div class ="tariff_feature_content_value"><div class="content_value">';

                    if (child_value.comment == 'no') {
                        content += '<div class ="checkmark_red"></div>'
                    } else if (child_value.comment == 'yes') {
                        content += '<div class="checkmark_green"></div>'
                    } else {
                        content += child_value.comment;
                    }
                    
                    content += '</div><div class="tariff_feature_info_icon">?</div>';
                    content += '</div></div>';

                    //Part of the Content Text
                    content += ns.tariff_detail.create_tooltip(child_value);
                    content += '</div></div>';

                });
                
                content += '</div>';
                content +='</div>';

            });

            $('.tariff_features_content').html(content);
            ns.tariff_detail.init_late_events();
            
        },

        /**
         * Creates a Tooltip row
         * @param {{tooltip:{string}, tooltip_tariff:{string}, name:{string}, tooltip_extra: {string}}} element
         */
        create_tooltip: function (element) {

            var content = '<div class="c24-content-row-block-infobox"><div class="c24-content-row-info-text">'+
                '<div class="c24-content-row-info-text-content">';

            if (element.tooltip_extra && element.tooltip_extra != '') {
                content += element.tooltip_extra + '<br />';
                content += '<br/><strong>Tarifleistung: </strong>';
            }

            if (element.tooltip_tariff && element.tooltip_tariff != "") {
                content += element.tooltip_tariff;
            } else{
                content += element.tooltip;
            }

            content +='</div><div class="c24-info-close-row"><i class="fa fa-angle-up"></i></div></div>';

            return content;
        },

        /**
         * On click on the top grade, we will scroll to bottom to "Tarifnote" and simulate click event.
         * But only if target is not open
         */
        click_on_top_grade: function() {

            var $target_element = $('.tariff-node.tariff-box');

            c24.vv.shared.util.scroll_top($target_element.offset().top);

            if ($target_element.find('.tariff-row-hidden').css('display') == 'none') {
                $target_element.click();
            }

        }

    }
    
})($, document, window);
