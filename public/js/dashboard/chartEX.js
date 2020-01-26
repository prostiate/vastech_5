var ctx = document.getElementById("chartEX");
var balance = $(".EX");
var balance2 = $(".EX_name");
var myChart = new Chart(ctx, {
    type: 'pie',
    data: {
        labels: [$(balance2[0]).val(), $(balance2[1]).val(), $(balance2[2]).val(), $(balance2[3]).val(), $(balance2[4]).val()],
        datasets: [{
            label: "TeamA Score",
            data: [$(balance[0]).val(), $(balance[1]).val(), $(balance[2]).val(), $(balance[3]).val(), $(balance[4]).val()],
            backgroundColor: [
                "#26B99A", "#455C73", "#9B59B6", "#BDC3C7", "#3498DB"
            ],
            borderColor: [
                "#26B99A", "#455C73", "#9B59B6", "#BDC3C7", "#3498DB"
            ],
            borderWidth: [1, 1, 1, 1, 1]
        }]
    },
    options: {
        responsive: true,
        legend: {
            position: 'top',
        },
        animation: {
            animateScale: true,
            animateRotate: true
        },
        tooltips: {
            callbacks: {
                label: function(tooltipItem, data) {
                    return 'Rp ' + data['datasets'][0]['data'][tooltipItem['index']].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                }            
            }
        }
    }
});

