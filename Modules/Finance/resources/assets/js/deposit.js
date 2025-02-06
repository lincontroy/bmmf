'use strict';

/*function printDiv(divId) {
    var div = document.getElementById(divId);
    if (div) {
        var printWindow = window.open('', '_blank');
        printWindow.document.write('<html><head><title>Print</title></head><body>');
        printWindow.document.write(div.innerHTML);
        printWindow.document.write('</body></html>');
        printWindow.document.close();
        printWindow.print();
    } else {
        console.error('Div with id ' + divId + ' not found.');
    }
}

$('.printContent').on('click', function (){
    printDiv('viewCreditDetails');
});*/


let showCallBackData = function () {
    $('#addCredit').modal('hide');
    $('#creadit-table').DataTable().ajax.reload();
    $('#credit-form')[0].reset();
};

$(document).on('click', '.deposit-confirm', function () {
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
                    //$(".dataTable").DataTable().ajax.reload();

                    let table = $('#deposit-table').DataTable();
                    let currentPage = table.page();
                    table.page(currentPage).draw('page');
                    table.clear().rows.add().draw();

                    success_alert(response.message, response.title);
                },
                error: function (response) {
                    let data = response.responseJSON;
                    error_alert(data.message, data.title);
                },
            });
        }
    });
});

$('body').on('change mouseout', '#user_id', function () {

    let action = $('#credit-form').attr('data-route');
    let userId = $(this).val();

    if (userId == '' || userId >= 0){
        return false;
    }
    $.ajax({
        url: action,
        beforeSend: function (xhr) {
            xhr.setRequestHeader(
                'X-CSRF-Token',
                $('meta[name="csrf-token"]').attr("content")
            );
        },
        type: 'POST',
        data: {
            user_id: userId,
        },
        dataType: 'json',
        success: function (res) {
            if (res.data != null) {
                $('.userId').text(res.message).addClass('text-success').css({'display': 'block'});
                $('.actionBtn').prop("disabled", false);
            } else {
                $('.userId').text(res.message).css({'display': 'block'});
                $('.actionBtn').prop('disabled', true);
            }
        },
        error: function (res) {
            var data = res.responseJSON;
            error_alert(data.message, data.title);
        },
    });
});

$('body').on('click', '.viewDetails', function () {

    let action = $(this).attr('data-action');

    $.ajax({
        url: action,
        beforeSend: function (xhr) {
            xhr.setRequestHeader(
                'X-CSRF-Token',
                $('meta[name="csrf-token"]').attr('content')
            );
        },
        type: 'GET',
        data: {},
        dataType: 'json',
        success: function (res) {

            $('#creditDetails').modal('show');
            $('.printContent').attr('data-id', res.data.details.id);
            $('#viewCreditDetails').html(res.data.info);
        },
        error: function (res) {
            var data = res.responseJSON;
            error_alert(data.message, data.title);
        },
    });
});
$('body').on('click', '.printContent', function () {

    let action = $(this).attr('print-url');
    let id = $(this).attr('data-id');

    $.ajax({
        url: action,
        beforeSend: function (xhr) {
            xhr.setRequestHeader(
                'X-CSRF-Token',
                $('meta[name="csrf-token"]').attr('content')
            );
        },
        type: 'POST',
        data: {
            'id': id,
        },
        dataType: 'json',
        success: function (res) {

        },
        error: function (res) {
            var data = res.responseJSON;
            error_alert(data.message, data.title);
        },
    });
});


