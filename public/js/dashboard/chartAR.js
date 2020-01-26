var ctx = document.getElementById("chartAR");
var l_year = $(".AR_ly")
var c_year = $(".AR_cy")
var balance = $(".AR");
var balance_1 = $(".AR_1");

var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: [
            'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'
        ],
        datasets: [{
            label: "# of " + $(l_year).val(),
            backgroundColor: "#26B99A",
            data: [
                $(balance[0]).val(), $(balance[1]).val(), $(balance[2]).val(), $(balance[3]).val(), $(balance[4]).val(), $(balance[5]).val(), $(balance[6]).val(), $(balance[7]).val(), $(balance[8]).val(), $(balance[9]).val(), $(balance[10]).val(), $(balance[11]).val()
            ],
        }, {
            label: "# of " + $(c_year).val(),
            backgroundColor: "#03586A",
            data: [
                $(balance_1[0]).val(), $(balance_1[1]).val(), $(balance_1[2]).val(), $(balance_1[3]).val(), $(balance_1[4]).val(), $(balance_1[5]).val(), $(balance_1[6]).val(), $(balance_1[7]).val(), $(balance_1[8]).val(), $(balance_1[9]).val(), $(balance_1[10]).val(), $(balance_1[11]).val()
            ],
        },]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: 0,
                    callback: function (value, index, values) {
                        if (parseInt(value) >= 1000) {
                            return 'Rp ' + value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                        } else {
                            return 'Rp ' + value;
                        }
                    }
                },
                gridLines: {
                    offsetGridLines: true
                },                
            }]
        },
        tooltips: {
            callbacks: {
                label: function(tooltipItem, data) {
                    return 'Rp ' + tooltipItem.yLabel.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                }            
            }
        },
    }
});