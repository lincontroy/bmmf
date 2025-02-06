var base_url = $('meta[name="base-url"]').attr("content");
let exceptName = ["_token", "_method"];

/**
 * Success alert
 *
 * @param {string} text
 * @param {string} title
 * @param {integer} timer
 * @param void
 */
function success_alert(text, title = null, timer = 5000) {
    toastr.success(text, title, { timeOut: timer });
}

/**
 * warning alert
 *
 * @param {string} text
 * @param {string} title
 * @param {integer} timer
 * @param void
 */
function warning_alert(text, title = null, timer = 5000) {
    toastr.warning(text, title, { timeOut: timer });
}

/**
 * error alert
 *
 * @param {string} text
 * @param {string} title
 * @param {integer} timer
 * @param void
 */
function error_alert(text, title = null, timer = 5000) {
    toastr.error(text, title, { timeOut: timer });
}

/**
 * Get ajax data
 *
 * @param {*} route
 * @return {*} promise
 */
function getAjaxData(route) {
    return $.ajax({
        type: "get",
        url: route,
        processData: false,
        contentType: false,
        cache: false,
        dataType: "json",
        async: false,
    })
        .then((response) => {
            let formValue = response.data;

            return formValue;
        })
        .catch(function (response) {
            let data = response.responseJSON;
            error_alert(data.message, data.title);

            return data;
        });
}

/**
 * Set alert message
 *
 *
 * @param object response
 * @param type string|null
 * @return void
 */
function setAlertMessage(response, type = null) {
    if (type == "success" || response.success == true) {
        success_alert(response.message, response.title);
    } else if (type == "warning" || response.success == "exist") {
        warning_alert(response.message, response.title);
    } else if (type == "error" || response.success == false) {
        error_alert(response.message, response.title);
    }
}

(function ($) {
    "use strict";
    // window.addEventListener("load", formValidation(), false);

    $(document).ready(function () {
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });
    });
})(jQuery);

$(document).on("click", ".copy-value", function () {
    navigator.clipboard.writeText($(this).attr("data-copyvalue"));
    success_alert("Copied");
});

$(document).on("click", ".copy", function () {
    let $button = $(this);
    let $input = $button.prev(".copy-data");
    let text = $input.val();
    navigator.clipboard.writeText(text).then(
        function () {
            $button.text("Copied");
            setTimeout(function () {
                $button.text("Copy");
            }, 3000);
        }.bind(this),
        function (err) {
            console.error("Could not copy text: ", err);
        }
    );
});
