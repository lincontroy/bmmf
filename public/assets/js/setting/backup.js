"use strict";

$(function () {
    var table = $("#backup-table").DataTable({
        // table responsive
        responsive: true,
        serverSide: false,
        processing: true,
        saveState: true,
        ajax: $("#backup-table").data("ajax"),
        columns: [
            {
                data: "DT_RowIndex",
                name: "DT_RowIndex",
                orderable: false, // Disable sorting for this column
                searchable: false, // Disable searching for this column
            },
            {
                data: "name",
                name: "name",
                orderable: false, // Disable sorting for this column
                searchable: false, // Disable searching for this column
            },
            {
                data: "disk",
                name: "disk",
                orderable: false, // Disable sorting for this column
                searchable: false, // Disable searching for this column
            },
            {
                data: "size",
                name: "size",
                orderable: false, // Disable sorting for this column
                searchable: false, // Disable searching for this column
            },
            {
                data: "last_modified",
                name: "last_modified",
                orderable: false, // Disable sorting for this column
                searchable: false, // Disable searching for this column
            },
            {
                data: "action",
                name: "action",
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

$(document).on("click", ".create-backup", function () {
    var mode = $(this).attr("data-mode");
    var url = $(this).attr("data-url");
    var $modal = $("#backupModal");
    $modal.modal("show");

    $.ajax({
        type: "post",
        url: url,
        data: {
            option: mode,
        },
    })
        .then((response) => {
            $modal.modal("hide");

            setAlertMessage(response);
            $(".dataTable").DataTable().ajax.reload();
        })
        .catch((response) => {
            $modal.modal("hide");
            let data = response.responseJSON;

            if (data) {
                setAlertMessage(response);
            }
        });
});

$(document).on("click", ".delete-backup", function () {
    var url = $(this).attr("data-url");
    var $modal = $("#backupModal");
    $modal.modal("show");

    $.ajax({
        type: "delete",
        url: url,
    })
        .then((response) => {
            $modal.modal("hide");

            setAlertMessage(response);
            $(".dataTable").DataTable().ajax.reload();
        })
        .catch((response) => {
            $modal.modal("hide");
            let data = response.responseJSON;

            if (data) {
                setAlertMessage(response);
            }
        });
});

/**
 * z Form callback function
 */
var showCallBackData = function () {
    // hide model
    $("#backupModal").modal("hide");
    // reload table
    $(".dataTable").DataTable().ajax.reload();
};

/**
 * Add language model open
 */
$(document).on("click", "#add-language-button", function () {
    // set form value
    $("#modelLabel").html("Create z");
    $("#languageFormActionBtn").html("Create");
    $("#language-form").find('input[name="_method"]').remove();
    $("#language-form").attr("action", $("#language-form").attr("data-insert"));
    $("#password_required").html("*");
    $("#password").attr({
        required: true,
    });

    removeFormValidation(
        $("#language-form"),
        new FormData(document.querySelector("#language-form")),
        true
    );
});

/**
 * Update language model open
 */
$(document).on("click", ".edit-button", function () {
    // set form value
    $("#modelLabel").html("Update z");
    $("#languageFormActionBtn").html("Update");
    $("#language-form").attr("action", $(this).attr("data-action"));
    if (!$("#language-form").find('input[name="_method"]').length) {
        $("#language-form").prepend(
            '<input type="hidden" name="_method" value="patch" />'
        );
    }

    // set form data by route
    setFormValue(
        $(this).attr("data-route"),
        $("#language-form"),
        new FormData(document.querySelector("#language-form"))
    );

    // show model
    $("#addLanguage").modal("show");
});
