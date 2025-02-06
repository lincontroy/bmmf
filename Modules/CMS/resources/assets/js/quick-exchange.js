"use strict";

/**
 * Investment form callback function
 */
var showCallBackData = function () {
    // hide model
    $("#updateQuickExchange").modal("hide");
    // reload table
    $(".dataTable").DataTable().ajax.reload();
};

/**
 * Update investment model open
 */
$(document).on("click", ".edit-quick-exchange-button", function () {
    // set form value
    $("#image_required_div").html("");
    $("#image").attr("required", false);
    $("#modelLabel").html("Update QuickExchange");
    $("#quickexchange-form").attr("action", $(this).attr("data-action"));
    if (!$("#quickexchange-form").find('input[name="_method"]').length) {
        $("#quickexchange-form").prepend(
            '<input type="hidden" name="_method" value="patch" />'
        );
    }

    let form = $("#quickexchange-form");
    let formData = new FormData(document.querySelector("#quickexchange-form"));

    // set form data by route
    setFormValue($(this).attr("data-route"), form, formData).then(
        (response) => {
            if (response) {
                $("#article_id").val(response.article.id);

                if (response.article) {
                    $("#quick_exchange_name").val(
                        response.article.article_name
                    );
                    $("#status").val(response.article.status).trigger("change");
                }

                if (response.defaultLanguage) {
                    $("#language_id")
                        .val(response.defaultLanguage.id)
                        .trigger("change");
                }

                if (response.articleLangData) {
                    response.articleLangData.map(function (articleLangData) {
                        if (
                            articleLangData.slug ==
                            "quick_exchange_banner_title"
                        ) {
                            $("#quick_exchange_banner_title").val(
                                articleLangData.small_content
                            );
                        } else if (
                            articleLangData.slug == "quick_exchange_header"
                        ) {
                            $("#quick_exchange_header").val(
                                articleLangData.small_content
                            );
                        } else if (
                            articleLangData.slug == "quick_exchange_content"
                        ) {
                            $("#quick_exchange_content").val(
                                articleLangData.small_content
                            );
                        } else if (
                            articleLangData.slug == "transaction_header"
                        ) {
                            $("#transaction_header").val(
                                articleLangData.small_content
                            );
                        }
                    });
                }
            }
        }
    );

    // show model
    $("#updateQuickExchange").modal("show");
});

/**
 * Get article language data
 */
$(document).on("change", "#language_id", function () {
    var article_id = $("#article_id").val();
    var language_id = $("#language_id option:selected").val();

    $("#quick_exchange_banner_title").val("");
    $("#quick_exchange_header").val("");
    $("#quick_exchange_content").val("");
    $("#transaction_header").val("");

    if (article_id && language_id && article_id != 0 && language_id != 0) {
        $("#menu_name").val("");
        var getData = $("#quickexchange-form").attr("data-getData");
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
                            "quick_exchange_banner_title"
                        ) {
                            $("#quick_exchange_banner_title").val(
                                articleLangData.small_content
                            );
                        } else if (
                            articleLangData.slug == "quick_exchange_header"
                        ) {
                            $("#quick_exchange_header").val(
                                articleLangData.small_content
                            );
                        } else if (
                            articleLangData.slug == "quick_exchange_content"
                        ) {
                            $("#quick_exchange_content").val(
                                articleLangData.small_content
                            );
                        } else if (
                            articleLangData.slug == "transaction_header"
                        ) {
                            $("#transaction_header").val(
                                articleLangData.small_content
                            );
                        }
                    });
                }
            })
            .catch(function (response) {});
    }
});
