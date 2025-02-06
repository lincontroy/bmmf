"use strict";

/**
 * Our rate header Form callback function
 */
var showCallBackData = function () {
    // hide model
    $("#addOurRate").modal("hide");
    // reload table
    $(".dataTable").DataTable().ajax.reload();
};

/**
 * Add our rate content model open
 */
$(document).on("click", "#add-our-rate-button", function () {
    // set form value
    $("#image_required_div").html("*");
    $("#image").attr("required", true);
    $("#modelLabel").html("Create Our Rate Content");
    $("#article_id").val("0");
    $("#formActionBtn").html("Create");
    $("#our-rate-form").find('input[name="_method"]').remove();
    $("#our-rate-form").attr("action", $("#our-rate-form").attr("data-insert"));

    removeFormValidation(
        $("#our-rate-form"),
        new FormData(document.querySelector("#our-rate-form")),
        true
    );
});

/**
 * Update our rate content model open
 */
$(document).on("click", ".edit-our-rate-button", function () {
    // set form value
    $("#modelLabel").html("Update Our Rate Content");
    $("#formActionBtn").html("Update");
    $("#our-rate-form").attr("action", $(this).attr("data-action"));
    if (!$("#our-rate-form").find('input[name="_method"]').length) {
        $("#our-rate-form").prepend(
            '<input type="hidden" name="_method" value="patch" />'
        );
    }

    let form = $("#our-rate-form");
    let formData = new FormData(document.querySelector("#our-rate-form"));

    // set form data by route
    setFormValue($(this).attr("data-route"), form, formData).then(
        (response) => {
            if (response) {
                $("#article_id").val(response.article.id);

                if (response.article) {
                    $("#our_rate_content").val(response.article.article_name);
                    $("#status").val(response.article.status).trigger("change");
                }

                if (response.defaultLanguage) {
                    $("#language_id")
                        .val(response.defaultLanguage.id)
                        .trigger("change");
                }

                if (response.articleLangData) {
                    response.articleLangData.map(function (articleLangData) {
                        if (articleLangData.slug == "our_rate_content_title") {
                            $("#our_rate_content_title").val(
                                articleLangData.small_content
                            );
                        } else if (
                            articleLangData.slug == "our_rate_content_body"
                        ) {
                            $("#our_rate_content_body").val(
                                articleLangData.small_content
                            );
                        }
                    });
                }
            }
        }
    );

    // show model
    $("#addOurRate").modal("show");
});

/**
 * Get article language data
 */
$(document).on("change", "#language_id", function () {
    var article_id = $("#article_id").val();
    var language_id = $("#language_id option:selected").val();

    $("#our_rate_content_title").val("");
    $("#our_rate_content_body").val("");

    if (article_id && language_id && article_id != 0 && language_id != 0) {
        var getData = $("#our-rate-form").attr("data-getData");
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
                        if (articleLangData.slug == "our_rate_content_title") {
                            $("#our_rate_content_title").val(
                                articleLangData.small_content
                            );
                        } else if (
                            articleLangData.slug == "our_rate_content_body"
                        ) {
                            $("#our_rate_content_body").val(
                                articleLangData.small_content
                            );
                        }
                    });
                }
            })
            .catch(function (response) {});
    }
});

/**
 * Our rate header Form callback function
 */
var showHeaderCallBackData = function () {
    // hide model
    $("#updateHeader").modal("hide");
};

/**
 * Update update our rate button model open
 */
$(document).on("click", "#update-header-button", function () {
    // set form value
    $("#modelHeaderLabel").html("Update Our Rate Header");
    $("#headerFormActionBtn").html("Update");
    let action = $(this).attr("data-action");

    $("#header-form").attr("action", $(this).attr("data-action"));

    if (!$("#header-form").find('input[name="_method"]').length) {
        $("#header-form").prepend(
            '<input type="hidden" name="_method" value="patch" />'
        );
    }

    let form = $("#header-form");
    let formData = new FormData(document.querySelector("#header-form"));

    // set form data by route
    setFormValue($(this).attr("data-route"), form, formData).then(
        (response) => {
            if (response) {
                $("#header_article_id").val(response.article.id);

                if (response.article) {
                    $("#our_rates_header").val(response.article.article_name);
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
                        if (articleLangData.slug == "our_rates_header_title") {
                            $("#our_rates_header_title").val(
                                articleLangData.small_content
                            );
                        } else if (
                            articleLangData.slug == "our_rates_header_content"
                        ) {
                            $("#our_rates_header_content").val(
                                articleLangData.large_content
                            );
                        }
                    });
                }
            }
        }
    );

    // show model
    $("#updateHeader").modal("show");
});

/**
 * Get our rate header data
 */
$(document).on("change", "#header_language_id", function () {
    var article_id = $("#header_article_id").val();
    var language_id = $("#header_language_id option:selected").val();

    $("#our_rate_header_head").val("");
    $("#our_rate_header_content").val("");

    if (article_id && language_id && article_id != 0 && language_id != 0) {
        var getData = $("#header-form").attr("data-getData");
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
                        if (articleLangData.slug == "our_rates_header_title") {
                            $("#our_rates_header_title").val(
                                articleLangData.small_content
                            );
                        } else if (
                            articleLangData.slug == "our_rates_header_content"
                        ) {
                            $("#our_rates_header_content").val(
                                articleLangData.large_content
                            );
                        }
                    });
                }
            })
            .catch(function (response) {});
    }
});
