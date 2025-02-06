'use strict';

let showCallBackData = function () {
    $('#customerVerifiedModal').modal('hide');
    $('#customer-verify-doc-tbl').DataTable().ajax.reload();
}

$(document).on('click', '.edit-button', function(e,form) {

    $("#customerVerifiedModal").find('.edit-modal').empty();

    let action = $("#customer-verified-form").attr('action', $(this).attr('data-route'));

    // show model
    $("#customerVerifiedModal").modal('show');

});

var action_button_name = ""; // Variable to store the clicked button's value
// Click event listener for buttons
$('button[type=submit]').on('click', function(){
    action_button_name = $(this).val(); // Store clicked button's value
    $(this).html(`<div class="spinner-border spinner-border-sm" role="status">
    <span class="visually-hidden">Loading...</span>
    </div>`);

    setTimeout(() => {
        $(this).html(action_button_name);
    }, 1000);

});

$('#customer-verified-form').submit(function(e) {
    // Prevent the default form submission
    e.preventDefault();
    e.stopPropagation();


    let action = $("#customer-verified-form").attr('action');
    let formAction = e.target;
    let formData = new FormData(formAction);
    formData.append("action_button_name", action_button_name);

    $.ajax({
        type: "POST",
        url: action,
        processData: false,
        contentType: false,
        cache: false,
        dataType: "json",
        data: formData,
        async: false,
        success: function (response) {

            if (response.success == true) {
                success_alert(response.message, response.title);
                $('#customerVerifiedModal').modal('hide');
                $('#customer-verify-doc-tbl').DataTable().ajax.reload();
            }
        },
        error: function (response) {
        },
    });
});

