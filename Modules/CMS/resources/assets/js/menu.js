"use strict";

/**
 * Menu form callback function
 */
var showCallBackData = function () {
    // hide model
    $("#addMenu").modal("hide");
    // reload table
    $(".dataTable").DataTable().ajax.reload();
};

/**
 * Update menu model open
 */
$(document).on("click", ".edit-menu-button", function () {
    // set form value
    $("#menu_slug").html("");
    $("#modelLabel").html("Update Menu");
    $("#menuFormActionBtn").html("Update");
    $("#menu-form").attr("action", $(this).attr("data-action"));
    if (!$("#menu-form").find('input[name="_method"]').length) {
        $("#menu-form").prepend(
            '<input type="hidden" name="_method" value="patch" />'
        );
    }

    let form = $("#menu-form");
    let formData = new FormData(document.querySelector("#menu-form"));

    // set form data by route
    setFormValue($(this).attr("data-route"), form, formData).then(
        (response) => {
            if (response.articleLangData) {
                let menu_slug = `<option value=''></option>`;

                response.articleLangData.map((data) => {
                    menu_slug += `<option value='${data.slug}'>${data.small_content}</option>`;
                });

                $("#menu_slug").html(menu_slug);
                $("#menu_slug").trigger("change");
            }
        }
    );

    // show model
    $("#addMenu").modal("show");
});

/**
 * Get article language data
 */
$(document).on("change", "#menu_slug, #language_id", function () {
    var menu_slug = $("#menu_slug option:selected").val();
    var language_id = $("#language_id option:selected").val();

    if (menu_slug && language_id && language_id != 0) {
        $("#menu_name").val("");

        menu_slug = menu_slug == "/" ? "home" : menu_slug;

        var getData = $("#menu-form").attr("data-getData");
        let routeUrl = getData
            .replace(":article", menu_slug)
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
                    $("#menu_name").val(response.data);
                }
            })
            .catch(function (response) {});
    }
});
