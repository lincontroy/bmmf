"use strict";

/**
 * Team member banner form callback function
 */
var showBannerCallBackData = function () {
    // hide model
    $("#updateBanner").modal("hide");
};

/**
 * Update team member banner button model open
 */
$(document).on("click", "#update-banner-button", function () {
    // set form value
    $("#modelBannerLabel").html("Update Team Member Banner");
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
                    $("#team_member_banner").val(response.article.article_name);
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
                            articleLangData.slug == "team_member_banner_title"
                        ) {
                            $("#team_member_banner_title").val(
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
 * Get team member data
 */
$(document).on("change", "#banner_language_id", function () {
    var article_id = $("#banner_article_id").val();
    var language_id = $("#banner_language_id option:selected").val();

    $("#team_member_banner_title").val("");

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
                            articleLangData.slug == "team_member_banner_title"
                        ) {
                            $("#team_member_banner_title").val(
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
 * Team member header form callback function
 */
var showHeaderCallBackData = function () {
    // hide model
    $("#updateHeader").modal("hide");
};

/**
 * Update team member header button model open
 */
$(document).on("click", "#update-header-button", function () {
    // set form value
    $("#modelHeaderLabel").html("Update Team Member Header");
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
                    $("#team_header").val(response.article.article_name);
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
                        if (articleLangData.slug == "team_header_title") {
                            $("#team_header_title").val(
                                articleLangData.small_content
                            );
                        } else if (
                            articleLangData.slug == "team_header_content"
                        ) {
                            $("#team_header_content").val(
                                articleLangData.small_content
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
 * Get our service header data
 */
$(document).on("change", "#header_language_id", function () {
    var article_id = $("#header_article_id").val();
    var language_id = $("#header_language_id option:selected").val();

    $("#team_header_title").val("");
    $("#team_header_content").val("");

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
                        if (articleLangData.slug == "team_header_title") {
                            $("#team_header_title").val(
                                articleLangData.small_content
                            );
                        } else if (
                            articleLangData.slug == "team_header_content"
                        ) {
                            $("#team_header_content").val(
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
 * Nishue difference header form callback function
 */
var showContentCallBackData = function () {
    // hide model
    $("#addTeamMemberContent").modal("hide");
    // reload table
    $(".dataTable").DataTable().ajax.reload();
};

/**
 * Add nishue difference content model open
 */
$(document).on("click", "#add-team-member-content-button", function () {
    // set form value
    $("#image_required_div").html("*");
    $("#avatar").attr("required", true);
    $("#modelContentLabel").html("Create Team Member Content");
    $("#article_id").val("0");
    $("#teamMemberContentFormActionBtn").html("Create");
    $("#team-member-content-form").find('input[name="_method"]').remove();
    $("#team-member-content-form").attr(
        "action",
        $("#team-member-content-form").attr("data-insert")
    );

    removeFormValidation(
        $("#team-member-content-form"),
        new FormData(document.querySelector("#team-member-content-form")),
        true
    );
});

/**
 * Update nishue difference content model open
 */
$(document).on("click", ".edit-team-member-content-button", function () {
    // set form value
    $("#image_required_div").html("");
    $("#avatar").attr("required", false);
    $("#modelContentLabel").html("Update Team Member Content");
    $("#teamMemberContentFormActionBtn").html("Update");
    $("#team-member-content-form").attr("action", $(this).attr("data-action"));
    if (!$("#team-member-content-form").find('input[name="_method"]').length) {
        $("#team-member-content-form").prepend(
            '<input type="hidden" name="_method" value="patch" />'
        );
    }

    let form = $("#team-member-content-form");
    let formData = new FormData(
        document.querySelector("#team-member-content-form")
    );

    // set form data by route
    setFormValue($(this).attr("data-route"), form, formData).then(
        (response) => {
            if (response) {
                $("#name").val(response.name);
                $("#designation").val(response.designation);
                $("#status").val(response.status).trigger("change");
            }
        }
    );

    // show model
    $("#addTeamMemberContent").modal("show");
});
