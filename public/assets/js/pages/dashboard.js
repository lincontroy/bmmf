("use strict");

(function () {
    const baseUrl = $('meta[name="base-url"]').attr("content");
    let transactionChart = "";

    axios
        .get(baseUrl + "/admin/dashboard/customer/chart/data")
        .then(function (response) {
            if (response.data.status == "success") {
                // Total Revenue Report customerChart Line Chart
                const customerChartEl =
                        document.querySelector("#customerChart"),
                    customerChartOptions = {
                        chart: {
                            height: 60,
                            toolbar: { show: false },
                            zoom: { enabled: false },
                            type: "line",
                        },
                        series: [
                            {
                                name: "Customers",
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
                        },
                    };
                if (
                    typeof customerChartEl !== undefined &&
                    customerChartEl !== null
                ) {
                    const customerChart = new ApexCharts(
                        customerChartEl,
                        customerChartOptions
                    );
                    customerChart.render();
                }
            }
        })
        .catch(function (error) {
            console.log("Something went wrong: " + error);
        });

    axios
        .get(baseUrl + "/admin/dashboard/txn/chart", {
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
        .get(baseUrl + "/admin/dashboard/txn/chart", {
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

    axios
        .get(baseUrl + "/admin/dashboard/txn/chart", {
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

    axios
        .get(baseUrl + "/admin/investment/chart")
        .then(function (response) {
            if (response.data.status == "success") {
                const investmentChartEl =
                        document.querySelector("#investmentChart"),
                    investmentChartOptions = {
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
                    typeof investmentChartEl !== undefined &&
                    investmentChartEl !== null
                ) {
                    const investmentChart = new ApexCharts(
                        investmentChartEl,
                        investmentChartOptions
                    );
                    investmentChart.render();
                }
            }
        })
        .catch(function (error) {
            console.log("Something went wrong: " + error);
        });

    axios
        .get(baseUrl + "/admin/dashboard/txn/fee/chart", {
            params: { txn_type: "deposit" },
        })
        .then(function (response) {
            if (response.data.status == "success") {
                const depositFeesChartEl =
                        document.querySelector("#depositFeesChart"),
                    depositFeesChartOptions = {
                        chart: {
                            height: 60,
                            toolbar: { show: false },
                            zoom: { enabled: false },
                            type: "line",
                        },
                        series: [
                            {
                                name: "Deposit Fee",
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
                        colors: ["#F0C98C"],
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
                    typeof depositFeesChartEl !== undefined &&
                    depositFeesChartEl !== null
                ) {
                    const depositFeesChart = new ApexCharts(
                        depositFeesChartEl,
                        depositFeesChartOptions
                    );
                    depositFeesChart.render();
                }
            }
        })
        .catch(function (error) {
            console.log("Something went wrong: " + error);
        });

    axios
        .get(baseUrl + "/admin/dashboard/txn/fee/chart", {
            params: { txn_type: "withdraw" },
        })
        .then(function (response) {
            if (response.data.status == "success") {
                const withdrawFeesChartEl =
                        document.querySelector("#withdrawFeesChart"),
                    withdrawFeesChartOptions = {
                        chart: {
                            height: 60,
                            toolbar: { show: false },
                            zoom: { enabled: false },
                            type: "line",
                        },
                        series: [
                            {
                                name: "Withdraw Fee",
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
                        colors: ["#9181DB"],
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
                    typeof withdrawFeesChartEl !== undefined &&
                    withdrawFeesChartEl !== null
                ) {
                    const withdrawFeesChart = new ApexCharts(
                        withdrawFeesChartEl,
                        withdrawFeesChartOptions
                    );
                    withdrawFeesChart.render();
                }
            }
        })
        .catch(function (error) {
            console.log("Something went wrong: " + error);
        });

    axios
        .get(baseUrl + "/admin/dashboard/txn/fee/chart", {
            params: { txn_type: "transfer" },
        })
        .then(function (response) {
            if (response.data.status == "success") {
                const transferFeesChartEl =
                        document.querySelector("#transferFeesChart"),
                    transferFeesChartOptions = {
                        chart: {
                            height: 60,
                            toolbar: { show: false },
                            zoom: { enabled: false },
                            type: "line",
                        },
                        series: [
                            {
                                name: "Transfer Fee",
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
                        colors: ["#F0A0A0"],
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
                    typeof transferFeesChartEl !== undefined &&
                    transferFeesChartEl !== null
                ) {
                    const transferFeesChart = new ApexCharts(
                        transferFeesChartEl,
                        transferFeesChartOptions
                    );
                    transferFeesChart.render();
                }
            }
        })
        .catch(function (error) {
            console.log("Something went wrong: " + error);
        });

    function txnChartView(tnxType, dataType = "m") {
        const tnxTypeTitle = tnxType.charAt(0).toUpperCase() + tnxType.slice(1);

        axios
            .get(baseUrl + "/admin/dashboard/txn/history/chart", {
                params: { txn_type: tnxType, data_type: dataType },
            })
            .then(function (response) {
                if (response.data.status == "success") {
                    const options = {
                        series: [
                            {
                                name: tnxTypeTitle,
                                data: response.data.data.values,
                            },
                        ],
                        chart: {
                            type: "area",
                            height: 380,
                            toolbar: { show: false },
                            zoom: {
                                enabled: false,
                            },
                        },
                        dataLabels: {
                            enabled: false,
                        },
                        stroke: {
                            curve: "straight",
                        },
                        title: {
                            text: tnxTypeTitle,
                            align: "center",
                        },
                        labels: response.data.data.labels,
                        xaxis: {
                            type: "category",
                        },
                        yaxis: {
                            opposite: true,
                            labels: {
                                formatter: function (value) {
                                    return "$" + value.toFixed(2);
                                },
                            },
                        },
                        legend: {
                            horizontalAlign: "left",
                        },
                    };

                    if (transactionChart) {
                        transactionChart.destroy();
                    }

                    // Render the chart
                    transactionChart = new ApexCharts(
                        document.querySelector("#chart"),
                        options
                    );
                    transactionChart.render();
                }
            })
            .catch(function (error) {
                console.log("Something went wrong: " + error);
            });
    }

    $(document).ready(function () {
        $("#transactionType").change(function () {
            const tnxType = $(this).val();
            const dataType = $(".dataType.active").attr("data-type");
            txnChartView(tnxType, dataType);
        });

        $(".dataType").click(function () {
            $(".dataType").removeClass("active");
            $(this).addClass("active");
            let dataType = $(this).attr("data-type");
            let tnxType = $("#transactionType").val();
            txnChartView(tnxType, dataType);
            $("#transactionType").val(tnxType);
        });

        txnChartView("investment");
    });

    axios
        .get(baseUrl + "/admin/dashboard/currency/chart")
        .then(function (response) {
            if (response.data.status == "success") {
                var options = {
                    series: response.data.data.values,
                    labels: response.data.data.labels,
                    legend: {
                        position: "bottom",
                    },
                    chart: {
                        type: "donut",
                        height: 256,
                    },
                    dataLabels: {
                        enabled: false,
                    },
                };

                var chart = new ApexCharts(
                    document.querySelector("#currencyDeposit"),
                    options
                );
                chart.render();
            }
        })
        .catch(function (error) {
            console.log("Something went wrong: " + error);
        });
})();
