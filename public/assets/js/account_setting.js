"use strict";

let showCallBackData = function (response) {
    var data = response.data;
    var previewFaviconDiv = $("#image").attr("data-previewDiv");
    if (
        data.image &&
        data.image_url &&
        data.image_url.length &&
        previewFaviconDiv.length
    ) {
        $("#" + previewFaviconDiv).html(
            '<img src="' + data.image_url + '" class="preview_image" />'
        );
    }
};
