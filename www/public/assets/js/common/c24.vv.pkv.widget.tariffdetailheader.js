/**
 * Created by sebastian.bretschneider on 25.11.2015.
 */
$( document ).ready(function() {

    //Set the Select-Option with id=c24api_pdhospital_payout_amount_value of zero
    function set_select_payout_amount_value_of_zero(){

        $('#c24api_pdhospital_payout_amount_value option').removeAttr('selected');
        $("#c24api_pdhospital_payout_amount_value option[value='0']").attr('selected',true);
        $('#c24api_pdhospital_payout_amount_value-button span').text('0 \u20ac').css('color' , '#999');
        $('#c24api_pdhospital_payout_amount_value').css('visibility', 'hidden');

    }

    //Set the Select-Option with id=c24api_pdhospital_payout_start of zero
    function set_select_pdhospital_payout_start_of_zero(){

        $('#c24api_pdhospital_payout_start option').removeAttr('selected');
        $("#c24api_pdhospital_payout_start option[value='0']").attr('selected',true);
        $('#c24api_pdhospital_payout_start-button span').text('kein Krankentagegeld');
        $('#c24api_pdhospital_payout_amount_value-button span').css('color' , '#999');
        $('#c24api_pdhospital_payout_amount_value').css('visibility', 'hidden');

    }

    $("#c24api_pdhospital_payout_start").change(function(){

        if($('#c24api_pdhospital_payout_start option:selected').val() == 0){
            set_select_payout_amount_value_of_zero();
        }else{

            $('#c24api_pdhospital_payout_amount_value').css('visibility', 'visible');
            $('#c24api_pdhospital_payout_amount_value-button span').css('color' , '#333');

        }

    });

    $("#c24api_pdhospital_payout_amount_value").change(function(){

         if($('#c24api_pdhospital_payout_amount_value option:selected').val() == 0){
             set_select_pdhospital_payout_start_of_zero();
         }

    });

    if($('#c24api_pdhospital_payout_start option:selected').val() == 0){
        set_select_payout_amount_value_of_zero();
    }else{
        $('#c24api_pdhospital_payout_amount_value').css({'visibility' : 'visible' ,'color' : '#333'});
    }

    if($('#c24api_pdhospital_payout_amount_value option:selected').val() == 0){
        set_select_pdhospital_payout_start_of_zero();
    }

});