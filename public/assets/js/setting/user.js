"use strict";

/**
 * User Form callback function
 */
var showCallBackData = function () {
    // hide model
    $("#addUser").modal("hide");
    // reload table
    $(".dataTable").DataTable().ajax.reload();
};

/**
 * Add user model open
 */
$(document).on("click", "#add-user-button", function () {
    // set form value
    $("#modelLabel").html("Create User");
    $("#userFormActionBtn").html("Create");
    $("#user-form").find('input[name="_method"]').remove();
    $("#user-form").attr("action", $("#user-form").attr("data-insert"));
    $("#password_required").html("*");
    $("#password").attr({
        required: true,
    });

    removeFormValidation(
        $("#user-form"),
        new FormData(document.querySelector("#user-form")),
        true
    );
});

/**
 * Update user model open
 */
$(document).on("click", ".user-edit-button", function () {
    // set form value
    $("#modelLabel").html("Update User");
    $("#userFormActionBtn").html("Update");
    $("#user-form").attr("action", $(this).attr("data-action"));
    $("#password_required").html("");
    $("#password").attr({
        required: false,
    });
    if (!$("#user-form").find('input[name="_method"]').length) {
        $("#user-form").prepend(
            '<input type="hidden" name="_method" value="patch" />'
        );
    }

    let form = $("#user-form");
    let formData = new FormData(document.querySelector("#user-form"));

    // set form data by route
    setFormValue($(this).attr("data-route"), form, formData)
        .then((data) => {
            form.find(":input, select").each(function () {
                var elementType = this.tagName.toLowerCase();
                var inputObject = $(this);
                var inputName = inputObject.attr("name");
                if (!inputName) {
                    return;
                }

                if (elementType === "input") {
                    var inputType = inputObject.attr("type");
                    if (["radio", "checkbox", "select"].includes(inputType)) {
                        if (
                            inputName.includes("[") &&
                            inputName.includes("]")
                        ) {
                            if (inputType === "checkbox") {
                                var inputValue = inputObject.val();
                                inputName = inputName
                                    .replace("[", "")
                                    .replace("]", "");
                                if (data[inputName]) {
                                    data[inputName].map(function (dataValue) {
                                        if (dataValue.id == inputValue) {
                                            inputObject.prop("checked", true);
                                        }
                                    });
                                }
                            }
                        } else {
                            if (inputType === "checkbox") {
                            }
                        }
                    }
                } else if (elementType === "select") {
                    let fieldname = inputObject.attr("data-fieldname");
                    if (!fieldname) {
                        fieldname = inputName;
                    }

                    let fieldid = inputObject.attr("data-fieldid");
                    if (!fieldid) {
                        fieldid = "id";
                    }

                    if (inputName.includes("[") && inputName.includes("]")) {
                        if (data[fieldname]) {
                            data[fieldname].map(function (dataValue) {
                                $(
                                    'select[name="' +
                                        inputName +
                                        '"] option[value="' +
                                        dataValue[fieldid] +
                                        '"]'
                                ).prop("selected", true);
                            });
                            inputObject.trigger("change");
                        }
                    } else {
                    }
                }
            });
        })
        .catch((data) => {});
    // show model
    $("#addUser").modal("show");
});

/**
 * Module permission checked
 */
$(document).on("click", ".module_group", function () {
    let module_id = $(this).val();
    $(`.module_permissions_${module_id}`)
        .prop("checked", $(this).is(":checked"))
        .closest(".form-check")
        .addClass("checked");
});
