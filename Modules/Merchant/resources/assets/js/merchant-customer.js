"use strict";

var showCallBackData = function(response) {
    // hide model
    $("#addCustomer").modal('hide');
    // reload table
    $('.dataTable').DataTable().ajax.reload();
}

/**
 * Add blog content model open
 */
$(document).on('click', '#add-customer-button', function() {
    // set form value
    $("#modelLabel").html('Create Customer');
    $("#article_id").val('0');
    $("#customerFormActionBtn").html('Create');
    $("#customer-form").find('input[name="_method"]').remove();
    $("#customer-form").attr('action', $("#customer-form").attr('data-insert'));

    removeFormValidation($('#customer-form'), new FormData(document.querySelector(
        '#customer-form')), true)
});


/**
 * Update blog content model open
 */
$(document).on('click', '.edit-customer-button', function() {
    // set form value
    $("#modelLabel").html('Update Customer');
    $("#customerFormActionBtn").html('Update');
    $("#customer-form").attr('action', $(this).attr('data-action'));
    if (!$("#customer-form").find('input[name="_method"]').length) {
        $("#customer-form").prepend('<input type="hidden" name="_method" value="patch" />');
    }

    let form = $('#customer-form');
    let formData = new FormData(document.querySelector('#customer-form'));

    // set form data by route
    setFormValue($(this).attr('data-route'), form, formData)
        .then((response) => {
            if (response) {
                $("#first_name").val(response.first_name);
                $("#last_name").val(response.last_name);
                $("#email").val(response.email);
            }
        });

    // show model
    $("#addCustomer").modal('show');
});
