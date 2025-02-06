"use strict";

/**
 * Home slider Form callback function
 */
var showCallBackData = function () {
    // hide model
    $("#addHomeSlider").modal("hide");
    // reload table
    $(".dataTable").DataTable().ajax.reload();
};

/**
 * Add home slider model open
 */
$(document).on("click", "#add-home-slider-button", function () {
    // set form value
    $("#image_required_div").html("*");
    $("#image").attr("required", true);
    $("#modelLabel").html("Create Home Slider");
    $("#article_id").val("0");
    $("#homeSliderFormActionBtn").html("Create");
    $("#home-slider-form").find('input[name="_method"]').remove();
    $("#home-slider-form").attr(
        "action",
        $("#home-slider-form").attr("data-insert")
    );

    removeFormValidation(
        $("#home-slider-form"),
        new FormData(document.querySelector("#home-slider-form")),
        true
    );
});

/**
 * Update home slider model open
 */
$(document).on("click", ".edit-home-slider-button", function () {
    // set form value
    $("#image_required_div").html("");
    $("#image").attr("required", false);
    $("#modelLabel").html("Update Home Slider");
    $("#homeSliderFormActionBtn").html("Update");
    $("#home-slider-form").attr("action", $(this).attr("data-action"));
    if (!$("#home-slider-form").find('input[name="_method"]').length) {
        $("#home-slider-form").prepend(
            '<input type="hidden" name="_method" value="patch" />'
        );
    }

    let form = $("#home-slider-form");
    let formData = new FormData(document.querySelector("#home-slider-form"));

    // set form data by route
    setFormValue($(this).attr("data-route"), form, formData).then(
        (response) => {
            if (response) {
                $("#article_id").val(response.article.id);

                if (response.article) {
                    $("#slider_name").val(response.article.article_name);
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
                        if (articleLangData.slug == "home_slider_title") {
                            $("#slider_title").val(
                                articleLangData.small_content
                            );
                        } else if (
                            articleLangData.slug == "home_slider_header"
                        ) {
                            $("#slider_header").val(
                                articleLangData.small_content
                            );
                        } else if (articleLangData.slug == "home_slider_para") {
                            $("#slider_paragraph").val(
                                articleLangData.large_content
                            );
                        } else if (
                            articleLangData.slug == "home_slider_button_text"
                        ) {
                            $("#slider_button_text").val(
                                articleLangData.small_content
                            );
                        }
                    });
                }
            }
        }
    );

    // show model
    $("#addHomeSlider").modal("show");
});

/**
 * Get article language data
 */
$(document).on("change", "#language_id", function () {
    var article_id = $("#article_id").val();
    var language_id = $("#language_id option:selected").val();

    $("#slider_title").val("");
    $("#slider_header").val("");
    $("#slider_paragraph").val("");
    $("#slider_button_text").val("");

    if (article_id && language_id && article_id != 0 && language_id != 0) {
        $("#menu_name").val("");
        var getData = $("#home-slider-form").attr("data-getData");
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
                        if (articleLangData.slug == "home_slider_title") {
                            $("#slider_title").val(
                                articleLangData.small_content
                            );
                        } else if (
                            articleLangData.slug == "home_slider_header"
                        ) {
                            $("#slider_header").val(
                                articleLangData.small_content
                            );
                        } else if (articleLangData.slug == "home_slider_para") {
                            $("#slider_paragraph").val(
                                articleLangData.large_content
                            );
                        } else if (
                            articleLangData.slug == "home_slider_button_text"
                        ) {
                            $("#slider_button_text").val(
                                articleLangData.small_content
                            );
                        }
                    });
                }
            })
            .catch(function (response) {});
    }
});
