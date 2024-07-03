<head>
    <script src="https://cdn.plot.ly/plotly-2.32.0.min.js" charset="utf-8"></script>
</head>
<div id="myDiv" name="myDiv" class="myDiv"></div>
<script>
    var data;
    <?php
        include("connexion.php");

        $json = [];
    
        $res = mysqli_query($connexion, "SELECT * FROM energy_data");
        while($row=mysqli_fetch_assoc($res)){
            if($row["Actuals"]>7.5){
                array_push($valuesBad, $row["Actuals"]);
            }
            else if($row["Actuals"]>5){
                array_push($valuesMid, $row["Actuals"]);
            }
            else if($row["Actuals"]>2.5){
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
        array_push($json, $sum/count($valuesVeryGood));
        $nb = count($valuesVeryGood);
        echo "console.log('Nb VG: $nb');";

        $total += $sum;
        $sum = 0;
        foreach ($valuesGood as $key => $value) {
            $sum += $value;
        }
        array_push($json, $sum/count($valuesGood));
        $nb = count($valuesGood);
        echo "console.log('Nb G: $nb');";

        $total += $sum;
        $sum = 0;
        foreach ($valuesMid as $key => $value) {
            $sum += $value;
        }
        array_push($json, $sum/count($valuesMid));
        $nb = count($valuesMid);
        echo "console.log('Nb M: $nb');";

        $total += $sum;
        $sum = 0;
        foreach ($valuesBad as $key => $value) {
            $sum += $value;
        }
        array_push($json, $sum/count($valuesBad));
        $nb = count($valuesBad);
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
        "type": "pie"
    }];

    Plotly.newPlot('myDiv', datas, layout);
</script>