import Chart from 'chart.js/auto';

const labels = JSON.parse(document.getElementById('labels').valueOf().value);
const open = JSON.parse(document.getElementById('open').valueOf().value);
const close = JSON.parse(document.getElementById('close').valueOf().value);
console.log(open)
console.log(close)
const data = {
    labels: labels,
    datasets: [{
        label: 'Open',
        backgroundColor: 'rgb(50, 255, 132)',
        borderColor: 'rgb(255, 255, 255)',
        data: open,
    },
    {
        label: 'Close',
        backgroundColor: 'rgb(255, 100, 90)',
        borderColor: 'rgb(0, 99, 0)',
        data: close,
    }]
};

const config = {
    type: 'line',
    data: data,
    options: {}
};

new Chart(
    document.getElementById('myChart'),
    config
);