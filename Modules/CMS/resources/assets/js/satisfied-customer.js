"use strict";

/**
 * Satisfy customer header Form callback function
 */
var showHeaderCallBackData = function () {
    // hide model
    $("#updateSatisfiedCustomerHeader").modal("hide");
    // reload table
    $(".dataTable").DataTable().ajax.reload();
};

/**
 * Customer satisfy content Form callback function
 */
var showCallBackData = function () {
    // hide model
    $("#addCustomerSatisfyContent").modal("hide");
    // reload table
    $(".dataTable").DataTable().ajax.reload();
};

/**
 * Update satisfy customer header model open
 */
$(document).on(
    "click",
    "#update-satisfied-customer-header-button",
    function () {
        // set form value
        $("#modelHeaderLabel").html("Update Customer Satisfied Content");
        $("#satisfiedCustomerHeaderFormActionBtn").html("Update");
        let action = $(this).attr("data-action");

        $("#satisfied-customer-header-form").attr(
            "action",
            $(this).attr("data-action")
        );

        if (
            !$("#satisfied-customer-header-form").find('input[name="_method"]')
                .length
        ) {
            $("#satisfied-customer-header-form").prepend(
                '<input type="hidden" name="_method" value="patch" />'
            );
        }

        let form = $("#satisfied-customer-header-form");
        let formData = new FormData(
            document.querySelector("#satisfied-customer-header-form")
        );

        // set form data by route
        setFormValue($(this).attr("data-route"), form, formData).then(
            (response) => {
                if (response) {
                    $("#header_article_id").val(response.article.id);

                    if (response.article) {
                        $("#satisfied_customer_header").val(
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
                        response.articleLangData.map(function (
                            articleLangData
                        ) {
                            if (
                                articleLangData.slug ==
                                "satisfied_customer_header_title"
                            ) {
                                $("#satisfied_customer_header_title").val(
                                    articleLangData.small_content
                                );
                            } else if (
                                articleLangData.slug ==
                                "satisfied_customer_header_content"
                            ) {
                                $("#satisfied_customer_header_content").val(
                                    articleLangData.large_content
                                );
                            }
                        });
                    }
                }
            }
        );

        // show model
        $("#updateSatisfiedCustomerHeader").modal("show");
    }
);

/**
 * Get customer satisfy header article data
 */
$(document).on("change", "#header_language_id", function () {
    var article_id = $("#header_article_id").val();
    var language_id = $("#header_language_id option:selected").val();

    $("#satisfied_customer_header_title").val("");
    $("#satisfied_customer_header_content").val("");

    if (article_id && language_id && article_id != 0 && language_id != 0) {
        var getData = $("#satisfied-customer-header-form").attr("data-getData");
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
                            "satisfied_customer_header_title"
                        ) {
                            $("#satisfied_customer_header_title").val(
                                articleLangData.small_content
                            );
                        } else if (
                            articleLangData.slug ==
                            "satisfied_customer_header_content"
                        ) {
                            $("#satisfied_customer_header_content").val(
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
 * Add satisfy customer content model open
 */
$(document).on("click", "#add-satisfy-customer-content-button", function () {
    // set form value
    $("#image_required_div").html("*");
    $("#image").attr("required", true);
    $("#modelLabel").html("Create Customer Satisfied Content");
    $("#article_id").val("0");
    $("#customerSatisfyContentFormActionBtn").html("Create");
    $("#satisfy-customer-content-form").find('input[name="_method"]').remove();
    $("#satisfy-customer-content-form").attr(
        "action",
        $("#satisfy-customer-content-form").attr("data-insert")
    );

    removeFormValidation(
        $("#satisfy-customer-content-form"),
        new FormData(document.querySelector("#satisfy-customer-content-form")),
        true
    );
});

/**
 * Update satisfy customer content model open
 */
$(document).on("click", ".edit-satisfied-customer-content-button", function () {
    // set form value
    $("#image_required_div").html("");
    $("#image").attr("required", false);
    $("#modelLabel").html("Update Customer Satisfied Content");
    $("#customerSatisfyContentFormActionBtn").html("Update");
    $("#satisfy-customer-content-form").attr(
        "action",
        $(this).attr("data-action")
    );
    if (
        !$("#satisfy-customer-content-form").find('input[name="_method"]')
            .length
    ) {
        $("#satisfy-customer-content-form").prepend(
            '<input type="hidden" name="_method" value="patch" />'
        );
    }

    let form = $("#satisfy-customer-content-form");
    let formData = new FormData(
        document.querySelector("#satisfy-customer-content-form")
    );

    // set form data by route
    setFormValue($(this).attr("data-route"), form, formData).then(
        (response) => {
            if (response) {
                $("#article_id").val(response.article.id);

                if (response.article) {
                    $("#customer_satisfy_content").val(
                        response.article.article_name
                    );
                    $("#status").val(response.article.status).trigger("change");
                }

                if (response.articleData) {
                    response.articleData.map(function (articleData) {
                        if (articleData.slug == "name") {
                            $("#satisfy_customer_name").val(
                                articleData.content
                            );
                        } else if (articleData.slug == "company_name") {
                            $("#satisfy_customer_company_name").val(
                                articleData.content
                            );
                        } else if (articleData.slug == "designation") {
                            $("#designation").val(
                                articleData.content
                            );
                        } else if (articleData.slug == "url") {
                            $("#satisfy_customer_company_url").val(
                                articleData.content
                            );
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
                        if (
                            articleLangData.slug == "satisfy_customer_message"
                        ) {
                            $("#satisfy_customer_message").val(
                                articleLangData.large_content
                            );
                        }
                    });
                }
            }
        }
    );

    // show model
    $("#addCustomerSatisfyContent").modal("show");
});

/**
 * Get article language data
 */
$(document).on("change", "#language_id", function () {
    var article_id = $("#article_id").val();
    var language_id = $("#language_id option:selected").val();

    $("#satisfy_customer_message").val("");

    if (article_id && language_id && article_id != 0 && language_id != 0) {
        var getData = $("#satisfy-customer-content-form").attr("data-getData");
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
                            articleLangData.slug == "satisfy_customer_message"
                        ) {
                            $("#satisfy_customer_message").val(
                                articleLangData.large_content
                            );
                        }
                    });
                }
            })
            .catch(function (response) {});
    }
});
