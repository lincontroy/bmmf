"use strict";
/**
 * Fiat Currency Form callback function
 */
var showCallBackData = function () {
    // hide model
    $("#fiatCurrencyAddModal").modal("hide");
    // reload table
    $(".dataTable").DataTable().ajax.reload();
};

/**
 * Add Fiat Currency model open
 */
$(document).on("click", "#add-fiat-currency-button", function () {
    // set form value
    $("input[name='status']").prop("checked", false);
    $("#active_status").prop("checked", true);

    $("#modelLabel").html("Create Fiat Currency");
    $("#actionBtn").html("Create");
    $("#fiat-currency-form").find('input[name="_method"]').remove();
    $("#fiat-currency-form").attr(
        "action",
        $("#fiat-currency-form").attr("data-insert")
    );

    removeFormValidation(
        $("#fiat-currency-form"),
        new FormData(document.querySelector("#fiat-currency-form")),
        true
    );
});

/**
 * Update Fiat Currency model open
 */
$(document).on("click", ".edit-fiat-currency-button", function () {
    // set form value
    $("input[name='status']").prop("checked", false);
    $("#modelLabel").html("Update Fiat Currency");
    $("#actionBtn").html("Update");
    $("#fiat-currency-form").attr("action", $(this).attr("data-action"));
    if (!$("#fiat-currency-form").find('input[name="_method"]').length) {
        $("#fiat-currency-form").prepend(
            '<input type="hidden" name="_method" value="patch" />'
        );
    }

    let form = $("#fiat-currency-form");
    let formData = new FormData(document.querySelector("#fiat-currency-form"));

    // set form data by route
    setFormValue($(this).attr("data-route"), form, formData).then(
        (response) => {
            if (response) {
                $("#name").val(response.name);
                $("#symbol").val(response.symbol);
                $("#rate").val(response.rate);
                $("input[name='status']").map(function () {
                    if (response.status == $(this).val()) {
                        $(this).prop("checked", true);
                    }
                });
            }
        }
    );

    // show model
    $("#fiatCurrencyAddModal").modal("show");
});
