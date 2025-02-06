'use strict';

$(document).on('click', '.changeStatus', function () {
    let action = $(this).attr('data-action');
    let actionType = $(this).attr('action-type');
    let title = 'Do you want to confirm?';
    if (actionType === 'cancel') {
        title = 'Do you want to cancel?';
    }

    Swal.fire({
        title: title,
        confirmButtonText: 'Yes',
        showDenyButton: true,
        denyButtonText: 'No',
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: action,
                beforeSend: function (xhr) {
                    xhr.setRequestHeader(
                        'X-CSRF-Token',
                        $('meta[name="csrf-token"]').attr('content')
                    );
                },
                type: "PUT",
                data: {},
                dataType: "json",
                success: function (response) {
                    $(".dataTable").DataTable().ajax.reload();
                    success_alert(response.message, response.title);

                    if(response.status === '1'){
                        $('.totalComplete').parent().parent().parent('.allTab').trigger('click');
                    } else if(response.status === '2'){
                        $('.totalPending').parent().parent().parent('.allTab').trigger('click');
                    } else {
                        $('.totalCanceled').parent().parent().parent('.allTab').trigger('click');
                    }
                },
                error: function (response) {
                    let data = response.responseJSON;
                    error_alert(data.message, data.title);
                },
            });
        }
    });
});

function statusWisePaymentTransaction(elem, status) {
    var headerSelected = null;
    $('.allTab').children('a').removeClass('active');
    $(elem).children('a').addClass('active');

    var url = $(elem).data('route');

    headerSelected = $(elem).data('si');
    // console.log(headerSelected);

    $("#merchant-payment-info-table").on(
        'preXhr.dt',
        function (e, settings, data) {
            data.workStatus = headerSelected ? headerSelected : null;
            data.workSubStatus = null;
        }
    );

   $("#merchant-payment-info-table").DataTable().ajax.reload();

    countRows(url);

}

function countRows(url){

    $.ajax({
        url: url,
        beforeSend: function (xhr) {
            xhr.setRequestHeader(
                'X-CSRF-Token',
                $('meta[name="csrf-token"]').attr('content')
            );
        },
        type: "GET",
        data: {},
        dataType: "json",
        success: function (res) {
            if(res.status === 'all'){
                $('.totalCount').html(res.countRows);
            } else if(res.status === "2"){
                $('.totalPending').html(res.countRows);
            } else if(res.status === "1"){
                $('.totalComplete').html(res.countRows);
            } else {
                $('.totalCanceled').html(res.countRows);
            }
        }
    });
}


function copyToClipboard(text) {
    // Create a temporary textarea element
    var textarea = document.createElement("textarea");

    // Set the text to be copied to the textarea
    textarea.value = text;

    // Append the textarea to the document
    document.body.appendChild(textarea);

    // Select the text inside the textarea
    textarea.select();

    // Execute the copy command
    document.execCommand("copy");

    // Remove the textarea from the document
    document.body.removeChild(textarea);
}

// Example usage
$('body').on('click', '.copy', function (){
    let text = $(this).parent('td').children('.transactionHash').html();
    copyToClipboard(text);
    success_alert('Address copyied successfull', 'Copy');
});
