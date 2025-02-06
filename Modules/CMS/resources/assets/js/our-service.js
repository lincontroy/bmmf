"use strict";

/**
 * Our service header Form callback function
 */
var showCallBackData = function () {
    // hide model
    $("#addOurService").modal("hide");
    // reload table
    $(".dataTable").DataTable().ajax.reload();
};

/**
 * Add our service content model open
 */
$(document).on("click", "#add-our-service-button", function () {
    // set form value
    $("#image_required_div").html("*");
    $("#image").attr("required", true);
    $("#modelLabel").html("Create Our Service Content");
    $("#article_id").val("0");
    $("#formActionBtn").html("Create");
    $("#our-service-form").find('input[name="_method"]').remove();
    $("#our-service-form").attr(
        "action",
        $("#our-service-form").attr("data-insert")
    );

    removeFormValidation(
        $("#our-service-form"),
        new FormData(document.querySelector("#our-service-form")),
        true
    );
});

/**
 * Update our service content model open
 */
$(document).on("click", ".edit-our-service-button", function () {
    // set form value
    $("#image_required_div").html("");
    $("#image").attr("required", false);
    $("#modelLabel").html("Update Our Service Content");
    $("#formActionBtn").html("Update");
    $("#our-service-form").attr("action", $(this).attr("data-action"));
    if (!$("#our-service-form").find('input[name="_method"]').length) {
        $("#our-service-form").prepend(
            '<input type="hidden" name="_method" value="patch" />'
        );
    }

    let form = $("#our-service-form");
    let formData = new FormData(document.querySelector("#our-service-form"));

    // set form data by route
    setFormValue($(this).attr("data-route"), form, formData).then(
        (response) => {
            if (response) {
                $("#article_id").val(response.article.id);

                if (response.article) {
                    $("#our_service").val(response.article.article_name);
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
                        if (articleLangData.slug == "our_service_header") {
                            $("#our_service_content_header").val(
                                articleLangData.small_content
                            );
                        } else if (
                            articleLangData.slug == "our_service_content"
                        ) {
                            $("#our_service_content").val(
                                articleLangData.large_content
                            );
                        }
                    });
                }
            }
        }
    );

    // show model
    $("#addOurService").modal("show");
});

/**
 * Get article language data
 */
$(document).on("change", "#language_id", function () {
    var article_id = $("#article_id").val();
    var language_id = $("#language_id option:selected").val();

    $("#our_service_content_header").val("");
    $("#our_service_content").val("");

    if (article_id && language_id && article_id != 0 && language_id != 0) {
        var getData = $("#our-service-form").attr("data-getData");
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
                        if (articleLangData.slug == "our_service_header") {
                            $("#our_service_content_header").val(
                                articleLangData.small_content
                            );
                        } else if (
                            articleLangData.slug == "our_service_content"
                        ) {
                            $("#our_service_content").val(
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
 * Our service header Form callback function
 */
var showHeaderCallBackData = function () {
    // hide model
    $("#updateHeader").modal("hide");
};

/**
 * Update update our service button model open
 */
$(document).on("click", "#update-header-button", function () {
    // set form value
    $("#modelHeaderLabel").html("Update Our Service Header");
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
                    $("#our_service_header").val(response.article.article_name);
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
                        if (articleLangData.slug == "our_service_header_head") {
                            $("#our_service_header_head").val(
                                articleLangData.small_content
                            );
                        } else if (
                            articleLangData.slug == "our_service_header_content"
                        ) {
                            $("#our_service_header_content").val(
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
 * Get our service header data
 */
$(document).on("change", "#header_language_id", function () {
    var article_id = $("#header_article_id").val();
    var language_id = $("#header_language_id option:selected").val();

    $("#our_service_header_head").val("");
    $("#our_service_header_content").val("");

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
                        if (articleLangData.slug == "our_service_header_head") {
                            $("#our_service_header_head").val(
                                articleLangData.small_content
                            );
                        } else if (
                            articleLangData.slug == "our_service_header_content"
                        ) {
                            $("#our_service_header_content").val(
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
 * Our service header Form callback function
 */
var showTopBannerCallBackData = function () {
    // hide model
    $("#updateTopBanner").modal("hide");
};

/**
 * Update update our service button model open
 */
$(document).on("click", "#update-top-banner-button", function () {
    // set form value
    $("#top_banner_image_required_div").html("");
    $("#top_banner_image").attr("required", false);
    $("#modelTopBannerLabel").html("Update Service Top Banner");
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
                    $("#service_top_banner").val(response.article.article_name);
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
                        if (articleLangData.slug == "service_top_banner_title") {
                            $("#service_top_banner_title").val(
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
 * Get our service top_banner data
 */
$(document).on("change", "#top_banner_language_id", function () {
    var article_id = $("#top_banner_article_id").val();
    var language_id = $("#top_banner_language_id option:selected").val();

    $("#service_top_banner_title").val("");

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
                        if (articleLangData.slug == "service_top_banner_title") {
                            $("#service_top_banner_title").val(
                                articleLangData.small_content
                            );
                        }
                    });
                }
            })
            .catch(function (response) {});
    }
});
