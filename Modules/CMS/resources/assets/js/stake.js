"use strict";

/**
 * Stake Banner Form callback function
 */
var showBannerCallBackData = function () {
    // hide model
    $("#updateBanner").modal("hide");
    // reload table
    $(".dataTable").DataTable().ajax.reload();
};

/**
 * Update stake banner model open
 */
$(document).on("click", "#update-banner-button", function () {
    // set form value
    $("#modelLabel").html("Update Stake Banner");
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
                    $("#stake_banner").val(
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
                            articleLangData.slug ==
                            "stake_banner_title"
                        ) {
                            $("#stake_banner_title").val(
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
 * Get article data
 */
$(document).on("change", "#banner_language_id", function () {
    var article_id = $("#banner_article_id").val();
    var language_id = $("#banner_language_id option:selected").val();

    $("#stake_banner_title").val("");

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
                            articleLangData.slug ==
                            "stake_banner_title"
                        ) {
                            $("#stake_banner_title").val(
                                articleLangData.small_content
                            );
                        }
                    });
                }
            })
            .catch(function (response) {});
    }
});
