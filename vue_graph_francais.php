<?php include ("header.php");

?>

<script src="js\plotly-2.27.0.min.js"></script>

<div class="main-content">
    <header>
      <h1>Votre consommation par rapport <br>
      aux français</h1>
    </header>

    
<div class="widget-container">
<div id="graph2"></div>
    <script>
        var userConsumption = 5700; // Consommation annuelle de l'utilisateur en kWh
        var totalConsumption = 5700; // Consommation annuelle totale en kWh (somme de toutes les valeurs mensuelles)
        var top10Consumption = 2760; // Consommation annuelle des 10% les plus bas
        var averageConsumption = 5040; // Consommation annuelle moyenne
        var top90Consumption = 7200; // Consommation annuelle des 10% les plus hauts

        var trace1 = {
            x: ['Consommation annuelle'],
            y: [totalConsumption],
            type: 'bar',
            name: 'Total',
            marker: {
                color: '#b8b8b8'
            }
        };

        var top10Line = {
            x: ['Consommation annuelle'],
            y: [top10Consumption],
            type: 'scatter',
            mode: 'markers+text',
            name: 'Top 10% (moins)',
            marker: {
                color: 'green',
                size: 12
            },
            text: ['Top 10% (moins)'],
            textposition: 'bottom center'
        };

        var averageLine = {
            x: ['Consommation annuelle'],
            y: [averageConsumption],
            type: 'scatter',
            mode: 'markers+text',
            name: 'Moyenne',
            marker: {
                color: 'orange',
                size: 12
            },
            text: ['Moyenne'],
            textposition: 'bottom center'
        };

        var top90Line = {
            x: ['Consommation annuelle'],
            y: [top90Consumption],
            type: 'scatter',
            mode: 'markers+text',
            name: 'Top 10% (plus)',
            marker: {
                color: 'red',
                size: 12
            },
            text: ['Top 10% (plus)'],
            textposition: 'top center'
        };

        var userArrow = {
            x: ['Consommation annuelle'],
            y: [userConsumption],
            type: 'scatter',
            mode: 'markers+text',
            name: 'Votre consommation',
            marker: {
                color: 'blue',
                size: 16,
                symbol: 'arrow-bar-up'
            },
            text: ['Vous'],
            textposition: 'top center'
        };

        var data = [trace1, top10Line, averageLine, top90Line, userArrow];

        var layout = {
            title: 'Consommation annuelle en Kilowattheure',
            xaxis: {
                title: ''
            },
            yaxis: {
                title: 'Consommation (kWh)'
            },
            showlegend: false
        };

        var config = {
        displaylogo: false,
        responsive: true, 
        locale: 'fr',
      }

        Plotly.newPlot('graph2', data, layout, config);
    </script>


</div>



<div class="widget-container">

<div id="graph"></div>
    <script>
        var months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        var consumption = [320, 450, 300, 500, 600, 700, 550, 620, 490, 530, 470, 410];

        var trace1 = {
            x: months,
            y: consumption,
            type: 'bar',
            name: 'Consommation'
        };

        // Top 10% des français (consomme le moins)
        var top10 = {
            x: months,
            y: [200, 220, 210, 230, 240, 250, 260, 270, 260, 250, 240, 230],
            type: 'scatter',
            mode: 'lines',
            name: 'Top 10% (moins)',
            line: {
                color: 'green',
                width: 2
            }
        };

        // Moyenne
        var average = {
            x: months,
            y: [400, 420, 410, 430, 440, 450, 460, 470, 460, 450, 440, 430],
            type: 'scatter',
            mode: 'lines',
            name: 'Moyenne',
            line: {
                color: 'yellow',
                width: 2
            }
        };

        // 10% des français (consomme le plus)
        var top90 = {
            x: months,
            y: [600, 620, 610, 630, 640, 650, 660, 670, 660, 650, 640, 630],
            type: 'scatter',
            mode: 'lines',
            name: 'Top 10% (plus)',
            line: {
                color: 'red',
                width: 2
            }
        };

        var data = [trace1, top10, average, top90];

        var layout = {
            title: 'Consommation en Wattheure par mois',
            xaxis: {
                title: 'Mois'
            },
            yaxis: {
                title: 'Consommation (Wh)'
            },
            legend:{
             orientation:"h"
            },
        };

        var config = {
        displaylogo: false,
        responsive: true, 
        locale: 'fr',
      }

        Plotly.newPlot('graph', data, layout, config);
    </script>
