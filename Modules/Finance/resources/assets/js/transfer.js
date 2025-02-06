'use strict';

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
            'id':id,
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


