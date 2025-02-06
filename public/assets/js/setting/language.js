"use strict";

/**
 * Language Form callback function
 */
var showCallBackData = function () {
    // hide model
    $("#addLanguage").modal("hide");
    // reload table
    $(".dataTable").DataTable().ajax.reload();
};

/**
 * Add language model open
 */
$(document).on("click", "#add-language-button", function () {
    // set form value
    $("#modelLabel").html("Create Language");
    $("#languageFormActionBtn").html("Create");
    $("#language-form").find('input[name="_method"]').remove();
    $("#language-form").attr("action", $("#language-form").attr("data-insert"));
    $("#password_required").html("*");
    $("#password").attr({
        required: true,
    });

    removeFormValidation(
        $("#language-form"),
        new FormData(document.querySelector("#language-form")),
        true
    );
});

/**
 * Update language model open
 */
$(document).on("click", ".edit-language-button", function () {
    // set form value
    $("#modelLabel").html("Update Language");
    $("#languageFormActionBtn").html("Update");
    $("#language-form").attr("action", $(this).attr("data-action"));
    if (!$("#language-form").find('input[name="_method"]').length) {
        $("#language-form").prepend(
            '<input type="hidden" name="_method" value="patch" />'
        );
    }

    // set form data by route
    setFormValue(
        $(this).attr("data-route"),
        $("#language-form"),
        new FormData(document.querySelector("#language-form"))
    );

    // show model
    $("#addLanguage").modal("show");
});
