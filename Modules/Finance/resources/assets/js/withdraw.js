'use strict';

$(document).on('click', '.withdraw-confirm', function () {
    let action = $(this).attr('data-action');
    let actionType = $(this).attr('action-type');
    let title  = 'Do you want to confirm?';
    if(actionType === 'cancel'){
        title  = 'Do you want to cancel?';
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
                        $('meta[name="csrf-token"]').attr("content")
                    );
                },
                type: 'PUT',
                data: {},
                dataType: 'json',
                success: function (response) {
                    $('.dataTable').DataTable().ajax.reload();
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

$('body').on('click', '.userInfo', function () {

    let action = $(this).attr('data-action');
    let id = $(this).attr('data-id');

    console.log({id})

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
            id: id,
        },
        dataType: 'json',
        success: function (res) {
            $('#name').text(res.data.first_name+' '+res.data.last_name);
            $('#email').text(res.data.email);
            $('#phone').text(res.data.phone);
            $('#user_id').text(res.data.user_id);

            if (res.data.withdrawMethod != null) {
                let credentails = res.data.withdrawMethod.credentials;
                let html = `<div class="border p-2 mt-3 radius-10 border-gray">
                <h3 class="border-bottom d-flex fs-20 justify-content-center m-auto w-max-content">Withdrawal Account</h3>
                <table><tbody>
                    <tr>
                        <th>Payment Method</th>
                        <td class="px-2">:</td>
                        <td>${res.data.withdrawMethod.gateway.name}</td>
                    </tr>`
                credentails.forEach(function (item, index) {
                    html += `<tr>
                        <th>${item.name}</th>
                        <td class="px-2">:</td>
                        <td>${item.credential}</td>
                    </tr>`
                });
                html += "</tbody></table></div>"
                $('.payoutInfo').html(html);
            }

            $('#userInfo').modal('show');
        },
        error: function (res) {
            var data = res.responseJSON;
            error_alert(data.message, data.title);
        },
    });
});
