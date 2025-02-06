/* jshint esversion: 6 */
'use strict';

let showCallBackData = function (res) {
    $(document).find('#checker_note').val('');
    $(document).find('#confirmation_message').modal('hide');
    $(document).find('#confirmation_message').find('.actionBtn').text('Submit');

    if (res.segment == 'loan') {

        let table = $('#b2x-loan-table').DataTable();
        let currentPage = table.page();
        table.page(currentPage).draw('page');
        table.clear().rows.add().draw();

    } else {

        let table = $('#b2x-loan-pending-withdraw-table').DataTable();
        let currentPage = table.page();
        table.page(currentPage).draw('page');
        table.clear().rows.add().draw();
    }

};

$(document).on("click", ".resetBtn", function (e) {
    $(document).find('#confirmation_message').find('#checker_note').val('');
});

$(document).on('click', '.changeWithdrawStatus', function () {

    let action = $(this).attr('data-action');
    let actionType = $(this).attr('title');

    $(document).find('#confirmation_message').modal('show');
    $(document).find('#confirmation_message').find('action').modal('show');
    $(document).find('#confirmation_message').find('action').modal('show');
    $(document).find('#confirmation_message').find('.actionBtn').text(actionType);
    $(document).find('#confirmation_message').find("#b2x-loan-confirm-form").attr('action', $(this).attr('data-action'));

});

$(document).on('click', '.changeStatus', function () {
    let actionType = $(this).attr('title');
    $(document).find('#confirmation_message').modal('show');
    $(document).find('#confirmation_message').find('action').modal('show');
    $(document).find('#confirmation_message').find('action').modal('show');
    $(document).find('#confirmation_message').find('.actionBtn').text(actionType);
    $(document).find('#confirmation_message').find("#b2x-loan-confirm-form").attr('action', $(this).attr('data-action'));
});


$('body').on('click', '.userInfo', function () {

    let action = $(this).attr('data-action');
    let userId = $(this).attr('data-id');
    let loanId = $(this).attr('data-loan-id');

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
            loanId: loanId,
        },
        dataType: 'json',
        success: function (res) {

            $('#name').text(res.data.first_name + ' ' + res.data.last_name);
            $('#email').text(res.data.email);
            $('#phone').text(res.data.phone);
            $('#user_id').text(res.data.user_id);

            if (res.data.payoutInfo != null) {
                let credentails = res.data.payoutInfo.credentials;
                let html = `<div class="border p-2 mt-3 radius-10 border-gray">
                <h3 class="border-bottom d-flex fs-20 justify-content-center m-auto w-max-content">Payout Account</h3><table><tbody><tr>
                        <td class="px-2"><strong>Payment Method:</strong></td>
                        <td class="px-2">${res.data.payoutInfo.gateway.name}</td>
                    </tr>`
                credentails.forEach(function (item, index) {
                    console.log(item.name);
                    console.log({index});
                    html += `<tr>
                        <td class="px-2"><strong>${item.name}: </strong></td>
                        <td class="px-2">${item.credential}</td>
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
