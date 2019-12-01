var ctx = document.getElementById("chartNP");
var balance = $(".NP");

var myChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
        datasets: [{
            label: 'Net Profit',
            backgroundColor: "#26B99A",
            borderColor: "#26B99A",
            fill: false,
            data: [0,0,0,0,0,0,0,0,0,$(balance).val(),0,0],
        }]
    },
    options: {
        responsive: true,
        /*title: {
            display: true,
            text: 'Chart.js Line Chart - Logarithmic'
        },*/
        scales: {
            xAxes: [{
                display: true,
            }],
            yAxes: [{
                display: true,
            }]
        }
    }
});
