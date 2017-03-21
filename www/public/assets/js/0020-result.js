(function (namespaceToConstruct, $) {
    'use strict';

    function init_plugins() {
        var $promo_row = $('.c24-result-row.promo');
        
        $('.iMod24Newtip').click(function () {
            $('.iMod24Newtip').hide();
            return false;
        });

        if ($promo_row.length === 1) {
            $promo_row.addClass('fixed-row');
        }
    }

    function refresh_sortbar(sort, order) {
        var $filter = $('.result_sort_bar ul li.result_filter_' + sort),
            $arrows = $filter.find('.result_sort_arrows');

        $filter.siblings().removeClass('active');
        $filter.addClass('active');
        $arrows.removeClass('asc desc');
        $arrows.addClass(order);
    }

    function recalculate() {
        var validator = validateForm();
        if (validator.has_errors()) {
            return;
        }

        var $result_form = $('#resultform'),
            $spinner = $('.pkv_loader');

        $('.iMod24Newtip').hide();
        $spinner.show();

        history.replaceState({}, "input1", c24.routing.getUrl('result') + '?' + $result_form.serialize());

        $.ajax({
            url: $result_form.attr('action'),
            data: $result_form.serialize(),
            success: function (data) {
                $('#result_content').replaceWith($(data).find('#result_content'));
                $('#c24_topbar').replaceWith($(data).find('#c24_topbar'));

                // Activate storage for tariffs
                c24.check24.result.init_storages('tariff_compare');

                c24.check24.result.load();

                refresh_sortbar($('[name=c24api_sortfield]').val(), $('[name=c24api_sortorder]').val());
                c24.result.compare_checkboxes.init();

                c24.check24.result.layout.reset();
                $spinner.hide();
            }
        });
    }

    function init_sort_bar() {
        refresh_sortbar('promotion', 'asc');

        $('body').on('click', '.result_sort_link', function () {
            var $arrows = $(this).find('.result_sort_arrows'),
                sort = $(this).data('sort'),
                order = $arrows.hasClass('asc') ? 'desc' : 'asc';

            $('[name=c24api_sortfield]').val(sort);
            $('[name=c24api_sortorder]').val(order);

            recalculate();

            return false;
        });
    }

    function redirect_to_comparison(compare_link) {
        var selected_tariff_keys = $('.compare_checkbox:checked');

        if (selected_tariff_keys.length === 0) {
            return alert('Sie haben keinen Tarif ausgewählt.');
        }

        if (selected_tariff_keys.length > 3) {
            return alert('Sie haben mehr als 3 Tarife ausgewählt.');
        }

        selected_tariff_keys.each(function (index, element) {
            compare_link += '&c24_tariffversion_key_' + (index + 1) + '=' + $(element).val();
        });

        window.location = compare_link;
    }

    function show_fields_based_on_protectiontype (){
        var protection_type = $('#c24api_protectiontype').val();

        if (protection_type === 'constant') {
            $('#c24api_constant_contribution_container').hide();
        } else {
            $('#tarif-extras').hide();
            $('#c24api_increasing_contribution_container').hide();
            $('#c24api_children_discount_container').hide();
        }
    }

    function init_auto_recalculation() {

        var $result_form = $('#resultform'),
            reload_timer;

        $result_form.find('input[type=text]').on('input', function () {
            clearTimeout(reload_timer);
            reload_timer = setTimeout(function(){
                recalculate();
            }, 2000);
        });

        $result_form.find('input[type=checkbox], select').on('change', function () {
            clearTimeout(reload_timer);
            reload_timer = setTimeout(function(){
                recalculate();
            }, 500);
        });
    }

    function validateForm() {
        var validator = new c24.validator(),
            birth_date = $.parseDate($('#c24api_birthdate').val()),
            birth_date_eu = $.date_obj_to_eu_format(birth_date),
            age = $.get_age_from_date(birth_date_eu);

        validator.validate_numericality($('#c24api_insure_sum'), {error_message: "Die Versicherungssumme muss zwischen 5.000 € und 5.000.000 € liegen.", min: 5000, max: 5000000});
        validator.validate_insurance_period($('#c24api_insure_period'), age);
        return validator;
    }

    (function(ns){})(namespace(namespaceToConstruct, $.noop, {
        'load': function () {
            init_plugins();
            init_sort_bar();

            if (window.deviceoutput == "desktop") {
                init_auto_recalculation();
            }

            $('#trigger_calculation').click(function () {
                var validator = validateForm();
                if (!validator.has_errors()) {
                    recalculate();
                }
            });

            $('#c24-dialog-bar-bg').clone().appendTo('#scroll_header');
            show_fields_based_on_protectiontype();
            c24.result.compare_checkboxes.init();

            $(document).on('click', '[data-compare-link]', function () {
                redirect_to_comparison($(this).data('compare-link'));
            });

            $('#c24api_insure_period').number(true, 0, '', '');
            $('#c24api_insure_sum').number(true, 0, '', '.');
        },

        'init_storages': function(form_id) {
            var storage_resultform = new c24.check24.storage.pv.pkv.load('local', form_id, []);
        }
    }));
})('c24.check24.result', jQuery);
