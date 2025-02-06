"use strict";

/**
 * Why chose customer Form callback function
 */
var showHeaderCallBackData = function () {
    // hide model
    $("#updateWhyChoseHeader").modal("hide");
    // reload table
    $(".dataTable").DataTable().ajax.reload();
};

/**
 * Why chose content Form callback function
 */
var showCallBackData = function () {
    // hide model
    $("#addWhyChoseContent").modal("hide");
    // reload table
    $(".dataTable").DataTable().ajax.reload();
};

/**
 * Update why chose header model open
 */
$(document).on("click", "#update-why-chose-header-button", function () {
    // set form value
    $("#modelWhyChoseLabel").html("Update Why Chose Content");
    $("#whyChoseHeaderFormActionBtn").html("Update");
    let action = $(this).attr("data-action");

    $("#why-chose-header-form").attr("action", $(this).attr("data-action"));

    if (!$("#why-chose-header-form").find('input[name="_method"]').length) {
        $("#why-chose-header-form").prepend(
            '<input type="hidden" name="_method" value="patch" />'
        );
    }

    let form = $("#why-chose-header-form");
    let formData = new FormData(
        document.querySelector("#why-chose-header-form")
    );

    // set form data by route
    setFormValue($(this).attr("data-route"), form, formData).then(
        (response) => {
            if (response) {
                $("#header_article_id").val(response.article.id);

                if (response.article) {
                    $("#why_choose_header").val(response.article.article_name);
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
                        if (articleLangData.slug == "why_choose_header_title") {
                            $("#why_choose_header_title").val(
                                articleLangData.small_content
                            );
                        } else if (
                            articleLangData.slug == "why_choose_header_content"
                        ) {
                            $("#why_choose_header_content").val(
                                articleLangData.large_content
                            );
                        }
                    });
                }
            }
        }
    );

    // show model
    $("#updateWhyChoseHeader").modal("show");
});

/**
 * Get why chose header article data
 */
$(document).on("change", "#header_language_id", function () {
    var article_id = $("#header_article_id").val();
    var language_id = $("#header_language_id option:selected").val();

    $("#why_choose_header_title").val("");
    $("#why_choose_header_content").val("");

    if (article_id && language_id && article_id != 0 && language_id != 0) {
        var getData = $("#why-chose-header-form").attr("data-getData");
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
                        if (articleLangData.slug == "why_choose_header_title") {
                            $("#why_choose_header_title").val(
                                articleLangData.small_content
                            );
                        } else if (
                            articleLangData.slug == "why_choose_header_content"
                        ) {
                            $("#why_choose_header_content").val(
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
 * Add why chose content model open
 */
$(document).on("click", "#add-why-chose-content-button", function () {
    // set form value
    $("#image_required_div").html("*");
    $("#image").attr("required", true);
    $("#modelLabel").html("Create Why Chose Content");
    $("#article_id").val("0");
    $("#whyChoseContentFormActionBtn").html("Create");
    $("#why-chose-content-form").find('input[name="_method"]').remove();
    $("#why-chose-content-form").attr(
        "action",
        $("#why-chose-content-form").attr("data-insert")
    );

    removeFormValidation(
        $("#why-chose-content-form"),
        new FormData(document.querySelector("#why-chose-content-form")),
        true
    );
});

/**
 * Update why chose content model open
 */
$(document).on("click", ".edit-why-chose-content-button", function () {
    // set form value
    $("#image_required_div").html("");
    $("#image").attr("required", false);
    $("#modelLabel").html("Update Why Chose Content");
    $("#whyChoseContentFormActionBtn").html("Update");
    $("#why-chose-content-form").attr("action", $(this).attr("data-action"));
    if (!$("#why-chose-content-form").find('input[name="_method"]').length) {
        $("#why-chose-content-form").prepend(
            '<input type="hidden" name="_method" value="patch" />'
        );
    }

    let form = $("#why-chose-content-form");
    let formData = new FormData(
        document.querySelector("#why-chose-content-form")
    );

    // set form data by route
    setFormValue($(this).attr("data-route"), form, formData).then(
        (response) => {
            if (response) {
                $("#article_id").val(response.article.id);

                if (response.article) {
                    $("#why_choose_content").val(response.article.article_name);
                    $("#status").val(response.article.status).trigger("change");
                }

                if (response.articleData) {
                    response.articleData.map(function (articleData) {
                        if (articleData.slug == "image") {
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
                        if (
                            articleLangData.slug == "why_choose_content_header"
                        ) {
                            $("#why_choose_content_header").val(
                                articleLangData.small_content
                            );
                        } else if (
                            articleLangData.slug == "why_choose_content_body"
                        ) {
                            $("#why_choose_content_body").val(
                                articleLangData.large_content
                            );
                        }
                    });
                }
            }
        }
    );

    // show model
    $("#addWhyChoseContent").modal("show");
});

/**
 * Get why chose content article data
 */
$(document).on("change", "#language_id", function () {
    var article_id = $("#article_id").val();
    var language_id = $("#language_id option:selected").val();

    $("#why_choose_content_header").val("");
    $("#why_choose_content_body").val("");

    if (article_id && language_id && article_id != 0 && language_id != 0) {
        var getData = $("#why-chose-content-form").attr("data-getData");
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
                        if (
                            articleLangData.slug == "why_choose_content_header"
                        ) {
                            $("#why_choose_content_header").val(
                                articleLangData.small_content
                            );
                        } else if (
                            articleLangData.slug == "why_choose_content_body"
                        ) {
                            $("#why_choose_content_body").val(
                                articleLangData.large_content
                            );
                        }
                    });
                }
            })
            .catch(function (response) {});
    }
});
