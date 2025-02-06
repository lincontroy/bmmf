"use strict";
/**
 * Role Form callback function
 */
var showCallBackData = function () {
    // hide model
    $("#addRole").modal("hide");
    // reload table
    $(".dataTable").DataTable().ajax.reload();
};

/**
 * Add role model open
 */
$(document).on("click", "#add-role-button", function () {
    // set form value
    $("#modelLabel").html("Create Role");
    $("#roleFormActionBtn").html("Create");
    $("#role-form").find('input[name="_method"]').remove();
    $("#role-form").attr("action", $("#role-form").attr("data-insert"));
    $("#password_required").html("*");
    $("#password").attr({
        required: true,
    });

    removeFormValidation(
        $("#role-form"),
        new FormData(document.querySelector("#role-form")),
        true
    );
});

/**
 * Update role model open
 */
$(document).on("click", ".role-edit-button", function () {
    // set form value
    $("#modelLabel").html("Update Role");
    $("#roleFormActionBtn").html("Update");
    $("#role-form").attr("action", $(this).attr("data-action"));
    $("#password_required").html("");
    $("#password").attr({
        required: false,
    });
    if (!$("#role-form").find('input[name="_method"]').length) {
        $("#role-form").prepend(
            '<input type="hidden" name="_method" value="patch" />'
        );
    }

    let form = $("#role-form");
    let formData = new FormData(document.querySelector("#role-form"));

    // set form data by route
    setFormValue($(this).attr("data-route"), form, formData)
        .then((data) => {
            form.find(":input").each(function () {
                var elementType = this.tagName.toLowerCase();
                if (elementType === "input") {
                    var inputObject = $(this);
                    var inputName = inputObject.attr("name");
                    if (!inputName) {
                        return;
                    }
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
                }
            });
        })
        .catch((data) => {});
    // show model
    $("#addRole").modal("show");
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
