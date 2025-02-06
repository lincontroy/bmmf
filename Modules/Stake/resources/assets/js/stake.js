$(document).on("click", ".stake-buy", function () {
    let card = $(this).closest(".card");
    let activeTab = card.find(".stake-tab .nav-link.active");
    let rateID = activeTab.attr("data-rate-id");
    let dataAction = $(this).attr("data-action");
    dataAction += "?rate_id=" + rateID;

    $.ajax({
        url: dataAction,
        type: "GET",
        dataType: "html",
        success: function (res) {
            $(".stake-modal-content").html(res);
            $("#stakeBuyModal").modal("show");
        },
        error: function (response) {
            let data = response.responseJSON;
            error_alert(data.message, data.title);
        },
    });
});

$(document).ready(function () {
    $(document).on("keyup", "#locked_amount", function () {
        const lockedAmount = +$(this).val();
        const interestPercent = +$("#stakeInterestPercent").val();
        const minAmount = +$("#minAmount").val();
        const maxAmount = +$("#maxAmount").val();
        const stakeCurrency = $("#stakeCurrency").val();
        const walletBalance = +$("#walletBalance").val();

        $(".stake-now").attr("disabled", true);

        if (lockedAmount < minAmount) {
            $(".locked-error-msg").text(
                `Minimum locked amount is ${minAmount.toFixed(
                    6
                )} ${stakeCurrency}`
            );
            return;
        }
        if (lockedAmount > maxAmount) {
            $(".locked-error-msg").text(
                `Maximum locked amount is ${maxAmount.toFixed(
                    6
                )} ${stakeCurrency}`
            );
            return;
        }

        if (walletBalance < lockedAmount) {
            $(".locked-error-msg").text(`Insufficient Balance`);
            return;
        }

        $(".locked-error-msg").text(``);

        $(".stake-now").attr("disabled", false);

        $("#estimate_interest").html(
            (lockedAmount * (interestPercent / 100)).toFixed(6)
        );
    });
});
