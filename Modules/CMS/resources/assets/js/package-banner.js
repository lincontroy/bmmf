"use strict";

/**
 * Home about form callback function
 */
var showCallBackData = function () {
    // hide model
    $("#addPackageBanner").modal("hide");
    // reload table
    $(".dataTable").DataTable().ajax.reload();
};

/**
 * Get article language data
 */
$(document).on("change", "#language_id", function () {
    var article_id = $("#article_id").val();
    var language_id = $("#language_id option:selected").val();

    $("#package_banner_title").val("");

    if (article_id && language_id && article_id != 0 && language_id != 0) {
        var getData = $("#package-banner-form").attr("data-getData");
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
                        if (articleLangData.slug == "package_banner_title") {
                            $("#package_banner_title").val(
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
$(document).on("click", ".edit-package-banner-button", function () {
    // set form value
    $("#image_required_div").html("");
    $("#image").attr("required", false);
    $("#modelBannerLabel").html("Update Package Banner");
    $("#packageBannerFrmActionBtn").html("Update");
    $("#package-banner-form").attr("action", $(this).attr("data-action"));
    if (!$("#package-banner-form").find('input[name="_method"]').length) {
        $("#package-banner-form").prepend(
            '<input type="hidden" name="_method" value="patch" />'
        );
    }

    let form = $("#package-banner-form");
    let formData = new FormData(document.querySelector("#package-banner-form"));

    // set form data by route
    setFormValue($(this).attr("data-route"), form, formData).then(
        (response) => {
            if (response) {
                $("#article_id").val(response.article.id);

                if (response.article) {
                    $("#package_banner").val(response.article.article_name);
                    $("#status").val(response.article.status).trigger("change");
                }

                if (response.defaultLanguage) {
                    $("#language_id")
                        .val(response.defaultLanguage.id)
                        .trigger("change");
                }
                if (response.articleLangData) {
                    response.articleLangData.map(function (articleLangData) {
                        if (articleLangData.slug == "package_banner_title") {
                            $("#package_banner_title").val(
                                articleLangData.small_content
                            );
                        }
                    });
                }
            }
        }
    );

    // show model
    $("#addPackageBanner").modal("show");
});


/**
 * Home about form callback function
 */
var showCallBackHeaderData = function () {
    // hide model
    $("#addPackageHeader").modal("hide");
    // reload table
    $(".dataTable").DataTable().ajax.reload();
};

/**
 * Get article language data
 */
$(document).on("change", "#header_language_id", function () {
    var article_id = $("#header_article_id").val();
    var language_id = $("#header_language_id option:selected").val();

    $("#package_header_title").val("");
    $("#package_header_content").val("");

    if (article_id && language_id && article_id != 0 && language_id != 0) {
        var getData = $("#package-banner-form").attr("data-getData");
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
                        if (articleLangData.slug == "package_header_title") {
                            $("#package_header_title").val(
                                articleLangData.small_content
                            );
                        }
                        else if (articleLangData.slug == "package_header_content") {
                            $("#package_header_content").val(
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
$(document).on("click", ".edit-package-header-button", function () {
    // set form value
    $("#modelHeaderLabel").html("Update Package Header");
    $("#packageHeaderFrmActionBtn").html("Update");
    $("#package-header-form").attr("action", $(this).attr("data-action"));
    if (!$("#package-header-form").find('input[name="_method"]').length) {
        $("#package-header-form").prepend(
            '<input type="hidden" name="_method" value="patch" />'
        );
    }

    let form = $("#package-header-form");
    let formData = new FormData(document.querySelector("#package-header-form"));

    // set form data by route
    setFormValue($(this).attr("data-route"), form, formData).then(
        (response) => {
            if (response) {
                $("#article_id").val(response.article.id);

                if (response.article) {
                    $("#package_header").val(response.article.article_name);
                    $("#status").val(response.article.status).trigger("change");
                }

                if (response.defaultLanguage) {
                    $("#language_id")
                        .val(response.defaultLanguage.id)
                        .trigger("change");
                }
                if (response.articleLangData) {
                    response.articleLangData.map(function (articleLangData) {
                        if (articleLangData.slug == "package_header_title") {
                            $("#package_header_title").val(
                                articleLangData.small_content
                            );
                        }
                        else if (articleLangData.slug == "package_header_content") {
                            $("#package_header_content").val(
                                articleLangData.small_content
                            );
                        }
                    });
                }
            }
        }
    );

    // show model
    $("#addPackageHeader").modal("show");
});
