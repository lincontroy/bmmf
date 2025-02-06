"use strict";

(function () {
    const baseUrl = $('meta[name="base-url"]').attr("content");
    let transactionChart = "";

    // Total Revenue Report btcChart Line Chart
    axios
        .get(baseUrl + "/customer/dashboard/txn/chart", {
            params: { txn_type: "deposit" },
        })
        .then(function (response) {
            if (response.data.status == "success") {
                const depositChartEl = document.querySelector("#depositChart"),
                    depositChartOptions = {
                        chart: {
                            height: 60,
                            toolbar: { show: false },
                            zoom: { enabled: false },
                            type: "line",
                        },
                        series: [
                            {
                                name: "Deposit",
                                data: response.data.data.chartYearData,
                            },
                        ],
                        stroke: {
                            curve: "smooth",
                            width: [2],
                        },
                        legend: {
                            show: false,
                        },
                        colors: ["#219653"],
                        grid: {
                            show: false,
                            padding: {
                                top: -30,
                                bottom: -15,
                                left: 25,
                            },
                        },
                        markers: {
                            size: 0,
                        },
                        xaxis: {
                            labels: {
                                show: false,
                            },
                            axisTicks: {
                                show: false,
                            },
                            axisBorder: {
                                show: false,
                            },
                            categories: response.data.data.abbreviateMonthNames,
                            tooltip: {
                                enabled: false,
                            },
                        },
                        yaxis: {
                            show: false,
                        },
                        tooltip: {
                            enabled: true,
                            y: {
                                formatter: function (value) {
                                    return "$" + value.toFixed(2);
                                },
                            },
                        },
                    };
                if (
                    typeof depositChartEl !== undefined &&
                    depositChartEl !== null
                ) {
                    const depositChart = new ApexCharts(
                        depositChartEl,
                        depositChartOptions
                    );
                    depositChart.render();
                }
            }
        })
        .catch(function (error) {
            console.log("Something went wrong: " + error);
        });

    axios
        .get(baseUrl + "/customer/dashboard/txn/chart", {
            params: { txn_type: "withdraw" },
        })
        .then(function (response) {
            if (response.data.status == "success") {
                const withdrawChartEl =
                        document.querySelector("#withdrawChart"),
                    withdrawChartOptions = {
                        chart: {
                            height: 60,
                            toolbar: { show: false },
                            zoom: { enabled: false },
                            type: "line",
                        },
                        series: [
                            {
                                name: "Withdraw",
                                data: response.data.data.chartYearData,
                            },
                        ],
                        stroke: {
                            curve: "smooth",

                            width: [2],
                        },
                        legend: {
                            show: false,
                        },
                        colors: ["#ff0000"],
                        grid: {
                            show: false,
                            padding: {
                                top: -30,
                                bottom: -15,
                                left: 25,
                            },
                        },
                        markers: {
                            size: 0,
                        },
                        xaxis: {
                            labels: {
                                show: false,
                            },
                            axisTicks: {
                                show: false,
                            },
                            axisBorder: {
                                show: false,
                            },
                            categories: response.data.data.abbreviateMonthNames,
                            tooltip: {
                                enabled: false,
                            },
                        },
                        yaxis: {
                            show: false,
                        },
                        tooltip: {
                            enabled: true,
                            y: {
                                formatter: function (value) {
                                    return "$" + value.toFixed(2);
                                },
                            },
                        },
                    };
                if (
                    typeof withdrawChartEl !== undefined &&
                    withdrawChartEl !== null
                ) {
                    const withdrawChart = new ApexCharts(
                        withdrawChartEl,
                        withdrawChartOptions
                    );
                    withdrawChart.render();
                }
            }
        })
        .catch(function (error) {
            console.log("Something went wrong: " + error);
        });

    // Total Revenue Report solChart Line Chart
    axios
        .get(baseUrl + "/customer/dashboard/txn/chart", {
            params: { txn_type: "transfer" },
        })
        .then(function (response) {
            if (response.data.status == "success") {
                const transferChartEl =
                        document.querySelector("#transferChart"),
                    transferChartOptions = {
                        chart: {
                            height: 60,
                            toolbar: { show: false },
                            zoom: { enabled: false },
                            type: "line",
                        },
                        series: [
                            {
                                name: "Transfer",
                                data: response.data.data.chartYearData,
                            },
                        ],
                        stroke: {
                            curve: "smooth",

                            width: [2],
                        },
                        legend: {
                            show: false,
                        },
                        colors: ["#9181db"],
                        grid: {
                            show: false,
                            padding: {
                                top: -30,
                                bottom: -15,
                                left: 25,
                            },
                        },
                        markers: {
                            size: 0,
                        },
                        xaxis: {
                            labels: {
                                show: false,
                            },
                            axisTicks: {
                                show: false,
                            },
                            axisBorder: {
                                show: false,
                            },
                            categories: response.data.data.abbreviateMonthNames,
                            tooltip: {
                                enabled: false,
                            },
                        },
                        yaxis: {
                            show: false,
                        },
                        tooltip: {
                            enabled: true,
                            y: {
                                formatter: function (value) {
                                    return "$" + value.toFixed(2);
                                },
                            },
                        },
                    };
                if (
                    typeof transferChartEl !== undefined &&
                    transferChartEl !== null
                ) {
                    const transferChart = new ApexCharts(
                        transferChartEl,
                        transferChartOptions
                    );
                    transferChart.render();
                }
            }
        })
        .catch(function (error) {
            console.log("Something went wrong: " + error);
        });

    // Total Revenue Report solChart Line Chart
    axios
        .get(baseUrl + "/customer/dashboard/investment/chart", {
            params: { txn_type: "investment" },
        })
        .then(function (response) {
            if (response.data.status == "success") {
                const transferChartEl =
                        document.querySelector("#investmentChart"),
                    transferChartOptions = {
                        chart: {
                            height: 60,
                            toolbar: { show: false },
                            zoom: { enabled: false },
                            type: "line",
                        },
                        series: [
                            {
                                name: "Investment",
                                data: response.data.data.chartYearData,
                            },
                        ],
                        stroke: {
                            curve: "smooth",

                            width: [2],
                        },
                        legend: {
                            show: false,
                        },
                        colors: ["#0060ff"],
                        grid: {
                            show: false,
                            padding: {
                                top: -30,
                                bottom: -15,
                                left: 25,
                            },
                        },
                        markers: {
                            size: 0,
                        },
                        xaxis: {
                            labels: {
                                show: false,
                            },
                            axisTicks: {
                                show: false,
                            },
                            axisBorder: {
                                show: false,
                            },
                            categories: response.data.data.abbreviateMonthNames,
                            tooltip: {
                                enabled: false,
                            },
                        },
                        yaxis: {
                            show: false,
                        },
                        tooltip: {
                            enabled: true,
                            y: {
                                formatter: function (value) {
                                    return "$" + value.toFixed(2);
                                },
                            },
                        },
                    };
                if (
                    typeof transferChartEl !== undefined &&
                    transferChartEl !== null
                ) {
                    const transferChart = new ApexCharts(
                        transferChartEl,
                        transferChartOptions
                    );
                    transferChart.render();
                }
            }
        })
        .catch(function (error) {
            console.log("Something went wrong: " + error);
        });

    // Total Payout Report solChart Line Chart
    axios
        .get(baseUrl + "/customer/dashboard/payout/chart", {
            params: { txn_type: "payout" },
        })
        .then(function (response) {
            if (response.data.status == "success") {
                const transferChartEl = document.querySelector("#payoutChart"),
                    transferChartOptions = {
                        chart: {
                            height: 60,
                            toolbar: { show: false },
                            zoom: { enabled: false },
                            type: "line",
                        },
                        series: [
                            {
                                name: "Payout",
                                data: response.data.data.chartYearData,
                            },
                        ],
                        stroke: {
                            curve: "smooth",

                            width: [2],
                        },
                        legend: {
                            show: false,
                        },
                        colors: ["#ffd2d2"],
                        grid: {
                            show: false,
                            padding: {
                                top: -30,
                                bottom: -15,
                                left: 25,
                            },
                        },
                        markers: {
                            size: 0,
                        },
                        xaxis: {
                            labels: {
                                show: false,
                            },
                            axisTicks: {
                                show: false,
                            },
                            axisBorder: {
                                show: false,
                            },
                            categories: response.data.data.abbreviateMonthNames,
                            tooltip: {
                                enabled: false,
                            },
                        },
                        yaxis: {
                            show: false,
                        },
                        tooltip: {
                            enabled: true,
                            y: {
                                formatter: function (value) {
                                    return "$" + value.toFixed(2);
                                },
                            },
                        },
                    };
                if (
                    typeof transferChartEl !== undefined &&
                    transferChartEl !== null
                ) {
                    const transferChart = new ApexCharts(
                        transferChartEl,
                        transferChartOptions
                    );
                    transferChart.render();
                }
            }
        })
        .catch(function (error) {
            console.log("Something went wrong: " + error);
        });

    // Total Team Turnover Report solChart Line Chart
    axios
        .get(baseUrl + "/customer/dashboard/teamTurnOver/chart", {
            params: { txn_type: "team-turnover" },
        })
        .then(function (response) {
            if (response.data.status == "success") {
                const transferChartEl =
                        document.querySelector("#teamTurnOverChart"),
                    transferChartOptions = {
                        chart: {
                            height: 60,
                            toolbar: { show: false },
                            zoom: { enabled: false },
                            type: "line",
                        },
                        series: [
                            {
                                name: "team-turnover",
                                data: response.data.data.chartYearData,
                            },
                        ],
                        stroke: {
                            curve: "smooth",

                            width: [2],
                        },
                        legend: {
                            show: false,
                        },
                        colors: ["#ffb849"],
                        grid: {
                            show: false,
                            padding: {
                                top: -30,
                                bottom: -15,
                                left: 25,
                            },
                        },
                        markers: {
                            size: 0,
                        },
                        xaxis: {
                            labels: {
                                show: false,
                            },
                            axisTicks: {
                                show: false,
                            },
                            axisBorder: {
                                show: false,
                            },
                            categories: response.data.data.abbreviateMonthNames,
                            tooltip: {
                                enabled: false,
                            },
                        },
                        yaxis: {
                            show: false,
                        },
                        tooltip: {
                            enabled: true,
                            y: {
                                formatter: function (value) {
                                    return "$" + value.toFixed(2);
                                },
                            },
                        },
                    };
                if (
                    typeof transferChartEl !== undefined &&
                    transferChartEl !== null
                ) {
                    const transferChart = new ApexCharts(
                        transferChartEl,
                        transferChartOptions
                    );
                    transferChart.render();
                }
            }
        })
        .catch(function (error) {
            console.log("Something went wrong: " + error);
        });
    // Total Team Turnover Report solChart Line Chart
    axios
        .get(baseUrl + "/customer/dashboard/sponsorTurnover/chart", {
            params: { txn_type: "sponsor-turnover" },
        })
        .then(function (response) {
            if (response.data.status == "success") {
                const transferChartEl = document.querySelector(
                        "#sponsorTurnoverChart"
                    ),
                    transferChartOptions = {
                        chart: {
                            height: 60,
                            toolbar: { show: false },
                            zoom: { enabled: false },
                            type: "line",
                        },
                        series: [
                            {
                                name: "sponsor-turnover",
                                data: response.data.data.chartYearData,
                            },
                        ],
                        stroke: {
                            curve: "smooth",

                            width: [2],
                        },
                        legend: {
                            show: false,
                        },
                        colors: ["#9181db"],
                        grid: {
                            show: false,
                            padding: {
                                top: -30,
                                bottom: -15,
                                left: 25,
                            },
                        },
                        markers: {
                            size: 0,
                        },
                        xaxis: {
                            labels: {
                                show: false,
                            },
                            axisTicks: {
                                show: false,
                            },
                            axisBorder: {
                                show: false,
                            },
                            categories: response.data.data.abbreviateMonthNames,
                            tooltip: {
                                enabled: false,
                            },
                        },
                        yaxis: {
                            show: false,
                        },
                        tooltip: {
                            enabled: true,
                            y: {
                                formatter: function (value) {
                                    return "$" + value.toFixed(2);
                                },
                            },
                        },
                    };
                if (
                    typeof transferChartEl !== undefined &&
                    transferChartEl !== null
                ) {
                    const transferChart = new ApexCharts(
                        transferChartEl,
                        transferChartOptions
                    );
                    transferChart.render();
                }
            }
        })
        .catch(function (error) {
            console.log("Something went wrong: " + error);
        });

    /* Brand Slider Start */
    let isRTL = $("html").attr("dir") === "rtl";
    $(".stake-slider").slick({
        slidesToShow: 4,
        rtl: isRTL,
        slidesToScroll: 1,
        autoplay: false,
        adaptiveHeight: true,
        loop: true,
        dots: true,
        arrows:false,
        responsive: [
            {
                breakpoint: 1399,
                settings: {
                    slidesToShow: 5,
                    slidesToScroll: 1,
                    infinite: true,
                },
            },
            {
                breakpoint: 1199,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 1,
                    infinite: true,
                },
            },
            {
                breakpoint: 768,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 1,
                },
            },
            {
                breakpoint: 520,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1,
                },
            },
        ],
    });
    /* //Brand Slider End */
    /* Brand Slider Start */
    $(".investment-slider").slick({
        slidesToShow: 4,
        rtl: isRTL,
        slidesToScroll: 1,
        autoplay: false,
        loop: true,
        dots: true,
        arrows:false,
        responsive: [
            {
                breakpoint: 1399,
                settings: {
                    slidesToShow: 5,
                    slidesToScroll: 1,
                    infinite: true,
                },
            },
            {
                breakpoint: 1199,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 1,
                    infinite: true,
                },
            },
            {
                breakpoint: 768,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 1,
                },
            },
            {
                breakpoint: 520,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1,
                },
            },
        ],
    });
    /* //Brand Slider End */
})();
