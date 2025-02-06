$(document).ready(function () {
    $(document)
        .find(".chat-list__in")
        .each(function () {
            const ps = new PerfectScrollbar($(this)[0]);
        });
    $(document)
        .find(".message-content-scroll")
        .each(function () {
            const ps = new PerfectScrollbar($(this)[0]);
        });
    $(document)
        .find(".chat-list__sidebar--right")
        .each(function () {
            const ps = new PerfectScrollbar($(this)[0]);
        });
    //emojionearea
    $(document).find(".emojionearea").emojioneArea({
        pickerPosition: "top",
        filtersPosition: "bottom",
        tones: false,
        autocomplete: false,
        inline: true,
        hidePickerOnBlur: false,
    });
    $('[data-bs-toggle="popover"]').popover({
        html: true,
        //                    trigger: 'focus'
    });
    $(document)
        .find(".change-bg-color label")
        .on("click", function () {
            var color = $(this).data("color");

            $(document)
                .find(".message-content")
                .each(function () {
                    $(this).removeClass(function (index, css) {
                        return (css.match(/(^|\s)bg-\S+/g) || []).join(" ");
                    });

                    $(this).addClass("bg-text-" + color);
                });
        });

    //Toggle Search
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
    $(document)
        .find(".close-search")
        .on("click", function () {
            $(document).find(".conversation-search").slideUp();
        });
    $(document)
        .find(".chat-overlay, .chat-list .item-list")
        .on("click", function () {
            $(document)
                .find(".chat-list__sidebar, .chat-list__sidebar--right")
                .removeClass("active");
            $(document).find(".chat-overlay").removeClass("active");
        });
    $(document)
        .find(".chat-sidebar-collapse")
        .on("click", function () {
            $(document).find(".chat-list__sidebar").addClass("active");
            $(document).find(".chat-overlay").addClass("active");
            $(document).find(".collapse.in").toggleClass("in");
        });
    $(document)
        .find(".chat-settings-collapse")
        .on("click", function () {
            $(document).find(".chat-list__sidebar--right").addClass("active");
            $(document).find(".chat-overlay").addClass("active");
            $(document).find(".collapse.in").toggleClass("in");
        });
});
