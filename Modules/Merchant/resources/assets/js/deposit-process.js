"use strict";

var expired_time = $("#timeout").attr("data-datevalue");
var countDownDate = new Date(expired_time).getTime();
var x = setInterval(function () {
    var now = new Date().getTime();
    var distance = countDownDate - now;
    var hours = Math.floor(
        (distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60)
    );
    var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
    var seconds = Math.floor((distance % (1000 * 60)) / 1000);

    document.getElementById("timeout").innerHTML =
        hours + ":" + minutes + ":" + seconds;

    if (distance < 0) {
        clearInterval(x);
        document.getElementById("timeout").innerHTML = "EXPIRED";
    }
}, 1000);
