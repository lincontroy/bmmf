"use strict";

/**
 * our difference header form callback function
 */
var showContentCallBackData = function () {
    // hide model
    $("#addOurDifferenceContent").modal("hide");
    // reload table
    $(".dataTable").DataTable().ajax.reload();
};

/**
 * Add our difference content model open
 */
$(document).on("click", "#add-our-difference-content-button", function () {
    // set form value
    $("#image_required_div").html("*");
    $("#image").attr("required", true);
    $("#modelContentLabel").html("Create Our Difference Content");
    $("#article_id").val("0");
    $("#ourDifferenceContentFormActionBtn").html("Create");
    $("#our-difference-content-form").find('input[name="_method"]').remove();
    $("#our-difference-content-form").attr(
        "action",
        $("#our-difference-content-form").attr("data-insert")
    );

    removeFormValidation(
        $("#our-difference-content-form"),
        new FormData(document.querySelector("#our-difference-content-form")),
        true
    );
});

/**
 * Update our difference content model open
 */
$(document).on("click", ".edit-our-difference-content-button", function () {
    // set form value
    $("#image_required_div").html("");
    $("#image").attr("required", false);
    $("#modelContentLabel").html("Update Our Difference Content");
    $("#ourDifferenceContentFormActionBtn").html("Update");
    $("#our-difference-content-form").attr(
        "action",
        $(this).attr("data-action")
    );
    if (
        !$("#our-difference-content-form").find('input[name="_method"]')
            .length
    ) {
        $("#our-difference-content-form").prepend(
            '<input type="hidden" name="_method" value="patch" />'
        );
    }

    let form = $("#our-difference-content-form");
    let formData = new FormData(
        document.querySelector("#our-difference-content-form")
    );

    // set form data by route
    setFormValue($(this).attr("data-route"), form, formData).then(
        (response) => {
            if (response) {
                $("#article_id").val(response.article.id);

                if (response.article) {
                    $("#our_difference_content").val(
                        response.article.article_name
                    );
                    $("#status").val(response.article.status).trigger("change");
                }

                if (response.articleData) {
                    response.articleData.map(function (articleData) {
                        if (articleData.slug == "image") {
                        }
                    });
                }

                if (response.articleLangData) {
                    response.articleLangData.map(function (articleLangData) {
                        if (
                            articleLangData.slug ==
                            "our_difference_content_header"
                        ) {
                            $("#our_difference_content_header").val(
                                articleLangData.small_content
                            );
                        } else if (
                            articleLangData.slug ==
                            "our_difference_content_body"
                        ) {
                            $("#our_difference_content_body").val(
                                articleLangData.large_content
                            );
                        }
                    });
                }
            }
        }
    );

    // show model
    $("#addOurDifferenceContent").modal("show");
});

/**
 * Get our difference header data
 */
$(document).on("change", "#language_id", function () {
    var article_id = $("#article_id").val();
    var language_id = $("#language_id option:selected").val();

    $("#our_difference_content_header").val("");
    $("#our_difference_content_body").val("");

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
                            "our_difference_content_header"
                        ) {
                            $("#our_difference_content_header").val(
                                articleLangData.small_content
                            );
                        } else if (
                            articleLangData.slug ==
                            "our_difference_content_body"
                        ) {
                            $("#our_difference_content_body").val(
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
 * our difference header form callback function
 */
var showHeaderCallBackData = function () {
    // hide model
    $("#updateHeader").modal("hide");
};

/**
 * Update our difference header button model open
 */
$(document).on("click", "#update-header-button", function () {
    // set form value
    $("#modelHeaderLabel").html("Update Our Difference Header");
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
                    $("#our_difference_header").val(
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
                            "our_difference_header_title"
                        ) {
                            $("#our_difference_header_title").val(
                                articleLangData.small_content
                            );
                        } else if (
                            articleLangData.slug ==
                            "our_difference_header_content"
                        ) {
                            $("#our_difference_header_content").val(
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
 * Get our difference header data
 */
$(document).on("change", "#header_language_id", function () {
    var article_id = $("#header_article_id").val();
    var language_id = $("#header_language_id option:selected").val();

    $("#our_difference_header_title").val("");
    $("#our_difference_header_content").val("");

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
                            "our_difference_header_title"
                        ) {
                            $("#our_difference_header_title").val(
                                articleLangData.small_content
                            );
                        } else if (
                            articleLangData.slug ==
                            "our_difference_header_content"
                        ) {
                            $("#our_difference_header_content").val(
                                articleLangData.large_content
                            );
                        }
                    });
                }
            })
            .catch(function (response) {});
    }
});
