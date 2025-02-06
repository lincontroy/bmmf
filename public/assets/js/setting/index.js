'use strict';

var showCallBackData = function(response) {
    var data = response.data;
    var previewLogoDiv = $("#logo").attr("data-previewDiv");
    var previewFaviconDiv = $("#favicon").attr("data-previewDiv");


    if(data.logo_url && data.logo_url.length && previewLogoDiv.length){
        $("#" + previewLogoDiv).html('<img src="'+data.logo_url+'" class="preview_image" />');
    }

    if(data.favicon_url && data.favicon_url.length && previewFaviconDiv.length){
        $("#" + previewFaviconDiv).html('<img src="'+data.favicon_url+'" class="preview_image" />');
    }
}
