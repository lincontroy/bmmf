const maxAccountLabel = 6;
let currentAccountLabel = 0;
$(document).on("click", ".add-account-label", function (e) {
    e.preventDefault();

    console.log("Hello World:::");

    if (currentAccountLabel < maxAccountLabel) {
        currentAccountLabel++;
        let accountLabelField = `
        <div class="col-12 col-lg-6">
            <label class="col-form-label text-start text-color-1 fs-16 fw-medium">Account Label Name<i
                    class="text-danger">*</i></label>
            <input class="custom-form-control bg-transparent @error('credential_name.${currentAccountLabel}') is-invalid @enderror"
                    type="text" name="credential_name[]" required />
        </div>
        <div class="col-12 col-lg-6 d-lg-flex flex-lg-column justify-content-lg-end">
            <label class="col-form-label text-start text-color-1 fs-16 fw-medium">Credential Value<i class="text-danger">*</i></label>
            <div class="d-flex gap-2">
            <input class="custom-form-control bg-transparent @error('credential_value.${currentAccountLabel}') is-invalid @enderror"
            type="text" name="credential_value[]" required />
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

const callBackFunc = function () {
    $(".btn-reset").click();
};

const gatewayDestroy = function (response, selector) {
    if (response.success == true) {
        $(selector).closest(".payment-gateway").remove();
    }
};

const showCallBackData = function (response) {
    if (response.success == true) {
        $("#_edit_modal").modal("hide");
        let status = response.data.status;
        let statusText = `<span class="fs-18 text-success">Active</span>`;
        if (status == "0") {
            statusText = `<span class="fs-18 text-danger">Inactive</span>`;
        }
        $("#gateway-status-" + response.data.id).html(statusText);
    }
};
