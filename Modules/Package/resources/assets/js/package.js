'use strict';

let showCallBackData = function () {
    $('#addPackage').modal('hide');
    $('#packages-table').DataTable().ajax.reload();
}

$(document).on('click', '#add-user-button', function () {

    $('#modelLabel').html('Add Package');
    $('.actionBtn').html('Submit');

    $('#package-form').find('input[name="_method"]').remove();
    $('#package-form').attr('action', $("#package-form").attr('data-insert'));

    removeFormValidation($('#package-form'), new FormData(document.querySelector('#package-form')), true)
});

/*$(document).on('click', '.edit-button', function () {
    let route = $(this).attr('data-route');
    $("#package-form").prepend('@method("patch")');
});*/

$(document).ready(function(){

    $('.placeholder-single').select2({
        dropdownParent: $('#addPackage')
    });

    $('#package-form').find('.amountRow').css({
        "display": "none",
    });
    $('#package-form').find('.capitalBackRow').css({
        "display": "none",
    });
    $('#package-form').find('.interestAmt').css({
        "display": "none",
    });

});

$('#interest_type').on('change', function (){
    let interestType = $(this).val();
    if(interestType === '2'){
        $('#package-form').find('.interestAmt').removeAttr('style');
        $('#package-form').find('.interestPercent').css({
            "display": "none",
        });
    } else {
        $('#package-form').find('.interestPercent').removeAttr('style');
        $('#package-form').find('.interestAmt').css({
            "display": "none",
        });
    }
});

$('#invest_type').on('change', function (){
    let investType = $(this).val();
    if(investType === '2'){
        $('#package-form').find('.amountRow').removeAttr('style');
        $('#package-form').find('#amount').attr('required');
        $('#package-form').find('#min_price').removeAttr('required');
        $('#package-form').find('#max_price').removeAttr('required');
        $('#package-form').find('#min_price').val('');
        $('#package-form').find('#max_price').val('');
        $('#package-form').find('.rangeRow').css({
            "display": "none",
        });
    } else {
        $('#package-form').find('.rangeRow').removeAttr('style');
        $('#package-form').find('#amount').removeAttr('required');
        $('#package-form').find('#amount').val();
        $('#package-form').find('#min_price').attr('required');
        $('#package-form').find('#max_price').attr('required');
        $('#package-form').find('.amountRow').css({
            "display": "none",
        });
    }
});

$('#return_type').on('change', function (){
    let returnType = $(this).val();
    if(returnType === '2'){

        $('#package-form').find('.capitalBackRow').removeAttr('style');
        $('#package-form').find('#repeat_time').attr('required');
        $('#package-form').find('#capital_back').attr('required');

    } else {

        $('#package-form').find('#repeat_time').removeAttr('required');
        $('#package-form').find('#capital_back').removeAttr('required');
        $('#package-form').find('#repeat_time').val('');
        $('#package-form').find('#capital_back').val('');
        $('#package-form').find('.capitalBackRow').css({
            "display": "none",
        });
    }
});

$(document).on('click', '.edit-button', function() {
    // set form value
    $("#modelLabel").html('Update Package');
    $(".actionBtn").html('Update');
    $("#package-form").attr('action', $(this).attr('data-action'));

    if (!$("#package-form").find('input[name="_method"]').length) {
        $("#package-form").prepend('<input type="hidden" name="_method" value="patch" />');
    }

    // set form data by route
    let result = setFormValue($(this).attr('data-route'), $('#package-form'), new FormData(document
        .querySelector(
            '#package-form')));

    result.then(data =>{

        let investType = data.invest_type;
        let returnType = data.return_type;

        if(investType === '2'){
            $('#amount').val(data.min_price);
        }

        if(returnType === '2'){
            $('#capital_back').val(data.capital_back).trigger('change');
        }

        $('#invest_type').val(investType).trigger('change');
        $('#interest_type').val(data.interest_type).trigger('change');
        $('#plan_time_id').val(data.plan_time_id).trigger('change');
        $('#return_type').val(data.return_type).trigger('change');

    }).catch(res =>{

    });

    // show model
    $("#addPackage").modal('show');
});
