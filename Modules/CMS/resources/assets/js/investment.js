"use strict";

/**
 * Investment form callback function
 */
var showCallBackData = function () {
    // hide model
    $("#addInvestment").modal("hide");
    // reload table
    $(".dataTable").DataTable().ajax.reload();
};

/**
 * Add investment model open
 */
$(document).on("click", "#add-investment-button", function () {
    // set form value
    $("#image_required_div").html("*");
    $("#image").attr("required", true);
    $("#modelLabel").html("Create Investment");
    $("#article_id").val("0");
    $("#investmentFormActionBtn").html("Create");
    $("#investment-form").find('input[name="_method"]').remove();
    $("#investment-form").attr(
        "action",
        $("#investment-form").attr("data-insert")
    );

    removeFormValidation(
        $("#investment-form"),
        new FormData(document.querySelector("#investment-form")),
        true
    );
});

/**
 * Update investment model open
 */
$(document).on("click", ".edit-investment-button", function () {
    // set form value
    $("#image_required_div").html("");
    $("#image").attr("required", false);
    $("#modelLabel").html("Update Investment");
    $("#investmentFormActionBtn").html("Update");
    $("#investment-form").attr("action", $(this).attr("data-action"));
    if (!$("#investment-form").find('input[name="_method"]').length) {
        $("#investment-form").prepend(
            '<input type="hidden" name="_method" value="patch" />'
        );
    }

    let form = $("#investment-form");
    let formData = new FormData(document.querySelector("#investment-form"));

    // set form data by route
    setFormValue($(this).attr("data-route"), form, formData).then(
        (response) => {
            if (response) {
                $("#article_id").val(response.article.id);

                if (response.article) {
                    $("#investment_name").val(response.article.article_name);
                    $("#status").val(response.article.status).trigger("change");
                }

                if (response.articleData) {
                    response.articleData.map(function (articleData) {
                        if (articleData.slug == "url") {
                            $("#button_link").val(articleData.content);
                        } else if (articleData.slug == "image") {
                        }
                    });
                }

                if (response.defaultLanguage) {
                    $("#language_id")
                        .val(response.defaultLanguage.id)
                        .trigger("change");
                }

                if (response.articleLangData) {
                    response.articleLangData.map(function (articleLangData) {
                        if (articleLangData.slug == "investment_header_title") {
                            $("#investment_header_title").val(
                                articleLangData.small_content
                            );
                        } else if (
                            articleLangData.slug == "investment_header_content"
                        ) {
                            $("#investment_header_content").val(
                                articleLangData.large_content
                            );
                        } else if (
                            articleLangData.slug == "investment_button_text"
                        ) {
                            $("#investment_button_text").val(
                                articleLangData.small_content
                            );
                        }
                    });
                }
            }
        }
    );

    // show model
    $("#addInvestment").modal("show");
});

/**
 * Get article language data
 */
$(document).on("change", "#language_id", function () {
    var article_id = $("#article_id").val();
    var language_id = $("#language_id option:selected").val();

    $("#investment_header_title").val("");
    $("#investment_header_content").val("");
    $("#about_content").val("");
    $("#investment_button_text").val("");

    if (article_id && language_id && article_id != 0 && language_id != 0) {
        $("#menu_name").val("");
        var getData = $("#investment-form").attr("data-getData");
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
                        if (articleLangData.slug == "investment_header_title") {
                            $("#investment_header_title").val(
                                articleLangData.small_content
                            );
                        } else if (
                            articleLangData.slug == "investment_header_content"
                        ) {
                            $("#investment_header_content").val(
                                articleLangData.large_content
                            );
                        } else if (
                            articleLangData.slug == "investment_button_text"
                        ) {
                            $("#investment_button_text").val(
                                articleLangData.small_content
                            );
                        }
                    });
                }
            })
            .catch(function (response) {});
    }
});
