var ctx = document.getElementById("chartNP");
var balance = $(".NP");
var l_year = $(".NP_l_year");
var year = $(".NP_year");

new Chart(ctx, {
    type: 'line',
    data: {
        labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
        datasets: [{
            label: 'Net Profit ' + $(l_year).val(),
            backgroundColor: "rgba(38, 185, 154, 0.31)",
            borderColor: "rgba(38, 185, 154, 0.7)",
            pointBorderColor: "rgba(38, 185, 154, 0.7)",
            pointBackgroundColor: "rgba(38, 185, 154, 0.7)",
            pointHoverBackgroundColor: "#fff",
            pointHoverBorderColor: "rgba(220,220,220,1)",
            pointBorderWidth: 1,
            fill: true,
            data: [
                $(balance[0]).val(), $(balance[1]).val(), $(balance[2]).val(), $(balance[3]).val(), $(balance[4]).val(), $(balance[5]).val(), $(balance[6]).val(), $(balance[7]).val(), $(balance[8]).val(), $(balance[9]).val(), $(balance[10]).val(), $(balance[11]).val()
            ],
        }, {
            label: 'Net Profit ' + $(year).val(),
            backgroundColor: "rgba(3, 88, 106, 0.3)",
            borderColor: "rgba(3, 88, 106, 0.70)",
            pointBorderColor: "rgba(3, 88, 106, 0.70)",
            pointBackgroundColor: "rgba(3, 88, 106, 0.70)",
            pointHoverBackgroundColor: "#fff",
            pointHoverBorderColor: "rgba(151,187,205,1)",
            pointBorderWidth: 1,
            fill: true,
            data: [
                $(balance[12]).val(), $(balance[13]).val(), $(balance[14]).val(), $(balance[15]).val(), $(balance[16]).val(), $(balance[17]).val(), $(balance[18]).val(), $(balance[19]).val(), $(balance[20]).val(), $(balance[21]).val(), $(balance[22]).val(), $(balance[23]).val()
            ],
        }]
    },
    options: {
        responsive: true,
        scales: {
            xAxes: [{
                display: true,
            }],
            yAxes: [{
                display: true,
                ticks: {
                    beginAtZero: 0,
                    callback: function (value, index, values) {
                        if (parseInt(value) >= 1000  || parseInt(value) <= 1000) {
                            return 'Rp ' + value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                        } else {
                            return 'Rp ' + value;
                        }
                    }
                }
            }]
        },
        tooltips: {
            callbacks: {
                label: function(tooltipItem, data) {
                    return 'Rp ' + tooltipItem.yLabel.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                }            
            }
        }
    }
});

