<?php
function get_data_bar_line(){
    require("connexion.php");
    $AllCharacter=array();
    $query = "SELECT DATE(Temps) as Date
                , DATE_FORMAT(Temps, '%H') as Heure
                , round(sum(Predictions),2) as Predictions
                , round(sum(Actuals),2) as Actuals

                FROM energy_data
                WHERE DATE(Temps) = '2024-07-02'
                GROUP BY DATE_FORMAT(Temps, '%H')";
    $getChar=mysqli_query($connexion, $query);
    while ($Char=mysqli_fetch_assoc($getChar)){
      array_push($AllCharacter, $Char);
    };
    return $AllCharacter;
}



?>