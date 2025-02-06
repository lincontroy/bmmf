"use strict";
var showCallBackData = function (response) {
    $('#externalApi').modal('hide');
}

/**
 * Update language model open
 */
$(document).on("click", ".updateExternalApi", function () {
    // set form value
    $("#modelLabel").html("Update Api");
    $("#feeSettingFormActionBtn").html("Update");
    $("#externalApi-form").attr("action", $(this).attr("data-action"));
    if (!$("#externalApi-form").find('input[name="_method"]').length) {
        $("#externalApi-form").prepend(
            '<input type="hidden" name="_method" value="patch" />'
        );
    }

    let create_link = $(this).attr('create-link');

    $('.create_link').attr('href', create_link);

    let form = $("#externalApi-form");
    let formData = new FormData(document.querySelector("#externalApi-form"));

    // set form data by route
    let result = setFormValue($(this).attr("data-route"), form, formData);

    result.then(data => {
        let jsonString = data.data;
        let arrData = JSON.parse(jsonString);
        $('#api_key').val(arrData.api_key);
        $('#url').val(arrData.create_link);
    }).catch(res => {

    });

    // show model
    $("#externalApi").modal("show");
});
