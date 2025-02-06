"use strict";

/**
 * Top investor banner Form callback function
 */
var showBannerCallBackData = function () {
    // hide model
    $("#updateBanner").modal("hide");
};

/**
 * Update top investor button model open
 */
$(document).on("click", "#update-banner-button", function () {
    // set form value
    $("#modelBannerLabel").html("Update Investor Banner");
    $("#bannerFormActionBtn").html("Update");
    let action = $(this).attr("data-action");

    $("#banner-form").attr("action", $(this).attr("data-action"));

    if (!$("#banner-form").find('input[name="_method"]').length) {
        $("#banner-form").prepend(
            '<input type="hidden" name="_method" value="patch" />'
        );
    }

    let form = $("#banner-form");
    let formData = new FormData(document.querySelector("#banner-form"));

    // set form data by route
    setFormValue($(this).attr("data-route"), form, formData).then(
        (response) => {
            if (response) {
                $("#banner_article_id").val(response.article.id);

                if (response.article) {
                    $("#top_investor_banner").val(
                        response.article.article_name
                    );
                    $("#banner_status")
                        .val(response.article.status)
                        .trigger("change");
                }

                if (response.defaultLanguage) {
                    $("#banner_language_id")
                        .val(response.defaultLanguage.id)
                        .trigger("change");
                }

                if (response.articleLangData) {
                    response.articleLangData.map(function (articleLangData) {
                        if (
                            articleLangData.slug == "top_investor_banner_title"
                        ) {
                            $("#top_investor_banner_title").val(
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
 * Get top investor banner data
 */
$(document).on("change", "#banner_language_id", function () {
    var article_id = $("#banner_article_id").val();
    var language_id = $("#banner_language_id option:selected").val();

    $("#top_investor_banner_title").val("");

    if (article_id && language_id && article_id != 0 && language_id != 0) {
        var getData = $("#banner-form").attr("data-getData");
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
                            articleLangData.slug == "top_investor_banner_title"
                        ) {
                            $("#top_investor_banner_title").val(
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
 * Top investor top banner Form callback function
 */
var showTopBannerCallBackData = function () {
    // hide model
    $("#updateTopBanner").modal("hide");
};

/**
 * Update top investor top banner button model open
 */
$(document).on("click", "#update-top-banner-button", function () {
    // set form value
    $("#modelTopBannerLabel").html("Update Investor Top Banner");
    $("#topBannerFormActionBtn").html("Update");
    let action = $(this).attr("data-action");

    $("#top-banner-form").attr("action", $(this).attr("data-action"));

    if (!$("#top-banner-form").find('input[name="_method"]').length) {
        $("#top-banner-form").prepend(
            '<input type="hidden" name="_method" value="patch" />'
        );
    }

    let form = $("#top-banner-form");
    let formData = new FormData(document.querySelector("#top-banner-form"));

    // set form data by route
    setFormValue($(this).attr("data-route"), form, formData).then(
        (response) => {
            if (response) {
                $("#top_banner_article_id").val(response.article.id);

                if (response.article) {
                    $("#top_investor_top_banner").val(
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
                            articleLangData.slug ==
                            "top_investor_top_banner_title"
                        ) {
                            $("#top_investor_top_banner_title").val(
                                articleLangData.small_content
                            );
                        }
                    });
                }
            }
        }
    );

    // show model
    $("#updateTopBanner").modal("show");
});

/**
 * Get top investor top banner data
 */
$(document).on("change", "#top_banner_language_id", function () {
    var article_id = $("#top_banner_article_id").val();
    var language_id = $("#top_banner_language_id option:selected").val();

    $("#top_investor_top_banner_title").val("");

    if (article_id && language_id && article_id != 0 && language_id != 0) {
        var getData = $("#top-banner-form").attr("data-getData");
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
                            articleLangData.slug ==
                            "top_investor_top_banner_title"
                        ) {
                            $("#top_investor_top_banner_title").val(
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
 * Top investor header Form callback function
 */
var showHeaderCallBackData = function () {
    // hide model
    $("#updateHeader").modal("hide");
};

/**
 * Update top investor button model open
 */
$(document).on("click", "#update-header-button", function () {
    // set form value
    $("#modelHeaderLabel").html("Update Investor Header");
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
                    $("#top_investor_header").val(
                        response.article.article_name
                    );
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
                        if (
                            articleLangData.slug == "top_investor_header_title"
                        ) {
                            $("#top_investor_header_title").val(
                                articleLangData.small_content
                            );
                        } else if (
                            articleLangData.slug ==
                            "top_investor_header_content"
                        ) {
                            $("#top_investor_header_content").val(
                                articleLangData.small_content
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
 * Get top investor header data
 */
$(document).on("change", "#header_language_id", function () {
    var article_id = $("#header_article_id").val();
    var language_id = $("#header_language_id option:selected").val();

    $("#top_investor_header_title").val("");
    $("#top_investor_header_content").val("");

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
                        if (
                            articleLangData.slug == "top_investor_header_title"
                        ) {
                            $("#top_investor_header_title").val(
                                articleLangData.small_content
                            );
                        } else if (
                            articleLangData.slug ==
                            "top_investor_header_content"
                        ) {
                            $("#top_investor_header_content").val(
                                articleLangData.small_content
                            );
                        }
                    });
                }
            })
            .catch(function (response) {});
    }
});
