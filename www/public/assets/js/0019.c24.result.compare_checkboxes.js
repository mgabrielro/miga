(function(namespace_to_construct){
    "use strict";
    var $compare_checkboxes, checked_checkboxes, $initially_checked_checkboxes;

    function check_default_checkboxes() {

        /* Find already checked checkboxes. They can be already set by localstorage. */
        $initially_checked_checkboxes = $('input:checked.compare_checkbox');

        if ($initially_checked_checkboxes.length == 0) {
            $initially_checked_checkboxes = $compare_checkboxes.slice(0, 3);
        }

        $.each($initially_checked_checkboxes, function () {
            checked_checkboxes.push($compare_checkboxes.index(this));
            $(this).prop('checked', true);
        });
    }

    function update_checkbox_status() {
        if (!$(this).is(':checked')) {
            checked_checkboxes.splice($.inArray($compare_checkboxes.index(this), checked_checkboxes), 1);
        } else if (checked_checkboxes.indexOf($compare_checkboxes.index(this)) == -1) {
            checked_checkboxes.push($compare_checkboxes.index(this));
        }
    }

    function toggle_compare_link() {
        if (checked_checkboxes.length <= 1) {
            $('[data-compare-link]').addClass('disabled');
        } else {
            $('[data-compare-link]').removeClass('disabled');
        }
    }

    function remove_excess_checkboxes() {
        if (checked_checkboxes.length > 3) {
            var index = checked_checkboxes.shift();
            $($compare_checkboxes[index]).prop('checked', false);

            // Uncheck in local storage
            if (c24.check24.storage.pv.pkv.storage_available(localStorage)) {
                localStorage.setItem($($compare_checkboxes[index]).attr('id'), '');
            }
        }
    }

    (function(ns){

    })(namespace(namespace_to_construct, function(){}, {
        init: function(){
            $compare_checkboxes = $('input:checkbox.compare_checkbox');
            checked_checkboxes = [];

            check_default_checkboxes();

            $('input:checkbox.compare_checkbox').click(function () {
                update_checkbox_status.call(this);
                remove_excess_checkboxes();
                toggle_compare_link();
            });
        }
    }));
})("c24.result.compare_checkboxes");