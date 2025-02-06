"use strict";

/**
 * Home slider Form callback function
 */
var showCallBackData = function () {
    // hide model
    $("#addSocialIcon").modal("hide");
    // reload table
    $(".dataTable").DataTable().ajax.reload();
};

/**
 * Add home slider model open
 */
$(document).on("click", "#add-social-icon-button", function () {
    // set form value
    $("#image_required_div").html("*");
    $("#image").attr("required", true);
    $("#modelLabel").html("Create Social Icon");
    $("#article_id").val("0");
    $("#socialIconFormActionBtn").html("Create");
    $("#social-icon-form").find('input[name="_method"]').remove();
    $("#social-icon-form").attr(
        "action",
        $("#social-icon-form").attr("data-insert")
    );

    removeFormValidation(
        $("#social-icon-form"),
        new FormData(document.querySelector("#social-icon-form")),
        true
    );
});

/**
 * Update home slider model open
 */
$(document).on("click", ".edit-social-icon-button", function () {
    // set form value
    $("#image_required_div").html("");
    $("#image").attr("required", false);
    $("#modelLabel").html("Update Social Icon");
    $("#socialIconFormActionBtn").html("Update");
    $("#social-icon-form").attr("action", $(this).attr("data-action"));
    if (!$("#social-icon-form").find('input[name="_method"]').length) {
        $("#social-icon-form").prepend(
            '<input type="hidden" name="_method" value="patch" />'
        );
    }

    let form = $("#social-icon-form");
    let formData = new FormData(document.querySelector("#social-icon-form"));

    // set form data by route
    setFormValue($(this).attr("data-route"), form, formData).then(
        (response) => {
            if (response) {
                $("#article_id").val(response.article.id);

                if (response.article) {
                    $("#social_icon_name").val(response.article.article_name);
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
            }
        }
    );

    // show model
    $("#addSocialIcon").modal("show");
});
