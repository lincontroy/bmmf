"use strict";
var showCallBackDataEmailForm = function (response) {
    let form = $("#email-notification-setup-form");
    let data = response.data;

    form.find(":input").each(function () {
        var elementType = this.tagName.toLowerCase();
        var inputObject = $(this);
        var inputName = inputObject.attr("name");
        if (!inputName) {
            return;
        }

        inputObject.prop("checked", false);

        if (elementType === "input") {
            var inputType = inputObject.attr("type");
            if (["checkbox"].includes(inputType)) {
                if (inputName.includes("[") && inputName.includes("]")) {
                    var inputValue = inputObject.val();
                    inputName = inputName.replace("[", "").replace("]", "");
                    if (data) {
                        data.map(function (dataValue) {
                            if (
                                dataValue.id == inputValue &&
                                dataValue.status == 1
                            ) {
                                inputObject.prop("checked", true);
                            }
                        });
                    }
                }
            }
        }
    });
};

var showCallBackDataSMSForm = function (response) {
    let form = $("#sms-notification-setup-form");
    let data = response.data;

    form.find(":input").each(function () {
        var elementType = this.tagName.toLowerCase();
        var inputObject = $(this);
        var inputName = inputObject.attr("name");
        if (!inputName) {
            return;
        }

        inputObject.prop("checked", false);

        if (elementType === "input") {
            var inputType = inputObject.attr("type");
            if (["checkbox"].includes(inputType)) {
                if (inputName.includes("[") && inputName.includes("]")) {
                    var inputValue = inputObject.val();
                    inputName = inputName.replace("[", "").replace("]", "");
                    if (data) {
                        data.map(function (dataValue) {
                            if (
                                dataValue.id == inputValue &&
                                dataValue.status == 1
                            ) {
                                inputObject.prop("checked", true);
                            }
                        });
                    }
                }
            }
        }
    });
};
