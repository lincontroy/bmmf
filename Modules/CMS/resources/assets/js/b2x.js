"use strict";

/**
 * B2x loan form callback function
 */
var showLoanCallBackData = function () {
    // hide model
    $("#updateLoan").modal("hide");
};

/**
 * Update update loan button model open
 */
$(document).on("click", "#update-loan-button", function () {
    // set form value
    $("#modelLabel").html("Update B2X Loan");
    $("#loanFormActionBtn").html("Update");
    let action = $(this).attr("data-action");

    $("#loan-form").attr("action", $(this).attr("data-action"));

    if (!$("#loan-form").find('input[name="_method"]').length) {
        $("#loan-form").prepend(
            '<input type="hidden" name="_method" value="patch" />'
        );
    }

    let form = $("#loan-form");
    let formData = new FormData(document.querySelector("#loan-form"));

    // set form data by route
    setFormValue($(this).attr("data-route"), form, formData).then(
        (response) => {
            if (response) {
                $("#header_article_id").val(response.article.id);

                if (response.article) {
                    $("#b2x_loan").val(response.article.article_name);
                    $("#loan_status")
                        .val(response.article.status)
                        .trigger("change");
                }

                if (response.defaultLanguage) {
                    $("#loan_language_id")
                        .val(response.defaultLanguage.id)
                        .trigger("change");
                }

                if (response.articleLangData) {
                    response.articleLangData.map(function (articleLangData) {
                        if (articleLangData.slug == "b2x_title") {
                            $("#b2x_title").val(articleLangData.small_content);
                        } else if (
                            articleLangData.slug == "b2x_button_one_text"
                        ) {
                            $("#b2x_button_one_text").val(
                                articleLangData.small_content
                            );
                        } else if (
                            articleLangData.slug == "b2x_button_two_text"
                        ) {
                            $("#b2x_button_two_text").val(
                                articleLangData.small_content
                            );
                        } else if (articleLangData.slug == "b2x_content") {
                            $("#b2x_content").val(
                                articleLangData.large_content
                            );
                        }
                    });
                }
            }
        }
    );

    // show model
    $("#updateLoan").modal("show");
});

/**
 * Get b2x loan data
 */
$(document).on("change", "#loan_language_id", function () {
    var article_id = $("#loan_article_id").val();
    var language_id = $("#loan_language_id option:selected").val();

    $("#b2x_title").val("");
    $("#b2x_button_one_text").val("");
    $("#b2x_button_two_text").val("");
    $("#b2x_content").val("");

    if (article_id && language_id && article_id != 0 && language_id != 0) {
        var getData = $("#loan-form").attr("data-getData");
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
                        if (articleLangData.slug == "b2x_title") {
                            $("#b2x_title").val(articleLangData.small_content);
                        } else if (
                            articleLangData.slug == "b2x_button_one_text"
                        ) {
                            $("#b2x_button_one_text").val(
                                articleLangData.small_content
                            );
                        } else if (
                            articleLangData.slug == "b2x_button_two_text"
                        ) {
                            $("#b2x_button_two_text").val(
                                articleLangData.small_content
                            );
                        } else if (articleLangData.slug == "b2x_content") {
                            $("#b2x_content").val(
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
 * B2x loan form callback function
 */
var showLoanBannerCallBackData = function () {
    // hide model
    $("#updateLoanBanner").modal("hide");
};

/**
 * Update top banner model open
 */
$(document).on("click", "#update-loan-banner-button", function () {
    // set form value
    $("#modelBannerLabel").html("Update B2X Loan Banner");
    $("#loanBannerFormActionBtn").html("Update");
    let action = $(this).attr("data-action");

    $("#loan-banner-form").attr("action", $(this).attr("data-action"));

    if (!$("#loan-banner-form").find('input[name="_method"]').length) {
        $("#loan-banner-form").prepend(
            '<input type="hidden" name="_method" value="patch" />'
        );
    }

    let form = $("#loan-banner-form");
    let formData = new FormData(document.querySelector("#loan-banner-form"));

    // set form data by route
    setFormValue($(this).attr("data-route"), form, formData).then(
        (response) => {
            if (response) {
                $("#loan_banner_article_id").val(response.article.id);

                if (response.article) {
                    $("#b2x_loan_banner").val(response.article.article_name);
                    $("#loan_banner_status")
                        .val(response.article.status)
                        .trigger("change");
                }

                if (response.defaultLanguage) {
                    $("#loan_banner_language_id")
                        .val(response.defaultLanguage.id)
                        .trigger("change");
                }

                if (response.articleLangData) {
                    response.articleLangData.map(function (articleLangData) {
                        if (articleLangData.slug == "b2x_loan_banner_title") {
                            $("#b2x_loan_banner_title").val(
                                articleLangData.small_content
                            );
                        }
                    });
                }
            }
        }
    );

    // show model
    $("#updateLoanBanner").modal("show");
});

/**
 * Get b2x loan banner data
 */
$(document).on("change", "#loan_banner_language_id", function () {
    var article_id = $("#loan_banner_article_id").val();
    var language_id = $("#loan_banner_language_id option:selected").val();

    $("#b2x_loan_banner_title").val("");

    if (article_id && language_id && article_id != 0 && language_id != 0) {
        var getData = $("#loan-banner-form").attr("data-getData");
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
                        if (articleLangData.slug == "b2x_loan_banner_title") {
                            $("#b2x_loan_banner_title").val(
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
 * B2x calculator header form callback function
 */
var showCalculatorHeaderCallBackData = function () {
    // hide model
    $("#updateCalculatorHeader").modal("hide");
};

/**
 * Update calculator header model open
 */
$(document).on("click", "#update-calculator-header-button", function () {
    // set form value
    $("#modelBannerLabel").html("Update B2X Calculator Header");
    $("#calculatorHeaderFormActionBtn").html("Update");
    let action = $(this).attr("data-action");

    $("#calculator-header-form").attr("action", $(this).attr("data-action"));

    if (!$("#calculator-header-form").find('input[name="_method"]').length) {
        $("#calculator-header-form").prepend(
            '<input type="hidden" name="_method" value="patch" />'
        );
    }

    let form = $("#calculator-header-form");
    let formData = new FormData(
        document.querySelector("#calculator-header-form")
    );

    // set form data by route
    setFormValue($(this).attr("data-route"), form, formData).then(
        (response) => {
            if (response) {
                $("#calculator_header_article_id").val(response.article.id);

                if (response.article) {
                    $("#b2x_calculator_header").val(
                        response.article.article_name
                    );
                    $("#calculator_header_status")
                        .val(response.article.status)
                        .trigger("change");
                }

                if (response.defaultLanguage) {
                    $("#calculator_header_language_id")
                        .val(response.defaultLanguage.id)
                        .trigger("change");
                }

                if (response.articleLangData) {
                    response.articleLangData.map(function (articleLangData) {
                        if (
                            articleLangData.slug ==
                            "b2x_calculator_header_title"
                        ) {
                            $("#b2x_calculator_header_title").val(
                                articleLangData.small_content
                            );
                        } else if (
                            articleLangData.slug ==
                            "b2x_calculator_header_content"
                        ) {
                            $("#b2x_calculator_header_content").val(
                                articleLangData.small_content
                            );
                        } else if (
                            articleLangData.slug ==
                            "b2x_loan_details_header_title"
                        ) {
                            $("#b2x_loan_details_header_title").val(
                                articleLangData.small_content
                            );
                        } else if (
                            articleLangData.slug == "b2x_loan_button_text"
                        ) {
                            $("#b2x_loan_button_text").val(
                                articleLangData.small_content
                            );
                        }
                    });
                }
            }
        }
    );

    // show model
    $("#updateCalculatorHeader").modal("show");
});

/**
 * Get b2x loan banner data
 */
$(document).on("change", "#calculator_header_language_id", function () {
    var article_id = $("#calculator_header_article_id").val();
    var language_id = $("#calculator_header_language_id option:selected").val();

    $("#b2x_calculator_header_title").val("");
    $("#b2x_calculator_header_content").val("");
    $("#b2x_loan_details_header_title").val("");
    $("#b2x_loan_button_text").val("");

    if (article_id && language_id && article_id != 0 && language_id != 0) {
        var getData = $("#calculator-header-form").attr("data-getData");
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
                            "b2x_calculator_header_title"
                        ) {
                            $("#b2x_calculator_header_title").val(
                                articleLangData.small_content
                            );
                        } else if (
                            articleLangData.slug ==
                            "b2x_calculator_header_content"
                        ) {
                            $("#b2x_calculator_header_content").val(
                                articleLangData.small_content
                            );
                        } else if (
                            articleLangData.slug ==
                            "b2x_loan_details_header_title"
                        ) {
                            $("#b2x_loan_details_header_title").val(
                                articleLangData.small_content
                            );
                        } else if (
                            articleLangData.slug == "b2x_loan_button_text"
                        ) {
                            $("#b2x_loan_button_text").val(
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
 * B2x loan form callback function
 */
var showLoanDetailsHeaderCallBackData = function () {
    // hide model
    $("#updateLoanDetailsHeader").modal("hide");
};

/**
 * Update loan details header model open
 */
$(document).on("click", "#update-loan-details-header-button", function () {
    // set form value
    $("#modelLoanDetailsHeaderLabel").html("Update B2X Loan Details Header");
    $("#loanDetailsHeaderFormActionBtn").html("Update");
    let action = $(this).attr("data-action");

    $("#loan-details-header-form").attr("action", $(this).attr("data-action"));

    if (!$("#loan-details-header-form").find('input[name="_method"]').length) {
        $("#loan-details-header-form").prepend(
            '<input type="hidden" name="_method" value="patch" />'
        );
    }

    let form = $("#loan-details-header-form");
    let formData = new FormData(
        document.querySelector("#loan-details-header-form")
    );

    // set form data by route
    setFormValue($(this).attr("data-route"), form, formData).then(
        (response) => {
            if (response) {
                $("#loan_details_header_article_id").val(response.article.id);

                if (response.article) {
                    $("#b2x_loan_details_header").val(
                        response.article.article_name
                    );
                    $("#loan_details_header_status")
                        .val(response.article.status)
                        .trigger("change");
                }

                if (response.defaultLanguage) {
                    $("#loan_details_header_language_id")
                        .val(response.defaultLanguage.id)
                        .trigger("change");
                }

                if (response.articleLangData) {
                    response.articleLangData.map(function (articleLangData) {
                        if (
                            articleLangData.slug ==
                            "b2x_loan_details_header_title"
                        ) {
                            $("#new_b2x_loan_details_header_title").val(
                                articleLangData.small_content
                            );
                        }
                    });
                }
            }
        }
    );
    // show model
    $("#updateLoanDetailsHeader").modal("show");
});

/**
 * Get b2x loan details header
 */
$(document).on("change", "#loan_details_header_language_id", function () {
    var article_id = $("#loan_details_header_article_id").val();
    var language_id = $(
        "#loan_details_header_language_id option:selected"
    ).val();

    $("#new_b2x_loan_details_header_title").val("");

    if (article_id && language_id && article_id != 0 && language_id != 0) {
        var getData = $("#loan-details-header-form").attr("data-getData");
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
                            "b2x_loan_details_header_title"
                        ) {
                            $("#new_b2x_loan_details_header_title").val(
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
 * B2X loan form callback function
 */
var showLoanDetailsContentCallBackData = function () {
    // hide model
    $("#updateLoanDetailsContent").modal("hide");
};

/**
 * Update loan details content model open
 */
$(document).on("click", "#update-loan-details-content-button", function () {
    // set form value
    $("#modelLoanDetailsContentLabel").html("Update B2X Loan Details Content");
    $("#loanDetailsContentFormActionBtn").html("Update");
    let action = $(this).attr("data-action");

    $("#loan-details-content-form").attr("action", $(this).attr("data-action"));

    if (!$("#loan-details-content-form").find('input[name="_method"]').length) {
        $("#loan-details-content-form").prepend(
            '<input type="hidden" name="_method" value="patch" />'
        );
    }

    let form = $("#loan-details-content-form");
    let formData = new FormData(
        document.querySelector("#loan-details-content-form")
    );

    // set form data by route
    setFormValue($(this).attr("data-route"), form, formData).then(
        (response) => {
            if (response) {
                $("#loan_details_content_article_id").val(response.article.id);

                if (response.article) {
                    $("#b2x_loan_details_content").val(
                        response.article.article_name
                    );
                    $("#loan_details_content_status")
                        .val(response.article.status)
                        .trigger("change");
                }

                if (response.defaultLanguage) {
                    $("#loan_details_content_language_id")
                        .val(response.defaultLanguage.id)
                        .trigger("change");
                }

                if (response.articleLangData) {
                    response.articleLangData.map(function (articleLangData) {
                        if (
                            articleLangData.slug == "b2x_loan_details_content"
                        ) {
                            $("#new_b2x_loan_details_content").val(
                                articleLangData.small_content
                            );
                        }
                    });
                }
            }
        }
    );
    // show model
    $("#updateLoanDetailsContent").modal("show");
});

/**
 * Get b2x loan details content
 */
$(document).on("change", "#loan_details_content_language_id", function () {
    var article_id = $("#loan_details_content_article_id").val();
    var language_id = $(
        "#loan_details_content_language_id option:selected"
    ).val();

    $("#new_b2x_loan_details_content").val("");

    if (article_id && language_id && article_id != 0 && language_id != 0) {
        var getData = $("#loan-details-content-form").attr("data-getData");
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
                            articleLangData.slug == "b2x_loan_details_content"
                        ) {
                            $("#new_b2x_loan_details_content").val(
                                articleLangData.small_content
                            );
                        }
                    });
                }
            })
            .catch(function (response) {});
    }
});
