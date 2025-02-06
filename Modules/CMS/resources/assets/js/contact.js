"use strict";

/**
 * Top banner form callback function
 */
var showTopBannerCallBackData = function () {
    // hide model
    $("#updateContactTopBanner").modal("hide");
    // reload table
    $(".dataTable").DataTable().ajax.reload();
};

/**
 * Update contact top banner model open
 */
$(document).on("click", "#update-contact-top-banner-button", function () {
    // set form value
    $("#modelLabel").html("Update Contact Top Banner Content");
    $("#topBannerFormActionBtn").html("Update");
    let action = $(this).attr("data-action");

    $("#contact-top-banner-form").attr("action", $(this).attr("data-action"));

    if (!$("#contact-top-banner-form").find('input[name="_method"]').length) {
        $("#contact-top-banner-form").prepend(
            '<input type="hidden" name="_method" value="patch" />'
        );
    }

    let form = $("#contact-top-banner-form");
    let formData = new FormData(
        document.querySelector("#contact-top-banner-form")
    );

    // set form data by route
    setFormValue($(this).attr("data-route"), form, formData).then(
        (response) => {
            if (response) {
                $("#top_banner_article_id").val(response.article.id);

                if (response.article) {
                    $("#contact_us_top_banner").val(
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
                            "contact_us_top_banner_title"
                        ) {
                            $("#contact_us_top_banner_title").val(
                                articleLangData.small_content
                            );
                        }
                    });
                }
            }
        }
    );

    // show model
    $("#updateContactTopBanner").modal("show");
});

/**
 * Get contact top banner article data
 */
$(document).on("change", "#top_banner_language_id", function () {
    var article_id = $("#top_banner_article_id").val();
    var language_id = $("#top_banner_language_id option:selected").val();

    $("#contact_us_top_banner_title").val("");

    if (article_id && language_id && article_id != 0 && language_id != 0) {
        var getData = $("#contact-top-banner-form").attr("data-getData");
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
                            "contact_us_top_banner_title"
                        ) {
                            $("#contact_us_top_banner_title").val(
                                articleLangData.small_content
                            );
                        }
                    });
                }
            })
            .catch(function (response) {});
    }
});
