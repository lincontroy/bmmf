"use strict";

$(document).ready(function () {
    const maxRates = 4;
    let currentRates = 0;

    $("#addNewRates").click(function (e) {
        e.preventDefault();

        if (currentRates < maxRates) {
            currentRates++;
            let ratesFields = `
                <div class="row mb-3">
                    <div class="align-items-center gap-2">
                    <button type="button"
                            class="btn btn-sm bg-soft-1 btn-sm p-sm-1 text-red white-space remove-rates float-end mb-1"><i class="fa fa-trash" aria-hidden="true"></i></button>
                        <hr class="my-2 divider-color w-100" />
                    </div>
                    <div class="col-12 col-lg-6">
                        <div class="mb-2">
                            <label class="col-form-label text-start text-color-1 fs-16 fw-medium">Duration (days)<span
                                    class="text-danger">*</span></label>
                            <input class="custom-form-control bg-transparent" type="text" name="duration[]"
                                required />
                        </div>
                        <div class="mb-2">
                            <label class="col-form-label text-start text-color-1 fs-16 fw-medium">Min
                                Locked Amount<span class="text-danger">*</span></label>
                            <input class="custom-form-control bg-transparent" type="text" name="min_value[]"
                                required />
                        </div>
                    </div>
                    <div class="col-12 col-lg-6">
                        <div class="mb-2">
                            <label class="col-form-label text-start text-color-1 fs-16 fw-medium">Interest(%)<span
                                    class="text-danger">*</span></label>
                            <div class="position-relative">
                                <input class="custom-form-control bg-transparent" type="text"
                                    name="interest_rate[]" required />
                                <span class="invest">%</span>
                            </div>
                        </div>
                        <div class="mb-2">
                            <label class="col-form-label text-start text-color-1 fs-16 fw-medium">Max
                                Locked Amount<span class="text-danger">*</span></label>
                            <input class="custom-form-control bg-transparent" type="text" name="max_value[]"
                                required />
                        </div>
                    </div>
                </div>
            `;

            $(".rates-section").append(ratesFields);
            if (currentRates === maxRates) {
                $(this).prop("disabled", true);
            }
        }
    });

    $(document).on("click", ".remove-rates", function () {
        currentRates--;
        $(this).closest(".row").remove();
    });

    const editMaxRates = 4;
    let editCurrentRates = 0;

    $(document).on("click", "#editNewRates", function (e) {
        e.preventDefault();

        if (editCurrentRates < editMaxRates) {
            editCurrentRates++;
            let ratesFields = `
                <div class="row mb-3">
                    <div class="align-items-center gap-2">
                        <button type="button"
                            class="btn btn-sm bg-soft-1 btn-sm p-sm-1 text-red white-space remove-rates float-end mb-1"><i class="fa fa-trash" aria-hidden="true"></i></button>
                        <hr class="my-2 divider-color w-100" />
                    </div>
                    <div class="col-12 col-lg-6">
                        <div class="mb-2">
                            <label class="col-form-label text-start text-color-1 fs-16 fw-medium">Duration (days)<span
                                    class="text-danger">*</span></label>
                            <input class="custom-form-control bg-transparent" type="text" name="duration[]"
                                required />
                        </div>
                        <div class="mb-2">
                            <label class="col-form-label text-start text-color-1 fs-16 fw-medium">Min
                                Locked Amount<span class="text-danger">*</span></label>
                            <input class="custom-form-control bg-transparent" type="text" name="min_value[]"
                                required />
                        </div>
                    </div>
                    <div class="col-12 col-lg-6">
                        <div class="mb-2">
                            <label class="col-form-label text-start text-color-1 fs-16 fw-medium">Interest(%)<span
                                    class="text-danger">*</span></label>
                            <div class="position-relative">
                                <input class="custom-form-control bg-transparent" type="text"
                                    name="interest_rate[]" required />
                                <span class="invest">%</span>
                            </div>
                        </div>
                        <div class="mb-2">
                            <label class="col-form-label text-start text-color-1 fs-16 fw-medium">Max
                                Locked Amount<span class="text-danger">*</span></label>
                            <input class="custom-form-control bg-transparent" type="text" name="max_value[]"
                                required />
                        </div>
                    </div>
                </div>
            `;

            $(".edit-rates-section").append(ratesFields);
            if (editCurrentRates === editMaxRates) {
                $(this).prop("disabled", true);
            }
        }
    });

    $(document).on("click", ".edit-remove-rates", function () {
        editCurrentRates--;
        $(this).closest(".row").remove();
    });
});

let showCallBackData = function () {
    $("#stake_form").trigger("reset");
    $("#stake_add_modal").modal("hide");
    $("#_edit_modal").modal("hide");
    $("#stake-table").DataTable().ajax.reload();
};

function subscriptionFilterData(elem, status) {
    var headerSelected = null;
    $(".nav-link.active").removeClass("active");
    $(elem).children("a").addClass("active");
    headerSelected = $(elem).data("si");

    $("#stake-subscription-table").on(
        "preXhr.dt",
        function (e, settings, data) {
            data.workStatus = headerSelected ? headerSelected : null;
            data.workSubStatus = null;
        }
    );
    $("#stake-subscription-table").DataTable().ajax.reload();
}
