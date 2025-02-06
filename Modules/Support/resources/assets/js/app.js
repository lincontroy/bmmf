let showCallBackData = function () {
    $(document).find('#msg_body').val('');
}

$(document).ready(function () {
    $('.chat-list').find('.user-wise_message').first().trigger('click');
});

$(document)
    .find(".chat-title")
    .each(function () {
        $(document)
            .find(".search-btn", this)
            .on("click", function (e) {
                e.preventDefault();
                $(document).find(".conversation-search").slideToggle();
            });
    });

$(document).on('click', '.user-wise_message', function () {

    let action = $(this).attr('data-action');
    let _token = $('input[name="_token"]').val();
    let id = $(this).attr('data-id');
    console.log({id});
    $('body').find('#message_user_id').val(id);

    $.ajax({
        method: "GET",
        url: action,
        processData: false,
        contentType: false,
        cache: false,
        dataType: "html",
        async: false,
        data: {
            _token: _token,
            id: id,
        },
        success: function (res) {

            $('#showMessageContent').empty();
            $('#showMessageContent').html(res);

        },
        error: function (res) {
        },
    });
});

$('body').on('click', '#sentMessage', function () {
    let actionUrl = $('body').find('#message-form').attr('data-insert');
    let message_body = $('body').find('#msg_body').val();
    let messageUserId = $('body').find('#message_user_id').val();
    let _token = $('input[name="_token"]').val();

    if (message_body == '') {
        warning_alert('Please Enter Message', 'Support');
        return false;
    }

    $.ajax({
        method: "POST",
        url: actionUrl,
        dataType: "json",
        data: {
            message: message_body,
            userid: messageUserId,
            _token: _token,
        },
        success: function (res) {
            
            if (res.type == 'send-message') {

                $('.chat-list').find('.returnData_' + messageUserId).trigger('click');
            }
        },
        error: function (res) {

        },
    });
});

$('body').on('keyup', '#search_box', function () {
    let actionUrl = $(this).attr('data-action');
    let search_box = $(this).val();
    let _token = $('input[name="_token"]').val();

    $.ajax({
        method: "GET",
        url: actionUrl,
        dataType: "html",
        data: {
            userid: search_box,
            _token: _token,
        },
        success: function (res) {
            $('.chat-list').empty();
            $('.chat-list').html(res);
        },
        error: function (res) {

        },
    });
});

$('body').on('keypress', '#msg_body', function (event) {
    if (event.keyCode === 13) {
        $('body').find('#sentMessage').trigger('click');
    }
});

// Use event delegation to handle scroll events on the body
$('body').on('scroll', '.message-content-scroll', function (event) {
    var $scrollableElement = $(event.target).closest('.message-content-scroll');

    // Calculate the scroll position for the specific scrollable element
    var scrollTop = $scrollableElement.scrollTop();
    var scrollHeight = $scrollableElement.prop('scrollHeight');
    var windowHeight = $scrollableElement.height();

    console.log("windowHeight", windowHeight);

    // Check if scroll position is near the bottom
    if (scrollTop + windowHeight >= scrollHeight) {
        // Perform AJAX request here
        $.ajax({
            url: 'your-ajax-endpoint-url',
            type: 'GET',
            data: {
                // Include any additional data needed for the request
            },
            success: function (response) {
                // Handle the AJAX response
            },
            error: function (xhr, status, error) {
                // Handle any errors
            }
        });
    }
});

$(document).ready(function () {
    $('#checkIdentify').scroll(function () {

        let loading = false;

        let container = $('.nav.chat-list');
        let scrollPosition = container.scrollTop();
        let containerHeight = container.outerHeight();
        let contentHeight = container[0].scrollHeight;
        let actionUrl = $('#onload_url').val();
        let _token = $('input[name="_token"]').val();
        let pageNo = +$('#page_increment').val();

        if (((scrollPosition + containerHeight) >= contentHeight) && !loading) {
            loading = true;
            $.ajax({
                method: "GET",
                url: actionUrl,
                dataType: "html",
                data: {
                    pageNo: pageNo,
                    _token: _token,
                },
                success: function (res) {
                    $('.chat-list').append(res);
                    $('#page_increment').val(pageNo+1);
                    console.log('--------------------',res);
                },
                error: function (res) {

                },
            });

            container[0].scrollHeight = scrollPosition + containerHeight;
        }
    });
});


