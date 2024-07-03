<?php
include ("function/graph_bar_line.php");


if (isset($_GET['type'])){
    $type = $_GET['type'];
}


$getGraphBarLineData = get_data_bar_line($type);
$background_graph = "#fff";
//var_dump($getGraphBarLineData);

$tableauCAComplet = array
            (
              'Date' => array(),
              'Predictions' => array(),
              'Actuals' => array()
            );

if (isset($_POST['objectif'])){
  $objectif = $_POST['objectif'];
}
else{
  $objectif = 300;
}

foreach ($getGraphBarLineData as $CA){
    if ($type == 'minute'){
        $Date = $CA['Minute'];
    } elseif ($type == 'heure') {
      
        $Date = $CA['Heure'];
    } else {
        $Date = $CA['Jour'];
        $objectif = 0;
    }
    
    $Actuals = $CA['Actuals'];
    $Predictions = $CA['Predictions'];

    array_push($tableauCAComplet['Date'], $Date);
    array_push($tableauCAComplet['Predictions'], $Predictions );
    array_push($tableauCAComplet['Actuals'], $Actuals);

    
}
include ("header.php");

?>

<script src="js\plotly-2.27.0.min.js"></script>

<div class="main-content">
    <header>
      <h1>Votre consommation <br>
      Actuel / Prévu</h1>
    </header>

    <form method="POST" action="vue_graph_bar_line.php?type=heure">
      Objectif : <input name='objectif' type="text" value="<?=$objectif?>"> </input>
    </form>
    

<div id="widget-category-container">
  <a class="category-container" id="a-client" href="vue_graph_bar_line.php?type=day">
  Jour
  </a>
  <a class="category-container" id="a-programme" href="vue_graph_bar_line.php?type=heure">
  Heure
  </a>
</div>



<div class="widget-container">
  <div id='FullRetardCAGraph' style="max-height:550px; width:97%; margin-bottom:5px"></div>
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
            $tableY .="$objectif, ";
          }
          $tableY =substr($tableY, 0, -2);
          $tableY .="];";
          echo $tableY;
          
        ?>
      var Objectif = {
      x: xValue,
      y: yValue,
      name: 'Objectif',
      orientation: 'v',
      marker: {
        color: 'green',
        width: 1
      },
      type: 'scatter',
      line:{
        width:3
      }
      };

      var data = [Réalisé, Prévision, Objectif];

      var layout = {
        title: {
          text:"<b> Consommation d'energie par heure en WattHeure  </b>",
          font:{
            family:'Segoe UI',
            size:'20',
            color:'#000'
          }
        },
        font:{
            color:'#000'
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