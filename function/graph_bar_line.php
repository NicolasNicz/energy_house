<?php
function get_data_bar_line($type){
    require("connexion.php");

    date_default_timezone_set('Europe/Paris');
    
    $currentDate = date('Y-m-d');
    $currentTime = date('H:i:s');

    $WHERE = "";
    $format = '%D';

    if ($type == 'heure') {
        $WHERE = "WHERE DATE(Temps) = '$currentDate'";
        $format = '%H';
    } elseif ($type == 'jour') {
        // Si le type est 'jour', nous n'avons pas besoin de WHERE car nous voulons tout afficher jusqu'à aujourd'hui
        $WHERE = "WHERE DATE(Temps) <= '$currentDate'";
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