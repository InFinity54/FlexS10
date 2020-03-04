var ctxTotalDmg = document.getElementById("playerTotalDmg");
var chartTotalDmg = new Chart(ctxTotalDmg, {
    type: 'doughnut',
    data: {
        labels: ["Dégâts physiques", "Dégâts magiques", "Dégâts bruts"],
        datasets: [{
            data: totalDmgValues,
            backgroundColor: ['#B46941', '#3A7FB3', '#DBDED0'],
            hoverBackgroundColor: ['#B46941', '#3A7FB3', '#DBDED0'],
            hoverBorderColor: "rgba(0, 0, 0, 1)",
        }],
    },
    options: {
        maintainAspectRatio: false,
        tooltips: {
            backgroundColor: "rgb(255,255,255)",
            bodyFontColor: "#858796",
            borderColor: '#dddfeb',
            borderWidth: 1,
            xPadding: 15,
            yPadding: 15,
            displayColors: false,
            caretPadding: 10,
        },
        legend: {
            display: true
        },
        cutoutPercentage: 80,
    },
});