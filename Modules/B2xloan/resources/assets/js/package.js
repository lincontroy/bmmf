"use strict";

let showCallBackData = function () {
    $("#addPackage").modal("hide");
    $("#_edit_modal").modal("hide");
    $("#packages-table").DataTable().ajax.reload();
};

$(document).on("click", "#add-package-button", function () {
    $("#modelLabel").html("Add Package");
    $(".actionBtn").html("Submit");

    $("#b2x-loan-package-form").find('input[name="_method"]').remove();

    $("#b2x-loan-package-form").attr(
        "action",
        $("#b2x-loan-package-form").attr("data-insert")
    );
});
