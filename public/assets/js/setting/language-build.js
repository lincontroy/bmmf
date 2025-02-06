"use strict";
$(function () {
    var table = $("#local-builder-table").DataTable({
        // table responsive
        responsive: true,
        serverSide: false,
        processing: true,
        saveState: true,
        ajax: $("#local-builder-table").data("ajax"),
        columns: [
            {
                data: "key",
                name: "key",
                className: "text-start",
                render: function (data, type, row) {
                    // replace underscore with space
                    if (typeof data === "string") {
                        data = data.replace(/_/g, " ");
                    } else {
                        data = String(data).replace(/_/g, " ");
                    }
                    return data;
                },
            },
            {
                data: "value",
                name: "value",
                className: "text-start",
                render: function (data, type, row) {
                    return type === "display"
                        ? `<div contenteditable="true" class="editable-value" data-key="${row.key}" data-value="${row.value}">` +
                              data +
                              "</div>"
                        : data;
                },
            },
            {
                // Action buttons column
                data: null,
                data: "action",
                name: "action",
                // responsivePriority
                responsivePriority: -1,

                orderable: false, // Disable sorting for this column
                searchable: false, // Disable searching for this column
            },
        ],
        dom: "<'row m-3'<'col-md-3'l><'col-md-5 d-flex align-items-center'B><'col-md-4'f>>rt<'bottom'<'row'<'col-md-6'i><'col-md-6'p>>><'clear'>",
        buttons: [
            {
                extend: "excel",
                text: '<i class="fa fa-file-excel"></i> Excel',
                className: "btn btn-success box-shadow--4dp btn-sm-menu",
            },
            {
                extend: "csv",
                text: '<i class="fa fa-file-csv"></i> CSV',
                className: "btn btn-success box-shadow--4dp btn-sm-menu",
            },
            {
                extend: "pdf",
                text: '<i class="fa fa-file-pdf"></i> PDF',
                className: "btn btn-success box-shadow--4dp btn-sm-menu",
            },
            {
                extend: "print",
                text: '<i class="fa fa-print"></i> Print',
                className: "btn btn-success box-shadow--4dp btn-sm-menu",
            },
            {
                extend: "reset",
                text: '<i class="fa fa-undo-alt"></i> Reset',
                className: "btn btn-success box-shadow--4dp btn-sm-menu",
            },
        ],
    });
});

/**
 * Language Form callback function
 */
var showCallBackData = function () {
    // hide model
    $("#addLanguageBuild").modal("hide");
    // reload table
    $(".dataTable").DataTable().ajax.reload();
};

var showCallBackDataForSendSMS = function () {};

/**
 * Add new local row
 */
$(document).on("click", "#addNewLocalRow", function () {
    var tr = `
        <tr id="serial">
            <td class="p-2">
                <input type="text" name="key[]" value="" class="form-control" placeholder="Enter your key" required>
            </td>
            <td class="p-2">
                <input type="text" name="label[]" value="" class="form-control"  placeholder="Enter your value" required>
            </td>
            <td>
                <button class="btn btn-danger bg-danger btn-sm deleteLocalRow" type="button">
                <i class="fa fa-trash"></i>
            </button>
            </td>
        </tr>
    `;

    $("#build-local tbody").append(tr);
});

/**
 * delete local row
 */
$(document).on("click", ".deleteLocalRow", function () {
    $(this).parent().parent().remove();
});

/**
 * Add language model open
 */
$(document).on("click", "#add-language-button", function () {
    // set form value
    $("#modelLabel").html("Create Language Build");
    $("#languageFormActionBtn").html("Create");
    $("#build-language-form").find('input[name="_method"]').remove();
    $("#build-language-form").attr(
        "action",
        $("#build-language-form").attr("data-insert")
    );
    $("#password_required").html("*");
    $("#password").attr({
        required: true,
    });

    $("#build-local > tbody").html("");
    $("#addNewLocalRow").trigger("click").attr("disabled", false);
    $("#addNewLocalRow").show();

    removeFormValidation(
        $("#build-language-form"),
        new FormData(document.querySelector("#build-language-form")),
        true
    );
});

/**
 * Update language model open
 */
$(document).on("click", ".edit-build-button", function () {
    let key = $(this).attr("data-key");
    let value = $(this).attr("data-value");

    // set form value
    $("#modelLabel").html("Update Language Build");
    $("#languageFormActionBtn").html("Update");

    $("#build-language-form").attr("action", $(this).attr("data-action"));

    if (!$("#build-language-form").find('input[name="_method"]').length) {
        $("#build-language-form").prepend(
            '<input type="hidden" name="_method" value="patch" />'
        );
    }

    $("#build-local > tbody").html("");
    $("#addNewLocalRow").attr("disabled", false);
    $("#addNewLocalRow").trigger("click").attr("disabled", true);
    $("#addNewLocalRow").hide();

    $(".deleteLocalRow").remove();

    $(`input[name='key[]']`).val(key);
    $(`input[name='label[]']`).val(value);

    // show model
    $("#addLanguageBuild").modal("show");
});
