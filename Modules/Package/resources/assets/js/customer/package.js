'use strict';

$('#quantity, #investAmt').on('keyup, change', function () {

    let quantity = +$('#quantity').val();
    let investAmt = +$('#investAmt').val();
    let totalInvestment = quantity * investAmt;

    if (quantity <= 0) {
        warning_alert('Please enter quantity!', 'Invest Quantity')
    }

    $('.chooseQuantity').text(quantity.toFixed(2));
    $('#chooseQuantity').val(quantity.toFixed(2));

    $('.investAmount').text(generatePrice(investAmt));
    $('#investAmount').val(investAmt);

    $('.totalInvestment').text(generatePrice(totalInvestment));
    $('#totalInvestment').val(totalInvestment);
});

function generatePrice(price) {
    return '$' + price.toFixed(2);
}

$('#investAmt').on('change', function () {

    let investAmt = +$(this).val();
    let investType = +$('#investType').val();
    let minPrice = +$('#minPrice').val();
    let maxPrice = +$('#maxPrice').val();

    if (investType == '1' && ((investAmt < minPrice) || (investAmt > maxPrice))) {
        $('#investAmt').val(minPrice);
        warning_alert('Please enter price between price range!', 'Invest Amount')
    }

});
