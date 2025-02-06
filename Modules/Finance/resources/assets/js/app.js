$(document).ready(function () {
    const baseUrl = $('meta[name="base-url"]').attr("content");

    $("#payment_method").on("change", function () {
        const paymentMethod = $(this).val();
        axios
            .post(baseUrl + "/customer/ajax/request/currency", {
                gateway_id: paymentMethod,
            })
            .then(function (response) {
                if (response.data.status == "success") {
                    let htmlData = `<option value=''></option>`;
                    response.data.data.forEach((currency) => {
                        htmlData += `<option value="${currency.symbol}">${currency.name} (${currency.symbol})</option>`;
                    });
                    $("#payment_currency").html(htmlData);
                } else {
                    console.log("Something went wrong!");
                }
            })
            .catch(function (error) {
                console.log(error);
            });
    });

    $("#deposit_amount").on("blur", function () {
        fetchTxFee("Deposit", function (response) {
            let fees = 0;
            if (response.data.status == "success") {
                let feePercent = response.data.data.fee;
                if (feePercent > 0) {
                    fees = feePercent;
                }
            }

            if (fees > 0) {
                $(".fees").html(`Deposit Fees ${fees.toFixed(2)} %`);
            } else {
                $(".fees").html(``);
            }
        });
    });

    $("#transfer_amount").on("blur", function () {
        fetchTxFee("Transfer", function (response) {
            let transferAmount = $("#transfer_amount").val();
            let currency = $("#payment_currency").val();
            let fees = 0;
            if (response.data.status == "success") {
                let feePercent = response.data.data.fee;
                if (feePercent > 0) {
                    fees = transferAmount * (feePercent / 100);
                }
            }

            if (fees > 0) {
                $(".fees").html(
                    `Transfer Fee is ${fees.toFixed(6)} ${currency}`
                );
            } else {
                $(".fees").html(``);
            }
        });
    });

    $("#withdraw_amount").on("blur", function () {
        fetchTxFee("Withdraw", function (response) {
            let withdrawAmount = $("#withdraw_amount").val();
            let currency = $("#payment_currency").val();
            let fees = 0;
            if (response.data.status == "success") {
                let feePercent = response.data.data.fee;
                if (feePercent > 0) {
                    fees = withdrawAmount * (feePercent / 100);
                }
            }

            if (fees > 0) {
                $(".fees").html(
                    `Withdraw Fee is ${fees.toFixed(6)} ${currency}`
                );
            } else {
                $(".fees").html(``);
            }
        });
    });

    function fetchTxFee(txn_type, callBackFunc) {
        if (txn_type == "") return;

        axios
            .post(baseUrl + "/customer/ajax/request/fee", {
                txn_type,
            })
            .then(function (response) {
                callBackFunc(response);
            })
            .catch(function (error) {
                console.log(error);
            });
    }

    $("#receiver_user").on("blur", function () {
        const user = $(this).val();
        if (user == "") return;

        axios
            .post(baseUrl + "/customer/ajax/request/user", {
                user,
            })
            .then(function (response) {
                if (response.data.status == "success") {
                    $(".transfer-notify-msg").removeClass("text-danger");
                    $(".transfer-notify-msg").addClass("text-success");
                    $(".transfer-notify-msg").html(
                        `The recipient of the transfer is <b>${response.data.data.name}</b>`
                    );
                } else {
                    $(".transfer-notify-msg").removeClass("text-success");
                    $(".transfer-notify-msg").addClass("text-danger");
                    $(".transfer-notify-msg").html(response.data.message);
                }
            })
            .catch(function (error) {
                if (error.response.data.status == "error") {
                    $(".transfer-notify-msg").removeClass("text-success");
                    $(".transfer-notify-msg").addClass("text-danger");
                    let errorMsg = "<ul>";
                    error.response.data.errors.forEach((value) => {
                        errorMsg += `<li>${value}</li>`;
                    });
                    errorMsg += "</ul>";
                    $(".transfer-notify-msg").html(errorMsg);
                }
            });
    });

    const maxLabel = 3;
    let currentLabel = 0;

    $("#addNewElement").click(function (e) {
        e.preventDefault();

        if (currentLabel < maxLabel) {
            currentLabel++;
            let labelFields = `
            <div class="label-group">
                <div class="d-flex align-items-center gap-2 mb-3">
                    <hr class="my-2 divider-color w-100">
                    <button type="button"
                        class="btn btn-sm bg-soft-1 btn-sm p-sm-1 text-red white-space remove-label">Remove</button>
                    <hr class="my-2 divider-color w-100">
                </div>
                <div class="floating-form-group mb-4">
                    <label class="floating-form-label z-index-1">Credential Name<i class="text-danger">*</i></label>
                    <input class="floating-form-control" type="text" name="account_label[]" id="account_label[]" />
                </div>
                <div class="floating-form-group mb-4">
                    <label class="floating-form-label z-index-1">Credential Value<i class="text-danger">*</i></label>
                    <input class="floating-form-control" type="text" name="account_value[]" id="account_value[]" />
                </div>
            </div>
            `;

            $(".label-new-section").append(labelFields);

            if (currentLabel === maxLabel) {
                $(this).prop("disabled", true);
            }
        }
    });

    $(document).on("click", ".remove-label", function () {
        currentLabel--;
        $(this).closest(".label-group").remove();
        if (currentLabel < maxLabel) {
            $("#addNewElement").prop("disabled", false);
        }
    });

    $("#payment_currency").on("change", function () {
        const paymentCurrency = $(this).val();
        const paymentMethod = $("#payment_method").val();

        axios
            .post(baseUrl + "/customer/ajax/request/withdrawal/account", {
                gateway_id: paymentMethod,
                currency_symbol: paymentCurrency,
            })
            .then(function (response) {
                if (response.data.status == "success") {
                    let successMsg = `Your Withdrawal ${response.data.data[0].name} is ${response.data.data[0].credential}`;
                    $(".withdraw-notify-msg").removeClass("text-danger");
                    $(".withdraw-notify-msg").addClass("text-success");
                    $(".withdraw-notify-msg").html(successMsg);
                } else {
                    $(".withdraw-notify-msg").removeClass("text-success");
                    $(".withdraw-notify-msg").addClass("text-danger");
                    $(".withdraw-notify-msg").html(response.data.message);
                }
            })
            .catch(function (error) {
                if (error.response.data.status == "error") {
                    $(".withdraw-notify-msg").removeClass("text-success");
                    $(".withdraw-notify-msg").addClass("text-danger");
                    let errorMsg = "<ul>";
                    error.response.data.errors.forEach((value) => {
                        errorMsg += `<li>${value}</li>`;
                    });
                    errorMsg += "</ul>";
                    $(".withdraw-notify-msg").html(errorMsg);
                }
            });
    });
});
