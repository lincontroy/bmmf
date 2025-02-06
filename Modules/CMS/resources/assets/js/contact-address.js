"use strict";

/**
 * Blog content form callback function
 */
var showCallBackData = function () {
    // hide model
    $("#addContactAddress").modal("hide");
    // reload table
    $(".dataTable").DataTable().ajax.reload();
};

/**
 * Add blog content model open
 */
$(document).on("click", "#add-contact-address-button", function () {
    // set form value
    $("#modelLabel").html("Create Contact Address");
    $("#article_id").val("0");
    $("#contactAddressFormActionBtn").html("Create");
    $("#contact-address-form").find('input[name="_method"]').remove();
    $("#contact-address-form").attr(
        "action",
        $("#contact-address-form").attr("data-insert")
    );

    removeFormValidation(
        $("#contact-address-form"),
        new FormData(document.querySelector("#contact-address-form")),
        true
    );
});

/**
 * Update blog content model open
 */
$(document).on("click", ".edit-contact-address-button", function () {
    // set form value
    $("#image_required_div").html("");
    $("#image").attr("required", false);
    $("#modelLabel").html("Update Contact Address");
    $("#contactAddressFormActionBtn").html("Update");
    $("#contact-address-form").attr("action", $(this).attr("data-action"));
    if (!$("#contact-address-form").find('input[name="_method"]').length) {
        $("#contact-address-form").prepend(
            '<input type="hidden" name="_method" value="patch" />'
        );
    }

    let form = $("#contact-address-form");
    let formData = new FormData(document.querySelector("#contact-address-form"));

    // set form data by route
    setFormValue($(this).attr("data-route"), form, formData).then(
        (response) => {
            if (response) {
                $("#article_id").val(response.article.id);

                if (response.article) {
                    $("#contact_address").val(response.article.article_name);
                    $("#status").val(response.article.status).trigger("change");
                }

                if (response.defaultLanguage) {
                    $("#language_id")
                        .val(response.defaultLanguage.id)
                        .trigger("change");
                }

                if (response.articleLangData) {
                    response.articleLangData.map(function (articleLangData) {
                        if (articleLangData.slug == "contact_address_place") {
                            $("#contact_address_place").val(
                                articleLangData.small_content
                            );
                        } else if (articleLangData.slug == "contact_address_location") {
                            $("#contact_address_location").val(
                                articleLangData.large_content
                            );
                        } else if (articleLangData.slug == "contact_address_contact") {
                            $("#contact_address_contact").val(
                                articleLangData.small_content
                            );
                        }
                    });
                }
            }
        }
    );

    // show model
    $("#addContactAddress").modal("show");
});

/**
 * Get article language data
 */
$(document).on("change", "#language_id", function () {
    var article_id = $("#article_id").val();
    var language_id = $("#language_id option:selected").val();

    $("#contact_address_place").val("");
    $("#contact_address_location").val("");
    $("#contact_address_contact").val("");

    if (article_id && language_id && article_id != 0 && language_id != 0) {
        var getData = $("#contact-address-form").attr("data-getData");
        let routeUrl = getData
            .replace(":article", article_id)
            .replace(":language", language_id);

        $.ajax({
            type: "get",
            url: routeUrl,
            processData: false,
            contentType: false,
            cache: false,
            dataType: "json",
            async: false,
        })
            .then((response) => {
                if (response.data) {
                    response.data.map(function (articleLangData) {
                        if (articleLangData.slug == "contact_address_place") {
                            $("#contact_address_place").val(
                                articleLangData.small_content
                            );
                        } else if (articleLangData.slug == "contact_address_location") {
                            $("#contact_address_location").val(
                                articleLangData.large_content
                            );
                        } else if (articleLangData.slug == "contact_address_contact") {
                            $("#contact_address_contact").val(
                                articleLangData.small_content
                            );
                        }
                    });
                }
            })
            .catch(function (response) {});
    }
});
