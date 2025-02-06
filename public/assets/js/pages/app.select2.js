$(document).ready(function () {
    "use strict";

    function formatOption(option) {
        if (!option.id) {
            return option.text;
        }
        var imageUrl = $(option.element).data("previewimage");
        var $option = option.text;
        if (imageUrl) {
            $option = $(
                `<span><img src="${imageUrl}"  style="width: 30px; height: 30px; margin-right: 10px;" />${option.text}</span>`
            );
        }
        return $option;
    }

    $(".basic-single").select2();
    $(".basic-multiple").select2();
    $(".placeholder-single").select2({
        placeholder: "Select option",
        allowClear: true,
        templateResult: formatOption,
        templateSelection: formatOption,
    });
    $(".placeholder-multiple").select2({
        placeholder: "Select option",
    });
    $(".theme-single").select2();
    $(".language").select2({
        language: "es",
    });
    $(".js-programmatic-enable").on("click", function () {
        $(".js-example-disabled").prop("disabled", false);
        $(".js-example-disabled-multi").prop("disabled", false);
    });
    $(".js-programmatic-disable").on("click", function () {
        $(".js-example-disabled").prop("disabled", true);
        $(".js-example-disabled-multi").prop("disabled", true);
    });
});
