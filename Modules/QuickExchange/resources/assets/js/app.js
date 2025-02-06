const maxAccountLabel = 6;
let currentAccountLabel = 0;
$(".add-account-label").click(function (e) {
    e.preventDefault();

    if (currentAccountLabel < maxAccountLabel) {
        currentAccountLabel++;
        let accountLabelField = `
        <div class="col-12 col-lg-6">
            <label class="col-form-label text-start text-color-1 fs-16 fw-medium">Account Label Name<i
                    class="text-danger">*</i></label>
            <input class="custom-form-control bg-transparent @error('account_label_name.${currentAccountLabel}') is-invalid @enderror"
                    type="text" name="account_label_name[]" required />
        </div>
        <div class="col-12 col-lg-6 d-lg-flex flex-lg-column justify-content-lg-end">
            <div class="d-flex gap-2">
            <input class="custom-form-control bg-transparent @error('account_label_value.${currentAccountLabel}') is-invalid @enderror"
            type="text" name="account_label_value[]" required />
                <button type="button" class="btn btn-danger remove-account-label"><i class="fa fa-trash" aria-hidden="true"></i></button>
            </div>
        </div>
        `;

        $(".account-label-field").after(accountLabelField);
    }
});

$(document).on("click", ".remove-account-label", function () {
    currentAccountLabel--;
    let parentCol12 = $(this).closest(".col-12");
    parentCol12.prev(".col-12").remove();
    parentCol12.remove();
});

let showCallBackData = function () {
    $("#quick_exchange_coin_form").trigger("reset");
    $("#addQuickExchangeCoin").modal("hide");
    $("#_edit_modal").modal("hide");
    $("#quick_exchange_coin_table").DataTable().ajax.reload();
};

let baseCurrencyCallBack = function () {};

$(document).on("change", "#tnxStatusPaid, #tnxStatusReject", function () {
    if ($(this).val() === "1") {
        $(".payment-tx-hash").show();
        $(".payment-tx-hash input").prop("required", true);
    } else {
        $(".payment-tx-hash").hide();
        $(".payment-tx-hash input").prop("required", false);
    }
});

let callBackTableReload = function () {
    $("#quick_exchange_order_request").DataTable().ajax.reload();
    $("#_edit_modal").modal("hide");
};

