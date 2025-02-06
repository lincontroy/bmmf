"use strict";

/**
 * Faq header Form callback function
 */
var showHeaderCallBackData = function () {
    // hide model
    $("#updateFaqHeader").modal("hide");
    // reload table
    $(".dataTable").DataTable().ajax.reload();
};

/**
 * Faq content Form callback function
 */
var showCallBackData = function () {
    // hide model
    $("#addFaqContent").modal("hide");
    // reload table
    $(".dataTable").DataTable().ajax.reload();
};

/**
 * Update faq header model open
 */
$(document).on("click", "#update-faq-header-button", function () {
    // set form value
    $("#modelHeaderLabel").html("Update Faq Content");
    $("#faqHeaderFormActionBtn").html("Update");
    let action = $(this).attr("data-action");

    $("#faq-header-form").attr("action", $(this).attr("data-action"));

    if (!$("#faq-header-form").find('input[name="_method"]').length) {
        $("#faq-header-form").prepend(
            '<input type="hidden" name="_method" value="patch" />'
        );
    }

    let form = $("#faq-header-form");
    let formData = new FormData(document.querySelector("#faq-header-form"));

    // set form data by route
    setFormValue($(this).attr("data-route"), form, formData).then(
        (response) => {
            if (response) {
                $("#header_article_id").val(response.article.id);

                if (response.article) {
                    $("#faq_header").val(response.article.article_name);
                    $("#header_status")
                        .val(response.article.status)
                        .trigger("change");
                }

                if (response.defaultLanguage) {
                    $("#header_language_id")
                        .val(response.defaultLanguage.id)
                        .trigger("change");
                }

                if (response.articleLangData) {
                    response.articleLangData.map(function (articleLangData) {
                        if (articleLangData.slug == "faq_header_title") {
                            $("#faq_header_title").val(
                                articleLangData.small_content
                            );
                        } else if (
                            articleLangData.slug == "faq_header_content"
                        ) {
                            $("#faq_header_content").val(
                                articleLangData.large_content
                            );
                        }
                    });
                }
            }
        }
    );

    // show model
    $("#updateFaqHeader").modal("show");
});

/**
 * Get faq header article data
 */
$(document).on("change", "#header_language_id", function () {
    var article_id = $("#header_article_id").val();
    var language_id = $("#header_language_id option:selected").val();

    $("#faq_header_title").val("");
    $("#faq_header_content").val("");

    if (article_id && language_id && article_id != 0 && language_id != 0) {
        var getData = $("#faq-header-form").attr("data-getData");
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
                        if (articleLangData.slug == "faq_header_title") {
                            $("#faq_header_title").val(
                                articleLangData.small_content
                            );
                        } else if (
                            articleLangData.slug == "faq_header_content"
                        ) {
                            $("#faq_header_content").val(
                                articleLangData.large_content
                            );
                        }
                    });
                }
            })
            .catch(function (response) {});
    }
});

/**
 * Add faq content model open
 */
$(document).on("click", "#add-faq-content-button", function () {
    // set form value
    $("#modelLabel").html("Create Faq Content");
    $("#article_id").val("0");
    $("#faqContentFormActionBtn").html("Create");
    $("#faq-content-form").find('input[name="_method"]').remove();
    $("#faq-content-form").attr(
        "action",
        $("#faq-content-form").attr("data-insert")
    );

    removeFormValidation(
        $("#faq-content-form"),
        new FormData(document.querySelector("#faq-content-form")),
        true
    );
});

/**
 * Update faq content model open
 */
$(document).on("click", ".edit-faq-content-button", function () {
    // set form value
    $("#image_required_div").html("");
    $("#image").attr("required", false);
    $("#modelLabel").html("Update Faq Content");
    $("#faqContentFormActionBtn").html("Update");
    $("#faq-content-form").attr("action", $(this).attr("data-action"));
    if (!$("#faq-content-form").find('input[name="_method"]').length) {
        $("#faq-content-form").prepend(
            '<input type="hidden" name="_method" value="patch" />'
        );
    }

    let form = $("#faq-content-form");
    let formData = new FormData(document.querySelector("#faq-content-form"));

    // set form data by route
    setFormValue($(this).attr("data-route"), form, formData).then(
        (response) => {
            if (response) {
                $("#article_id").val(response.article.id);

                if (response.article) {
                    $("#faq_content").val(response.article.article_name);
                    $("#status").val(response.article.status).trigger("change");
                }

                if (response.defaultLanguage) {
                    $("#language_id")
                        .val(response.defaultLanguage.id)
                        .trigger("change");
                }

                if (response.articleLangData) {
                    response.articleLangData.map(function (articleLangData) {
                        if (articleLangData.slug == "faq_content_data") {
                            $("#question_content").val(
                                articleLangData.small_content
                            );
                            $("#answer_content").val(
                                articleLangData.large_content
                            );
                        }
                    });
                }
            }
        }
    );

    // show model
    $("#addFaqContent").modal("show");
});

/**
 * Get article language data
 */
$(document).on("change", "#language_id", function () {
    var article_id = $("#article_id").val();
    var language_id = $("#language_id option:selected").val();

    $("#question_content").val("");
    $("#answer_content").val("");

    if (article_id && language_id && article_id != 0 && language_id != 0) {
        var getData = $("#faq-content-form").attr("data-getData");
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
                        if (articleLangData.slug == "faq_content_data") {
                            $("#question_content").val(
                                articleLangData.small_content
                            );
                            $("#answer_content").val(
                                articleLangData.large_content
                            );
                        }
                    });
                }
            })
            .catch(function (response) {});
    }
});
