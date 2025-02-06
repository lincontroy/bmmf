'use strict';

$(document).on('click', '.changeStatus', function () {
    let action = $(this).attr('data-action');
    let actionType = $(this).attr('action-type');
    let title = 'Do you want to confirm?';
    if (actionType === 'reject') {
        title = 'Do you want to reject?';
    } else if(actionType === 'suspend') {
        title = 'Do you want to suspend?';
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
                },
                error: function (response) {
                    let data = response.responseJSON;
                    error_alert(data.message, data.title);
                },
            });
        }
    });
});
