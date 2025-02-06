"use strict";

$(document).on("click", ".nav-item", function () {
    var table = $(".dataTable");
    $(".nav-link").removeClass("active");
    $(this).find(".nav-link").addClass("active");

    var status = $(this).attr("data-status");

    // Clear existing event listeners
    table.off("preXhr.dt");
    // Add new event listener
    table.on("preXhr.dt", function (e, settings, data) {
        data.status = status;
    });
    table.DataTable().ajax.reload();
});
