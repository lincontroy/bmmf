"use strict";

var showCallBackData = function (response) {
    // hide model
    $("#addPaymentUrl").modal("hide");
    // reload table
    $(".dataTable").DataTable().ajax.reload();
};

/**
 * Add payment url model open
 */
$(document).on("click", "#add-payment-url-button", function () {
    // set form value
    $("#modelLabel").html("Create Payment Url");
    $("#article_id").val("0");
    $("#paymentUrlFormActionBtn").html("Create");
    $("#payment-url-form").find('input[name="_method"]').remove();
    $("#payment-url-form").attr(
        "action",
        $("#payment-url-form").attr("data-insert")
    );

    removeFormValidation(
        $("#payment-url-form"),
        new FormData(document.querySelector("#payment-url-form")),
        true
    );
});

/**
 * Update payment url model open
 */
$(document).on("click", ".edit-payment-url-button", function () {
    // set form value
    $("#modelLabel").html("Update Payment Url");
    $("#paymentUrlFormActionBtn").html("Update");
    $("#payment-url-form").attr("action", $(this).attr("data-action"));
    if (!$("#payment-url-form").find('input[name="_method"]').length) {
        $("#payment-url-form").prepend(
            '<input type="hidden" name="_method" value="patch" />'
        );
    }

    let form = $("#payment-url-form");
    let formData = new FormData(document.querySelector("#payment-url-form"));

    // set form data by route
    setFormValue($(this).attr("data-route"), form, formData).then((data) => {
      var dateTime = new Date(data.duration);
      var formattedDateTime = dateTime.getFullYear() + '-' +
                               ('0' + (dateTime.getMonth() + 1)).slice(-2) + '-' +
                               ('0' + dateTime.getDate()).slice(-2) + 'T' +
                               ('0' + dateTime.getHours()).slice(-2) + ':' +
                               ('0' + dateTime.getMinutes()).slice(-2);

        $('#duration').val(formattedDateTime);
    });

    // show model
    $("#addPaymentUrl").modal("show");
});

/**
 * View payment link model open
 */
$(document).on("click", ".view-payment-link", function () {
    // set form data by route
    getAjaxData($(this).attr("data-action")).then((response) => {
        $("#link-modal-content").html(response);
    });
    // show model
    $("#linkModal").modal("show");
});
