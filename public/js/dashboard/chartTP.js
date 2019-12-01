var ctx = document.getElementById("chartTP");
var balance = $(".TP");


var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: [
            'July', 'August', 'September', 'October', 'November', 'December'
        ],
        datasets: [{
            label: "# of 2019",
            data: [
                $(balance[6]).val(), $(balance[7]).val(), $(balance[8]).val(), $(balance[9]).val(), $(balance[10]).val(), $(balance[11]).val()
            ],
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)'
            ],
            borderColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)'
            ],
            borderWidth: 1
        }, ]
    },
    options: {
        scales: {
            xAxes: [{
                stacked: false
            }],
            yAxes: [{
                stacked: false,
            }]
        }
    }
});
