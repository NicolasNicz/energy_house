<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.plot.ly/plotly-latest.min.js"></script>
</head>

<body>
    <div id="plot" class="graph_aoe"></div>
    <script>
        // Données de consommation électrique
        const consommation = {
            x: [
                '2024-07-04 03:00', '2024-07-04 04:00', '2024-07-04 05:00',
                '2024-07-04 06:00', '2024-07-04 07:00', '2024-07-04 08:00',
                '2024-07-04 09:00', '2024-07-04 10:00', '2024-07-04 11:00',
                '2024-07-04 12:00'
            ],
            y: [
                120, 130, 125, 140, 145, 160,
                155, 165, 170, 160
            ],
            type: 'scatter',
            mode: 'lines',
            name: 'Consommation électrique'
        };

        // Périodes d'appel d'offre d'effacement
        const effacement = [{
                x0: '2024-07-04 05:00',
                x1: '2024-07-04 07:00',
                y1: 150
            },
            {
                x0: '2024-07-04 10:00',
                x1: '2024-07-04 11:00',
                y1: 155
            },
            {
                x0: '2024-07-04 13:00',
                x1: '2024-07-04 14:00',
                y1: 145
            }
        ];

        // Traces pour les rectangles d'effacement
        const shapes = effacement.flatMap(e => [
            // Rectangle vert jusqu'à la valeur d'effacement
            {
                type: 'rect',
                xref: 'x',
                yref: 'y',
                x0: e.x0,
                x1: e.x1,
                y0: 0,
                y1: e.y1,
                fillcolor: 'rgba(0, 255, 0, 0.2)',
                line: {
                    width: 0
                }
            },
            // Rectangle rouge au-dessus de la valeur d'effacement
            {
                type: 'rect',
                xref: 'x',
                yref: 'y',
                x0: e.x0,
                x1: e.x1,
                y0: e.y1,
                y1: Math.max(...consommation.y),
                fillcolor: 'rgba(255, 0, 0, 0.2)',
                line: {
                    width: 0
                }
            }
        ]);

        // Configuration du layout
        const layout = {
            shapes: shapes,
            xaxis: {
                title: 'Temps',
                type: 'date'
            },
            yaxis: {
                title: 'Consommation (Wh)'
            }
        };

        // Configuration suplémentaire
        var config = {
            displaylogo: false,
            responsive: true,
        }

        // Tracer le diagramme
        Plotly.newPlot('plot', [consommation], layout, config);
    </script>
</body>

</html>