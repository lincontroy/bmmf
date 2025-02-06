"use strict";

/**
 * Home about form callback function
 */
var showCallBackData = function () {
    // hide model
    $("#addJoinUsToday").modal("hide");
    // reload table
    $(".dataTable").DataTable().ajax.reload();
};

/**
 * Get article language data
 */
$(document).on("change", "#language_id", function () {
    var article_id = $("#article_id").val();
    var language_id = $("#language_id option:selected").val();

    $("#join_us_today_title").val("");
    $("#join_us_today_content").val("");

    if (article_id && language_id && article_id != 0 && language_id != 0) {
        var getData = $("#join-us-today-form").attr("data-getData");
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
                        if (articleLangData.slug == "join_us_today_title") {
                            $("#join_us_today_title").val(
                                articleLangData.small_content
                            );
                        } else if (
                            articleLangData.slug == "join_us_today_content"
                        ) {
                            $("#join_us_today_content").val(
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
$(document).on("click", ".edit-join-us-today-button", function () {
    // set form value
    $("#modelLabel").html("Update Package Banner");
    $("#joinUsBannerFrmActionBtn").html("Update");
    $("#join-us-today-form").attr("action", $(this).attr("data-action"));
    if (!$("#join-us-today-form").find('input[name="_method"]').length) {
        $("#join-us-today-form").prepend(
            '<input type="hidden" name="_method" value="patch" />'
        );
    }

    let form = $("#join-us-today-form");
    let formData = new FormData(document.querySelector("#join-us-today-form"));

    // set form data by route
    setFormValue($(this).attr("data-route"), form, formData).then(
        (response) => {
            if (response) {
                $("#article_id").val(response.article.id);

                if (response.article) {
                    $("#join_us_today").val(response.article.article_name);
                    $("#status").val(response.article.status).trigger("change");
                }

                if (response.defaultLanguage) {
                    $("#language_id")
                        .val(response.defaultLanguage.id)
                        .trigger("change");
                }
                if (response.articleLangData) {
                    response.articleLangData.map(function (articleLangData) {
                        if (articleLangData.slug == "join_us_today_title") {
                            $("#join_us_today_title").val(
                                articleLangData.small_content
                            );
                        } else if (
                            articleLangData.slug == "join_us_today_content"
                        ) {
                            $("#join_us_today_content").val(
                                articleLangData.small_content
                            );
                        }
                    });
                }
            }
        }
    );

    // show model
    $("#addJoinUsToday").modal("show");
});
