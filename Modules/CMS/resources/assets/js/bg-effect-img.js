"use strict";

/**
 * Menu form callback function
 */
var showCallBackData = function () {
    // hide model
    $("#updateBgEffectImg").modal("hide");

    window.location.reload();
};

/**
 * Edit
 */
$(document).on("click", ".edit-bg-image-button", function () {
    // set form value
    $("#bg-image-form").attr("action", $(this).attr("data-action"));
    if (!$("#bg-image-form").find('input[name="_method"]').length) {
        $("#bg-image-form").prepend(
            '<input type="hidden" name="_method" value="patch" />'
        );
    }

    let form = $("#bg-image-form");
    let formData = new FormData(document.querySelector("#bg-image-form"));

    // set form data by route
    setFormValue($(this).attr("data-route"), form, formData).then(
        (response) => {
            console.log(response);
            if (response.content) {
                $("#preview_file_image").html(
                    `<img src="${response.content}" width="100" height="100" class="form-preview-image img-responsive img-rounded"/>`
                );
            }
        }
    );

    // show model
    $("#updateBgEffectImg").modal("show");
});
