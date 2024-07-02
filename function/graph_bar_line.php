<?php
function get_data_bar_line($type){
    require("connexion.php");

    if ($type == 'minute'){
        $WHERE = "WHERE DATE(Temps) = '2024-07-02'";
        $format = '%H:%i';
    } elseif ($type == 'heure') {
        $WHERE = "WHERE DATE(Temps) = '2024-07-02'";
        $format = '%H';
    } else{
        $WHERE = "";
        $format = '%D';
    }
    $AllCharacter=array();
    $query = "SELECT DATE(Temps) as Date
                , DATE_FORMAT(Temps, '%D') as Jour
                , DATE_FORMAT(Temps, '%H:%i') as Minute
                , DATE_FORMAT(Temps, '%H') as Heure
                , round(sum(Predictions),2) as Predictions
                , round(sum(Actuals),2) as Actuals

                FROM energy_data
                $WHERE
                GROUP BY DATE_FORMAT(Temps, '$format')";
    $getChar=mysqli_query($connexion, $query);
    while ($Char=mysqli_fetch_assoc($getChar)){
      array_push($AllCharacter, $Char);
    };
    return $AllCharacter;
}



?>