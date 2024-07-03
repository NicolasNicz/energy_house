<?php
include ("function/graph_bar_line.php");

if (isset($_GET['type'])){
    $type = $_GET['type'];
}


$getGraphBarLineData = get_data_bar_line($type);
$background_graph = "#181818";
//var_dump($getGraphBarLineData);

$tableauCAComplet = array
            (
              'Date' => array(),
              'Predictions' => array(),
              'Actuals' => array()
            );



foreach ($getGraphBarLineData as $CA){
    if ($type == 'minute'){
        $Date = $CA['Minute'];
    } elseif ($type == 'heure') {
        $Date = $CA['Heure'];
    } else {
        $Date = $CA['Jour'];
    }
    
    $Actuals = $CA['Actuals'];
    $Predictions = $CA['Predictions'];

    array_push($tableauCAComplet['Date'], $Date);
    array_push($tableauCAComplet['Predictions'], $Predictions );
    array_push($tableauCAComplet['Actuals'], $Actuals);
}



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="js\plotly-2.27.0.min.js"></script>
    <link rel="stylesheet" href="styles\general.css" />
    <title>Document</title>
</head>
<body>

<div id="widget-category-container">
  <a class="category-container" id="a-client" href="vue_graph_bar_line.php?type=day">
  Jour
  </a>
  <a class="category-container" id="a-programme" href="vue_graph_bar_line.php?type=heure">
  Minute
  </a>
  <a class="category-container" id="a-resp" href="vue_graph_bar_line.php?type=minute">
  Heure
  </a>
</div>



<div class="widget-container">
  <div id='FullRetardCAGraph' style="max-height:550px"></div>
  <script>
      //Script de paramétrage du graphique
        <?php
          $firstcolum=true;
          // Exemple de ce que va afficher la fonction ci dessous :
          // X: ['client1', 'client2', 'client3'],

          $tableX = "xValue= [";

          foreach ($tableauCAComplet['Date'] as $CA){
            $tableX .="'$CA', ";
          }
          $tableX =substr($tableX, 0, -2);
          $tableX .="];";
          echo $tableX;

          // Exemple de ce que va afficher la fonction ci dessous :
          // Y: [20, 14, 23],

          $tableY = "yValue= [";

          foreach ($tableauCAComplet['Actuals'] as $CA){
            if (isset($CA)){
              $LeCA=$CA;
            }
            else $LeCA=0;
            $tableY .="$LeCA, ";
          }
          $tableY =substr($tableY, 0, -2);
          $tableY .="];";
          echo $tableY;
          
        ?>

      var Réalisé = {
      x: xValue,
      y: yValue,
      name: 'Réalisé',
      orientation: 'v',
      marker: {
        color: '#FABF8F',
        width: 1
      },
      type: 'bar'
      };

                        
      <?php
          // Exemple de ce que va afficher la fonction ci dessous :
          // X: ['client1', 'client2', 'client3'],

          $tableX = "xValue= [";

          foreach ($tableauCAComplet['Date'] as $CA){
            $tableX .="'$CA', ";
          }
          $tableX =substr($tableX, 0, -2);
          $tableX .="];";
          echo $tableX;

          // Exemple de ce que va afficher la fonction ci dessous :
          // Y: [20, 14, 23],

          $tableY = "yValue= [";

          foreach ($tableauCAComplet['Predictions'] as $CA){
            if (isset($CA)){
              $LeCA=$CA;
            }
            else $LeCA=0;
            $tableY .="$LeCA, ";
          }
          $tableY =substr($tableY, 0, -2);
          $tableY .="];";
          echo $tableY;
          
        ?>
      var Prévision = {
      x: xValue,
      y: yValue,
      name: 'Prévision',
      orientation: 'v',
      marker: {
        color: '#8DB4E2',
        width: 1
      },
      type: 'scatter',
      line:{
        width:3
      }
      };

      var data = [Réalisé, Prévision];

      var layout = {
        title: {
          text:"<b> Consommation d'energie par heure en WattHeure  </b>",
          font:{
            family:'Segoe UI',
            size:'20',
            color:'#fff'
          }
        },
        font:{
            color:'#fff'
          },

        plot_bgcolor: '<?=$background_graph?>',
        paper_bgcolor: '<?=$background_graph?>',
        barmode: 'stack',
        xaxis: {
          gridcolor:'#504f4f',
          automargin:true,
          type: 'category'
        },
        yaxis: {
          gridcolor:'#504f4f',
          ticksuffix:' Wh'
        }
      };

      var config = {
        displaylogo: false,
        responsive: true, 
        locale: 'fr',
      }

      Plotly.newPlot('FullRetardCAGraph', data, layout, config);
    </script>
  </div>
</body>
</html>