/* jshint esversion: 6 */
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
                type: 'PUT',
                data: {},
                dataType: 'json',
                success: function (res) {

                    let table = $('#merchant-withdraw-table').DataTable();
                    let currentPage = table.page();
                    table.page(currentPage).draw('page');
                    table.clear().rows.add().draw();
                    success_alert(res.message, res.title);
                },
                error: function (response) {
                    let data = response.responseJSON;
                    error_alert(data.message, data.title);
                },
            });
        }
    });
});

$('body').on('click', '.userInfo', function () {

    let action = $(this).attr('data-action');
    let userId = $(this).attr('data-id');

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
            $('#name').text(res.data.first_name + ' ' + res.data.last_name);
            $('#email').text(res.data.email);
            $('#phone').text(res.data.phone);
            $('#user_id').text(res.data.user_id);
            $('#userInfo').modal('show');
        },
        error: function (res) {
            var data = res.responseJSON;
            error_alert(data.message, data.title);
        },
    });
});
