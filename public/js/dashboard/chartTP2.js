var ctx = document.getElementById("chartTP2");
var balance = $(".TP2");

var date = new Date();
var now = date.getMonth();

if (now <= 5) {
    var MONTH = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
    var i = [0, 1, 2, 3, 4, 5];
} else {
    var MONTH = ['July', 'August', 'September', 'October', 'November', 'December'];
    var i = [6, 7, 8, 9, 10, 11];
}

var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: [
            MONTH[0], MONTH[1], MONTH[2], MONTH[3], MONTH[4], MONTH[5]
        ],
        datasets: [{
            label: "# of " + $(year).val(),
            backgroundColor: ["#26B99A","#03586A","#26B99A","#03586A","#26B99A","#03586A"],
            data: [
                $(balance[i[0]]).val(), $(balance[i[1]]).val(), $(balance[i[2]]).val(), $(balance[i[3]]).val(), $(balance[i[4]]).val(), $(balance[i[5]]).val()
            ],
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: !0,
                    callback: function (value, index, values) {
                        if (parseInt(value) >= 1000  || parseInt(value) <= 1000) {
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
                label: function (tooltipItem, data) {
                    return 'Rp ' + tooltipItem.yLabel.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                }
            }
        }
    }
});

console.log()
