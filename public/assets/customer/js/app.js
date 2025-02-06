'use strict';

let showCallBackData = function () {
    $('#addCustomer').modal('hide');
    $('#customer-tbl').DataTable().ajax.reload();
}

$(document).on('click', '#add-user-button', function () {

    $('#addCustomerModalLabel').html('Add Customer');
    $('.actionBtn').html('Submit');

    $('#customer-form').find('input[name="_method"]').remove();
    $('#customer-form').attr('action', $("#customer-form").attr('data-insert'));

    $('#addCustomer').find('#customer-form').find('#password').attr('required', 'required');
    $('#addCustomer').find('#customer-form').find('#password_confirmation').attr('required', 'required');
    $('#addCustomer').find('#customer-form').find('.password').text('*');
    $('#addCustomer').find('#customer-form').find('.password_confirmation').text('*');

    removeFormValidation($('#customer-form'), new FormData(document.querySelector('#customer-form')), true)
});

$(document).on('click', '.edit-data', function() {
    // set form value
    $("#addCustomerModalLabel").html('Update Customer');
    $(".actionBtn").html('Update');

    $("#customer-form").attr('action', $(this).attr('data-route'));

    if (!$("#customer-form").find('input[name="_method"]').length) {
        $("#customer-form").prepend('<input type="hidden" name="_method" value="patch" />');
    }
    // show model
    $("#addCustomer").modal('show');
    setTimeout(removeRequiredAttributes, 2000);
});

function removeRequiredAttributes() {
    $('#addCustomer').find('#customer-form').find('#password').removeAttr('required');
    $('#addCustomer').find('#customer-form').find('#password_confirmation').removeAttr('required');
    $('#addCustomer').find('#customer-form').find('.password').text('');
    $('#addCustomer').find('#customer-form').find('.password_confirmation').text('');
    $('#addCustomer').find('#customer-form').removeClass('was-validated');

    console.log("yes here now");
}
