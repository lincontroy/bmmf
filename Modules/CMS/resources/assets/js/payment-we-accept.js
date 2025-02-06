"use strict";

/**
 * Payment we accept header Form callback function
 */
var showTopBannerCallBackData = function () {
    // hide model
    $("#updateHeader").modal("hide");
    // reload table
    $(".dataTable").DataTable().ajax.reload();
};

/**
 * Update payment we accept header model open
 */
$(document).on("click", "#update-header-button", function () {
    // set form value
    $("#modelLabel").html("Update header");
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
                    $("#payment_we_accept_header").val(
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
                            articleLangData.slug ==
                            "payment_we_accept_header_title"
                        ) {
                            $("#payment_we_accept_header_title").val(
                                articleLangData.small_content
                            );
                        } else if (
                            articleLangData.slug ==
                            "payment_we_accept_header_content"
                        ) {
                            $("#payment_we_accept_header_content").val(
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
 * Get article data
 */
$(document).on("change", "#header_language_id", function () {
    var article_id = $("#header_article_id").val();
    var language_id = $("#header_language_id option:selected").val();

    $("#payment_we_accept_header_title").val("");
    $("#payment_we_accept_header_content").val("");

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
                            articleLangData.slug ==
                            "payment_we_accept_header_title"
                        ) {
                            $("#payment_we_accept_header_title").val(
                                articleLangData.small_content
                            );
                        } else if (
                            articleLangData.slug ==
                            "payment_we_accept_header_content"
                        ) {
                            $("#payment_we_accept_header_content").val(
                                articleLangData.large_content
                            );
                        }
                    });
                }
            })
            .catch(function (response) {});
    }
});
