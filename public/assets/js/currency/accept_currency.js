const showCallBackData = function () {
    $("#accept_currency_add_modal").modal("hide");
    $("#_edit_modal").modal("hide");
    $("#accept_currency_form").trigger("reset");
    $("#accept-currency-table").DataTable().ajax.reload();
};
