 // Grab canvas
            var ctx = document.getElementById('mainCanvas').getContext('2d');

            var chart = new Chart(ctx, {
            // The type of chart
            type: 'line',
            // The data for dataset
            data: {
                labels: ['Januar', 'Februar', 'März', 'April', 'Mai', 'Juni', 'Juli'],
                datasets: [{
                    label: 'Einkauf',
                    backgroundColor: '#e56bcd',
                    borderColor: '#e56bcd',
                    lineTension: 0,
                    data: [30, 50, 60, 65, 50, 30, 45],
                    fill: false,
                    },
                    {
                    label: 'Logistik',
                    backgroundColor: '#579dbc',
                    borderColor: '#579dbc',
                    lineTension: 0,
                    data: [50, 45, 30, 60, 50, 20, 30],
                    fill: false,
                    },
                    {
                    label: 'Qualität',
                    backgroundColor: '#e0a02e',
                    borderColor: '#e0a02e',
                    lineTension: 0,
                    data: [40, 40, 35, 40, 50, 35, 50],
                    fill: false,
                    },
                    {
                    label: 'Technologie',
                    backgroundColor: '#88ac00',
                    borderColor: '#88ac00',
                    lineTension: 0,
                    data: [45, 25, 35, 45, 55, 65, 50],
                    fill: false,
                }]
            },
            // Configuration options
            options: {            
                    responsive: true,
                    title: {
                        display: true,
                        text: 'Chart.js Template'
                    },
                    scales: {
                        yAxes: [{
                            ticks: {
                                min: 0,
                                max: 100,
                            }
                        }]                
                    }
            }
        }); // END chart