"use strict";

/**
 * Blog top banner form callback function
 */
var showTopBannerCallBackData = function () {
    // hide model
    $("#updateBlogTopBanner").modal("hide");
    // reload table
    $(".dataTable").DataTable().ajax.reload();
};

/**
 * Blog details top banner form callback function
 */
var showDetailsTopBannerCallBackData = function () {
    // hide model
    $("#updateBlogDetailsTopBanner").modal("hide");
    // reload table
    $(".dataTable").DataTable().ajax.reload();
};

/**
 * Blog content form callback function
 */
var showCallBackData = function () {
    // hide model
    $("#addBlogContent").modal("hide");
    // reload table
    $(".dataTable").DataTable().ajax.reload();
};

/**
 * Update blog top banner model open
 */
$(document).on("click", "#update-blog-top-banner-button", function () {
    // set form value
    $("#modelTopBannerLabel").html("Update Blog Top Banner Content");
    $("#topBannerFormActionBtn").html("Update");
    let action = $(this).attr("data-action");

    $("#blog-top-banner-form").attr("action", $(this).attr("data-action"));

    if (!$("#blog-top-banner-form").find('input[name="_method"]').length) {
        $("#blog-top-banner-form").prepend(
            '<input type="hidden" name="_method" value="patch" />'
        );
    }

    let form = $("#blog-top-banner-form");
    let formData = new FormData(
        document.querySelector("#blog-top-banner-form")
    );

    // set form data by route
    setFormValue($(this).attr("data-route"), form, formData).then(
        (response) => {
            if (response) {
                $("#top_banner_article_id").val(response.article.id);

                if (response.article) {
                    $("#blog_top_banner").val(response.article.article_name);
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
                        if (articleLangData.slug == "blog_top_banner_title") {
                            $("#blog_top_banner_title").val(
                                articleLangData.small_content
                            );
                        }
                    });
                }
            }
        }
    );

    // show model
    $("#updateBlogTopBanner").modal("show");
});

/**
 * Get blog header article data
 */
$(document).on("change", "#top_banner_language_id", function () {
    var article_id = $("#top_banner_article_id").val();
    var language_id = $("#top_banner_language_id option:selected").val();

    $("#blog_top_banner_title").val("");

    if (article_id && language_id && article_id != 0 && language_id != 0) {
        var getData = $("#blog-top-banner-form").attr("data-getData");
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
                        if (articleLangData.slug == "blog_top_banner_title") {
                            $("#blog_top_banner_title").val(
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
 * Update blog details top banner model open
 */
$(document).on("click", "#update-blog-details-top-banner-button", function () {
    // set form value
    $("#modelDetailTopBannerLabel").html("Update Blog Top Banner Content");
    $("#detailTopBannerFormActionBtn").html("Update");
    let action = $(this).attr("data-action");

    $("#blog-details-top-banner-form").attr(
        "action",
        $(this).attr("data-action")
    );

    if (
        !$("#blog-details-top-banner-form").find('input[name="_method"]').length
    ) {
        $("#blog-details-top-banner-form").prepend(
            '<input type="hidden" name="_method" value="patch" />'
        );
    }

    let form = $("#blog-details-top-banner-form");
    let formData = new FormData(
        document.querySelector("#blog-details-top-banner-form")
    );

    // set form data by route
    setFormValue($(this).attr("data-route"), form, formData).then(
        (response) => {
            if (response) {
                $("#details_top_banner_article_id").val(response.article.id);

                if (response.article) {
                    $("#blog_details_top_banner").val(
                        response.article.article_name
                    );
                    $("#details_top_banner_status")
                        .val(response.article.status)
                        .trigger("change");
                }

                if (response.defaultLanguage) {
                    $("#details_top_banner_language_id")
                        .val(response.defaultLanguage.id)
                        .trigger("change");
                }

                if (response.articleLangData) {
                    response.articleLangData.map(function (articleLangData) {
                        if (
                            articleLangData.slug ==
                            "blog_details_top_banner_title"
                        ) {
                            $("#blog_details_top_banner_title").val(
                                articleLangData.small_content
                            );
                        }
                    });
                }
            }
        }
    );

    // show model
    $("#updateBlogDetailsTopBanner").modal("show");
});

/**
 * Get details top banner article data
 */
$(document).on("change", "#details_top_banner_language_id", function () {
    var article_id = $("#details_top_banner_article_id").val();
    var language_id = $(
        "#details_top_banner_language_id option:selected"
    ).val();

    $("#blog_details_top_banner_title").val("");

    if (article_id && language_id && article_id != 0 && language_id != 0) {
        var getData = $("#blog-details-top-banner-form").attr("data-getData");
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
                            "blog_details_top_banner_title"
                        ) {
                            $("#blog_details_top_banner_title").val(
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
 * Add blog content model open
 */
$(document).on("click", "#add-blog-content-button", function () {
    // set form value
    $("#image_required_div").html("*");
    $("#image").attr("required", true);
    $("#modelLabel").html("Create Blog Content");
    $("#article_id").val("0");
    $("#blogFormActionBtn").html("Create");
    $("#blog-content-form").find('input[name="_method"]').remove();
    $("#blog-content-form").attr(
        "action",
        $("#blog-content-form").attr("data-insert")
    );

    removeFormValidation(
        $("#blog-content-form"),
        new FormData(document.querySelector("#blog-content-form")),
        true
    );
});

/**
 * Update blog content model open
 */
$(document).on("click", ".edit-blog-content-button", function () {
    // set form value
    $("#image_required_div").html("");
    $("#image").attr("required", false);
    $("#modelLabel").html("Update Blog Content");
    $("#blogFormActionBtn").html("Update");
    $("#blog-content-form").attr("action", $(this).attr("data-action"));
    if (!$("#blog-content-form").find('input[name="_method"]').length) {
        $("#blog-content-form").prepend(
            '<input type="hidden" name="_method" value="patch" />'
        );
    }

    let form = $("#blog-content-form");
    let formData = new FormData(document.querySelector("#blog-content-form"));

    // set form data by route
    setFormValue($(this).attr("data-route"), form, formData).then(
        (response) => {
            if (response) {
                $("#article_id").val(response.article.id);

                if (response.article) {
                    $("#blog_content_name").val(response.article.article_name);
                    $("#status").val(response.article.status).trigger("change");
                }

                if (response.defaultLanguage) {
                    $("#language_id")
                        .val(response.defaultLanguage.id)
                        .trigger("change");
                }

                if (response.articleLangData) {
                    response.articleLangData.map(function (articleLangData) {
                        if (articleLangData.slug == "blog_title") {
                            $("#blog_title").val(
                                articleLangData.small_content
                            );
                        } else if (articleLangData.slug == "blog_content") {
                            $("#blog_content").val(
                                articleLangData.large_content
                            );
                        }
                    });
                }
            }
        }
    );

    // show model
    $("#addBlogContent").modal("show");
});

/**
 * Get article language data
 */
$(document).on("change", "#language_id", function () {
    var article_id = $("#article_id").val();
    var language_id = $("#language_id option:selected").val();

    $("#blog_title").val("");
    $("#blog_content").val("");

    if (article_id && language_id && article_id != 0 && language_id != 0) {
        var getData = $("#blog-content-form").attr("data-getData");
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
                        if (articleLangData.slug == "blog_title") {
                            $("#blog_title").val(
                                articleLangData.small_content
                            );
                        } else if (articleLangData.slug == "blog_content") {
                            $("#blog_content").val(
                                articleLangData.large_content
                            );
                        }
                    });
                }
            })
            .catch(function (response) {});
    }
});
