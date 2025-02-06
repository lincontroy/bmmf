let showCallBackData = function () {
    $('#holding_amount').val(1);
};

let baseUrl = $('meta[name="base-url"]').attr("content");

$(document).ready(function () {
    let holdAmount = $('#holding_amount').val();

    $('#holding_amount').val(holdAmount).trigger('change');
})

$('#holding_amount, #package_month').on('change keyup', function () {

    let url = $('#package_month').attr('data-url');
    let holdingAmount = $('#holding_amount').val();
    let packageMonth = $('#package_month').val();
    let loanAmount = holdingAmount / 2;
    let finalWallet = +holdingAmount + +loanAmount;

    if (holdingAmount != '') {
        $('#holding_amount_error').html('');
        $('body').find(".actionBtn").prop("disabled", false);
    } else {
        $('body').find(".actionBtn").prop("disabled", true);
    }
    if (packageMonth != '') {
        $('#package_month_error').html('');
        $('body').find(".actionBtn").prop("disabled", false);
    } else {
        $('body').find(".actionBtn").prop("disabled", true);
    }
    $.ajax({
        url: url,
        beforeSend: function (xhr) {
            xhr.setRequestHeader(
                'X-CSRF-Token',
                $('meta[name="csrf-token"]').attr("content")
            );
        },
        type: 'POST',
        data: {
            holding_amount: holdingAmount,
            package_month: packageMonth,
        },
        dataType: 'json',
        success: function (res) {
            $('#calcualations').empty();
            $('#calcualations').html(res.content);

            $('#btcBalance').val(finalWallet.toFixed(6));
        },
        error: function (error) {
            $('body').find(".actionBtn").prop("disabled", true);
            if (error.status === 422) {
                $('#b2x-loan-package-form' + ' div[id$="_error"]').html("");
                let errors = error.responseJSON.message
                for (const key in errors) {
                    $('#b2x-loan-package-form' + ' #' + key + '_error').html(errors[key][0]);
                }

            }
        },
    });
});


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

$("#payment_method").on("change", function () {
    const paymentMethod = $(this).val();
    axios
        .post("customer-withdraw-account", {
            payment_gateway_id: paymentMethod,
        })
        .then(function (res) {
            if (res.data.data === null) {
                $('#payment_method_error').text('');
                $('.accountNotFound').removeClass('d-none');
                $('#payment_currency').empty();
                $("#withdrawRequestButton").prop("disabled", true);
            } else {
                $('.accountNotFound').addClass('d-none');
                $('#payment_method_error').addClass('text-success').text('Your withdraw account is ' + res.data.data.credentials[0].credential);
                $("#withdrawRequestButton").prop("disabled", false);
            }
        })
        .catch(function (error) {
            console.log(error);
        });
});

$('body').on('click', '.withdrawRequest', function () {
    let loanId = $(this).attr('data-id');
    $('#loanId').val(loanId);
    $('body').find('#withdrawRequest').modal('show');
});

$('body').on('click', '#withdrawRequestButton', function () {

    let url = $('#withdraw-request-form').attr('action');
    let payment_method = $('#payment_method').val();
    let payment_currency = $('#payment_currency').val();
    let loanId = $('#loanId').val();

    if (payment_method != '') {
        $('#payment_method_error').html('');
    }
    if (payment_currency != '') {
        $('#payment_currency_error').html('');
    }

    $.ajax({
        url: url,
        beforeSend: function (xhr) {
            xhr.setRequestHeader(
                'X-CSRF-Token',
                $('meta[name="csrf-token"]').attr("content")
            );
        },
        type: 'POST',
        data: {
            payment_method: payment_method,
            payment_currency: payment_currency,
            loanId: loanId,
        },
        dataType: 'json',
        success: function (res) {
            $('body').find('#withdrawRequest').modal('hide');
            if (res.success === true) {
                success_alert(res.message, res.title);
                $("#my-loans-table").DataTable().ajax.reload();
            } else {
                error_alert(res.message, res.title);
            }
        },
        error: function (error) {
            if (error.status === 422) {
                $('#withdraw-request-form' + ' div[id$="_error"]').html("");
                let errors = error.responseJSON.message
                for (const key in errors) {
                    $('#withdraw-request-form' + ' #' + key + '_error').html(errors[key][0]);
                }

            }
        },
    });
});
