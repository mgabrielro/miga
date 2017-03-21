/**
 * This file is NOT in sync between check24 and form
 * - different showOn (focus|button|both)
 */

c24_datepicker = {
    //datepicker array
    dps : [],
    //callback mapping
    callbacks : [],

    //add date picker
    add : function(dp) {

        this.dps.push(dp);
    },

    // register date pickers
    register : function() {

        $.each(this.dps, function(key, dp) {

            var dp_default = {
                yearRange: '1900:2100',
                constrainInput: false,
                buttonImage: '/assets/images/form/ui/calendar.png',
                buttonImageOnly: true,
                duration: 0,
                showOn: 'button',
                buttonText: 'Kalender',
                changeMonth: true,
                changeYear: true,
                onSelect: function() {
                    c24_datepicker.success(this.id);
                }
            };

            var dp_settings = $.extend(dp_default, dp);

            $('#'+ dp.id).datepicker(dp_settings);

            if(dp.onSuccess) {
                c24_datepicker.callbacks[dp.id] = key;
            }

            $('#'+ dp.id).keyup(function() {
                c24_datepicker.val(this.id);
            });

        });

        $.each(this.dps, function() {
            c24_datepicker.val(this.id);
        });
    },

    // set info
    success : function(id) {

        var date = $('#'+ id).datepicker('getDate');
        $('#'+ id + '_info').html(
            $.datepicker.formatDate(
                'DD, dd. MM yy',
                date
            )
        );

        try { //try to execute callback function
            this.dps[this.callbacks[id]].onSuccess(id, date);
        }
        catch(e) { //no callback

        }
    },

    val : function(id) {

        var regex = /^[0-9]{2}\.{1}[0-9]{2}\.{1}[0-9]{4}$/;
        var node = $('#'+ id);

        var udate = node.attr('value').replace(/[,-/]/g, '.');
        if (udate.match(/^[0-9]{8}$/)) {
            udate = udate.substr(0, 2) + '.' +  udate.substr(2, 2) + '.' + udate.substr(4);
        }

        var udatestandard = udate.replace(/^([1-9]{1})\./, '0$1.').replace(/\.([1-9]{1})\./, '.0$1.');

        if (udatestandard.match(regex) && (node.attr('value') != udate))
        {
            node.attr('value', udate);
        }

        var dpdate = $.datepicker.formatDate(
            'dd.mm.yy',
            node.datepicker('getDate')
        );

        if (dpdate.match(regex) && (udatestandard == dpdate))
        {
            this.success(id);
        }
        else
        {
            $('#'+ id +'_info').html('TT.MM.JJJJ');
        }
    }
};