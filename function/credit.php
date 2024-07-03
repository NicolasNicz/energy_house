<?php
function get_credit(){
    require("connexion.php");
    $AllCharacter=array();
    $query = "SELECT * FROM `credit` WHERE 1;";
    $getChar=mysqli_query($connexion, $query);
    while ($Char=mysqli_fetch_assoc($getChar)){
      array_push($AllCharacter, $Char);
    };
    return $AllCharacter;
}

function get_dif_of_today(){
    require("connexion.php");
    $AllCharacter=array();
    $query = "SELECT DATE_SUB(CURDATE(), INTERVAL 1 DAY) AS Date,
                SUM(Predictions) AS TotalPredictions,
                SUM(Actuals) AS TotalActuals,
                SUM(Predictions) - SUM(Actuals) AS Difference
                FROM energy_data
                WHERE DATE(Temps) = DATE_SUB(CURDATE(), INTERVAL 1 DAY);";

    $getChar=mysqli_query($connexion, $query);
    while ($Char=mysqli_fetch_assoc($getChar)){
      array_push($AllCharacter, $Char);
    };
    return $AllCharacter;
}

function update_credit($nbcredit, $dif_hier, $yesterday){

    if ($dif_hier>=10){
        $nbcredit += 10;
    } elseif ($dif_hier >= 0 && $dif_hier <10) {
        $nbcredit += 5;
    } elseif ($dif_hier < 0 && $dif_hier > -10) {
        $nbcredit -= 5;
    } else{
        $nbcredit -= 10;
    }

    require("connexion.php");
    $maj="UPDATE credit SET nb_credit='$nbcredit', maj='$yesterday' WHERE id=1";
    if (!$resultRequete = mysqli_query($connexion, $maj)){
        $error=mysqli_error($connexion);
    }
}


?>