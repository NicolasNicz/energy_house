<?php
include 'header.php';
?>

<main class="main-content">
    <h1 class="title">Diagramme circulaire</h1>

    <div id="widget-category-container">
        <a class="category-container btnChart" name="last_week" href="/energy_house/graph_pie_view.php?t=last_week">Dernière semaine</a>
        <a class="category-container btnChart" name="last_hour" href="/energy_house/graph_pie_view.php?t=last_hour">Dernière heure</a>
    </div>
    <script src="https://cdn.plot.ly/plotly-2.32.0.min.js" charset="utf-8"></script>

    <div class="widget-container center">
    <div id="myDiv" name="myDiv" class="myDiv"></div>

    <script src="https://cdn.plot.ly/plotly-2.32.0.min.js" charset="utf-8"></script>
<script>

    var data;
    <?php
        include_once("connexion.php");

        $where = "";

        if(isset($_GET)){
            if(isset($_GET["t"])){
                if($_GET["t"] != "")
                {
                    if($_GET["t"] == "last_week"){
                        $where = "WHERE DATE(Temps) >= DATE_SUB(NOW(), INTERVAL 7 DAY)";
                    }
                    else if($_GET["t"] == "last_hour"){
                        $where = "WHERE DATE(Temps) >= DATE_SUB(NOW(), INTERVAL 1 HOUR)";
                    }
                }
            }
        }

        $json = [];
        $valuesGood = [];
        $valuesBad = [];
        $valuesVeryGood = [];
        $valuesMid = [];

        $avgRow = mysqli_fetch_assoc(mysqli_query($connexion, "SELECT AVG(Actuals) as avg FROM energy_data $where"));
        $avg = $avgRow["avg"];

        $config = json_decode(file_get_contents("config.json"), true);
    
        $res = mysqli_query($connexion, "SELECT * FROM energy_data");
        while($row=mysqli_fetch_assoc($res)){
            if($row["Actuals"]>(1+($config["category_points"][2]/100))*$avg){
                array_push($valuesBad, $row["Actuals"]);
            }
            if($row["Actuals"]>(1+($config["category_points"][1]/100))*$avg){
                array_push($valuesMid, $row["Actuals"]);
            }
            if($row["Actuals"]>(1+($config["category_points"][0]/100))*$avg){
                array_push($valuesGood, $row["Actuals"]);
            }
            else{
                array_push($valuesVeryGood, $row["Actuals"]);
            }
        }

        $total = 0;
        $sum = 0;
        foreach ($valuesVeryGood as $key => $value) {
            $sum += $value;
        }
        //array_push($json, $sum/count($valuesVeryGood));
        $nb = count($valuesVeryGood);
        array_push($json, $nb);
        echo "console.log('Nb VG: $nb');";

        $total += $sum;
        $sum = 0;
        foreach ($valuesGood as $key => $value) {
            $sum += $value;
        }
        //array_push($json, $sum/count($valuesGood));
        $nb = count($valuesGood);
        array_push($json, $nb);
        echo "console.log('Nb G: $nb');";

        $total += $sum;
        $sum = 0;
        foreach ($valuesMid as $key => $value) {
            $sum += $value;
        }
        //array_push($json, $sum/count($valuesMid));
        $nb = count($valuesMid);
        array_push($json, $nb);
        echo "console.log('Nb M: $nb');";

        $total += $sum;
        $sum = 0;
        foreach ($valuesBad as $key => $value) {
            $sum += $value;
        }
        //array_push($json, $sum/count($valuesBad));
        $nb = count($valuesBad);
        array_push($json, $nb);
        echo "console.log('Nb B: $nb');";

        $total += $sum;
        $avg = $total/(count($valuesBad)+count($valuesGood)+count($valuesMid)+count($valuesVeryGood));
        echo "console.log('Avg: $avg');";
        $jsonstr = json_encode($json);
        echo "data = $jsonstr;";
    ?>

    var layout = {
        height: 400,
        width: 500,
    };

    var datas = [{
        "values": data, 
        "labels": ["Very Good", "Good", "Mid", "Bad"], 
        "type": "pie",
        "marker": {
            "colors": ["green", "blue", "red", "darkred"]
        }
    }];

    Plotly.newPlot("myDiv", datas, layout);

</script>
    </div>
</main>

</body>

</html>