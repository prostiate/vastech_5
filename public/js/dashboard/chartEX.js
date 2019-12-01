var ctx = document.getElementById("chartEX");
var balance = $(".EX");
var balance2 = $(".EX_name");

var myChart = new Chart(ctx, {
    type: 'doughnut',
    data: {
        labels: [$(balance2[0]).val(), $(balance2[1]).val(), $(balance2[2]).val(), $(balance2[3]).val(), $(balance2[4]).val()],
        datasets: [{
            label: "TeamA Score",
            data: [$(balance[0]).val(), $(balance[1]).val(), $(balance[2]).val(), $(balance[3]).val(), $(balance[4]).val()],
            backgroundColor: [
                "#DEB887",
                "#A9A9A9",
                "#DC143C",
                "#F4A460",
                "#2E8B57"
            ],
            borderColor: [
                "#CDA776",
                "#989898",
                "#CB252B",
                "#E39371",
                "#1D7A46"
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
        }
    }
});
