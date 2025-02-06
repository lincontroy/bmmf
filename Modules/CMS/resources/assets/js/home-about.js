"use strict";

/**
 * Home about form callback function
 */
var showCallBackData = function () {
    // hide model
    $("#addHomeAbout").modal("hide");
    // reload table
    $(".dataTable").DataTable().ajax.reload();
};

/**
 * Add home about model open
 */
$(document).on("click", "#add-home-about-button", function () {
    // set form value
    $("#image_required_div").html("*");
    $("#image").attr("required", true);
    $("#modelLabel").html("Create Home About");
    $("#article_id").val("0");
    $("#homeAboutFormActionBtn").html("Create");
    $("#home-about-form").find('input[name="_method"]').remove();
    $("#home-about-form").attr(
        "action",
        $("#home-about-form").attr("data-insert")
    );

    removeFormValidation(
        $("#home-about-form"),
        new FormData(document.querySelector("#home-about-form")),
        true
    );
});

/**
 * Get article language data
 */
$(document).on("change", "#language_id", function () {
    var article_id = $("#article_id").val();
    var language_id = $("#language_id option:selected").val();

    $("#about_title").val("");
    $("#about_header").val("");
    $("#about_content").val("");
    $("#about_button_text").val("");

    if (article_id && language_id && article_id != 0 && language_id != 0) {
        var getData = $("#home-about-banner-form").attr("data-getData");
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
                        if (articleLangData.slug == "about_title") {
                            $("#about_title").val(
                                articleLangData.large_content
                            );
                        } else if (articleLangData.slug == "about_header") {
                            $("#about_header").val(
                                articleLangData.small_content
                            );
                        } else if (articleLangData.slug == "about_content") {
                            $("#about_content").val(
                                articleLangData.large_content
                            );
                        } else if (
                            articleLangData.slug == "about_button_text"
                        ) {
                            $("#about_button_text").val(
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
 * Update home about model open
 */
$(document).on("click", ".edit-home-about-button", function () {
    // set form value
    $("#image_required_div").html("");
    $("#image").attr("required", false);
    $("#modelLabel").html("Update Home About");
    $("#homeAboutFormActionBtn").html("Update");
    $("#home-about-form").attr("action", $(this).attr("data-action"));
    if (!$("#home-about-form").find('input[name="_method"]').length) {
        $("#home-about-form").prepend(
            '<input type="hidden" name="_method" value="patch" />'
        );
    }

    let form = $("#home-about-form");
    let formData = new FormData(document.querySelector("#home-about-form"));

    // set form data by route
    setFormValue($(this).attr("data-route"), form, formData).then(
        (response) => {
            if (response) {
                $("#article_id").val(response.article.id);

                if (response.article) {
                    $("#about_name").val(response.article.article_name);
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
                        if (articleLangData.slug == "about_title") {
                            $("#about_title").val(
                                articleLangData.large_content
                            );
                        } else if (articleLangData.slug == "about_header") {
                            $("#about_header").val(
                                articleLangData.small_content
                            );
                        } else if (articleLangData.slug == "about_content") {
                            $("#about_content").val(
                                articleLangData.large_content
                            );
                        } else if (
                            articleLangData.slug == "about_button_text"
                        ) {
                            $("#about_button_text").val(
                                articleLangData.small_content
                            );
                        }
                    });
                }
            }
        }
    );

    // show model
    $("#addHomeAbout").modal("show");
});


/**
 * Home about form callback function
 */
var showCallBackBannerData = function () {
    // hide model
    $("#addAboutBanner").modal("hide");
    // reload table
    $(".dataTable").DataTable().ajax.reload();
};

/**
 * Get article language data
 */
$(document).on("change", "#banner_language_id", function () {
    var article_id = $("#banner_article_id").val();
    var language_id = $("#banner_language_id option:selected").val();

    $("#about_us_banner_title").val("");

    if (article_id && language_id && article_id != 0 && language_id != 0) {
        var getData = $("#home-about-banner-form").attr("data-getData");
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
                        if (articleLangData.slug == "about_us_banner_title") {
                            $("#about_us_banner_title").val(
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
 * Update home about model open
 */
$(document).on("click", ".edit-about-us-banner-button", function () {
    // set form value
    $("#banner_image_required_div").html("");
    $("#banner_image").attr("required", false);
    $("#modelBannerLabel").html("Update About Us Banner");
    $("#homeAboutBannerFormActionBtn").html("Update");
    $("#home-about-banner-form").attr("action", $(this).attr("data-action"));
    if (!$("#home-about-banner-form").find('input[name="_method"]').length) {
        $("#home-about-banner-form").prepend(
            '<input type="hidden" name="_method" value="patch" />'
        );
    }

    let form = $("#home-about-banner-form");
    let formData = new FormData(document.querySelector("#home-about-banner-form"));

    // set form data by route
    setFormValue($(this).attr("data-route"), form, formData).then(
        (response) => {
            if (response) {
                $("#banner_article_id").val(response.article.id);

                if (response.article) {
                    $("#about_us_banner").val(response.article.article_name);
                    $("#banner_status").val(response.article.status).trigger("change");
                }


                if (response.defaultLanguage) {
                    $("#banner_language_id")
                        .val(response.defaultLanguage.id)
                        .trigger("change");
                }

                if (response.articleLangData) {
                    response.articleLangData.map(function (articleLangData) {
                        if (articleLangData.slug == "about_us_banner_title") {
                            $("#about_us_banner_title").val(
                                articleLangData.small_content
                            );
                        }
                    });
                }
            }
        }
    );

    // show model
    $("#addAboutBanner").modal("show");
});
