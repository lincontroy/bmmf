"use strict";

/**
 * Merchant title Form callback function
 */
var showTitleCallBackData = function () {
    // hide model
    $("#updateMerchantTitle").modal("hide");
    // reload table
    $(".dataTable").DataTable().ajax.reload();
};

/**
 * Merchant content Form callback function
 */
var showCallBackData = function () {
    // hide model
    $("#addMerchantContent").modal("hide");
    // reload table
    $(".dataTable").DataTable().ajax.reload();
};

/**
 * Update merchant title model open
 */
$(document).on("click", "#update-merchant-title-button", function () {
    // set form value
    $("#modelTitleLabel").html("Update Merchant Title");
    $("#merchantTitleFormActionBtn").html("Update");
    let action = $(this).attr("data-action");

    $("#merchant-title-form").attr("action", $(this).attr("data-action"));

    if (!$("#merchant-title-form").find('input[name="_method"]').length) {
        $("#merchant-title-form").prepend(
            '<input type="hidden" name="_method" value="patch" />'
        );
    }

    let form = $("#merchant-title-form");
    let formData = new FormData(document.querySelector("#merchant-title-form"));

    // set form data by route
    setFormValue($(this).attr("data-route"), form, formData).then(
        (response) => {
            if (response) {
                $("#title_article_id").val(response.article.id);

                if (response.article) {
                    $("#merchant_title").val(response.article.article_name);
                    $("#title_status")
                        .val(response.article.status)
                        .trigger("change");
                }

                if (response.defaultLanguage) {
                    $("#title_language_id")
                        .val(response.defaultLanguage.id)
                        .trigger("change");
                }

                if (response.articleLangData) {
                    response.articleLangData.map(function (articleLangData) {
                        if (articleLangData.slug == "merchant_title_header") {
                            $("#merchant_title_header").val(
                                articleLangData.small_content
                            );
                        } else if (
                            articleLangData.slug == "merchant_title_content"
                        ) {
                            $("#merchant_title_content").val(
                                articleLangData.large_content
                            );
                        }
                    });
                }
            }
        }
    );

    // show model
    $("#updateMerchantTitle").modal("show");
});

/**
 * Get merchant title language article data
 */
$(document).on("change", "#title_language_id", function () {
    var article_id = $("#title_article_id").val();
    var language_id = $("#title_language_id option:selected").val();

    $("#merchant_title_header").val("");
    $("#merchant_title_content").val("");

    if (article_id && language_id && article_id != 0 && language_id != 0) {
        var getData = $("#merchant-title-form").attr("data-getData");
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
                        if (articleLangData.slug == "merchant_title_header") {
                            $("#merchant_title_header").val(
                                articleLangData.small_content
                            );
                        } else if (
                            articleLangData.slug == "merchant_title_content"
                        ) {
                            $("#merchant_title_content").val(
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
 * Add merchant content model open
 */
$(document).on("click", "#add-merchant-content-button", function () {
    // set form value
    $("#image_required_div").html("*");
    $("#image").attr("required", true);
    $("#modelLabel").html("Create Merchant Content");
    $("#article_id").val("0");
    $("#merchantContentFormActionBtn").html("Create");
    $("#merchant-content-form").find('input[name="_method"]').remove();
    $("#merchant-content-form").attr(
        "action",
        $("#merchant-content-form").attr("data-insert")
    );

    removeFormValidation(
        $("#merchant-content-form"),
        new FormData(document.querySelector("#merchant-content-form")),
        true
    );
});

/**
 * Update merchant content model open
 */
$(document).on("click", ".edit-merchant-content-button", function () {
    // set form value
    $("#image_required_div").html("");
    $("#image").attr("required", false);
    $("#modelLabel").html("Update Merchant Content");
    $("#merchantContentFormActionBtn").html("Update");
    $("#merchant-content-form").attr("action", $(this).attr("data-action"));
    if (!$("#merchant-content-form").find('input[name="_method"]').length) {
        $("#merchant-content-form").prepend(
            '<input type="hidden" name="_method" value="patch" />'
        );
    }

    let form = $("#merchant-content-form");
    let formData = new FormData(
        document.querySelector("#merchant-content-form")
    );

    // set form data by route
    setFormValue($(this).attr("data-route"), form, formData).then(
        (response) => {
            if (response) {
                $("#article_id").val(response.article.id);

                if (response.article) {
                    $("#merchant_content").val(response.article.article_name);
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
                        if (articleLangData.slug == "merchant_content_header") {
                            $("#merchant_content_header").val(
                                articleLangData.large_content
                            );
                        } else if (
                            articleLangData.slug == "merchant_content_body"
                        ) {
                            $("#merchant_content_body").val(
                                articleLangData.large_content
                            );
                        }
                    });
                }
            }
        }
    );

    // show model
    $("#addMerchantContent").modal("show");
});

/**
 * Get article language data
 */
$(document).on("change", "#language_id", function () {
    var article_id = $("#article_id").val();
    var language_id = $("#language_id option:selected").val();

    $("#merchant_content_header").val("");
    $("#merchant_content_body").val("");

    if (article_id && language_id && article_id != 0 && language_id != 0) {
        var getData = $("#merchant-content-form").attr("data-getData");
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
                        if (articleLangData.slug == "merchant_content_header") {
                            $("#merchant_content_header").val(
                                articleLangData.large_content
                            );
                        } else if (
                            articleLangData.slug == "merchant_content_body"
                        ) {
                            $("#merchant_content_body").val(
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
 * Top merchant banner Form callback function
 */
var showTopBannerCallBackData = function () {
    // hide model
    $("#updateMerchantTopBanner").modal("hide");
};

/**
 * Update top banner button model open
 */
$(document).on("click", "#update-merchant-top-banner-button", function () {
    // set form value
    $("#modelTopBannerLabel").html("Update Merchant Top Banner");
    $("#merchantTopBannerFormActionBtn").html("Update");
    let action = $(this).attr("data-action");

    $("#merchant-top-banner-form").attr("action", $(this).attr("data-action"));

    if (!$("#merchant-top-banner-form").find('input[name="_method"]').length) {
        $("#merchant-top-banner-form").prepend(
            '<input type="hidden" name="_method" value="patch" />'
        );
    }

    let form = $("#merchant-top-banner-form");
    let formData = new FormData(
        document.querySelector("#merchant-top-banner-form")
    );

    // set form data by route
    setFormValue($(this).attr("data-route"), form, formData).then(
        (response) => {
            if (response) {
                $("#top_banner_article_id").val(response.article.id);

                if (response.article) {
                    $("#merchant_top_banner").val(
                        response.article.article_name
                    );
                    $("#top_banner_status")
                        .val(response.article.status)
                        .trigger("change");
                }

                if (response.defaultLanguage) {
                    $("#top_banner_language_id")
                        .val(response.defaultLanguage.id)
                        .trigger("change");
                }

                if (response.articleLangData) {
                    response.articleLangData.map(function (articleLangData) {
                        if (
                            articleLangData.slug == "merchant_top_banner_title"
                        ) {
                            $("#merchant_top_banner_title").val(
                                articleLangData.small_content
                            );
                        }
                    });
                }
            }
        }
    );

    // show model
    $("#updateBanner").modal("show");
});

/**
 * Get top banner data
 */
$(document).on("change", "#top_banner_language_id", function () {
    var article_id = $("#top_banner_article_id").val();
    var language_id = $("#top_banner_language_id option:selected").val();

    $("#merchant_top_banner_title").val("");

    if (article_id && language_id && article_id != 0 && language_id != 0) {
        var getData = $("#merchant-top-banner-form").attr(
            "data-getData"
        );
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
                            articleLangData.slug == "merchant_top_banner_title"
                        ) {
                            $("#merchant_top_banner_title").val(
                                articleLangData.small_content
                            );
                        }
                    });
                }
            })
            .catch(function (response) {});
    }
});
