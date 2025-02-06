"use strict";

/**
 * Language Form callback function
 */
var showCallBackData = function () {
    // hide model
    $("#addFeeSetting").modal("hide");
    // reload table
    $(".dataTable").DataTable().ajax.reload();
};

/**
 * Add language model open
 */
$(document).on("click", "#add-language-button", function () {
    // set form value
    $("#modelLabel").html("Create Fee Setting");
    $("#feeSettingFormActionBtn").html("Create");
    $("#fee-setting-form").find('input[name="_method"]').remove();
    $("#fee-setting-form").attr(
        "action",
        $("#fee-setting-form").attr("data-insert")
    );
    $("#password_required").html("*");
    $("#password").attr({
        required: true,
    });
    let form = $("#fee-setting-form");
    let formData = new FormData(document.querySelector("#fee-setting-form"));
    removeFormValidation(form, formData, true);
});

/**
 * Update language model open
 */
$(document).on("click", ".edit-fee-setting-button", function () {
    // set form value
    $("#modelLabel").html("Update Fee Setting");
    $("#feeSettingFormActionBtn").html("Update");
    $("#fee-setting-form").attr("action", $(this).attr("data-action"));
    if (!$("#fee-setting-form").find('input[name="_method"]').length) {
        $("#fee-setting-form").prepend(
            '<input type="hidden" name="_method" value="patch" />'
        );
    }

    // set form data by route
    setFormValue(
        $(this).attr("data-route"),
        $("#fee-setting-form"),
        new FormData(document.querySelector("#fee-setting-form"))
    );

    // show model
    $("#addFeeSetting").modal("show");
});
