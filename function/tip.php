<?php
function get_random_tip(){
    require("connexion.php");
    $query = "SELECT * FROM electricity_saving_tips
                ORDER BY RAND()
                LIMIT 1;";
    $AllCharacter=array();
    $getChar=mysqli_query($connexion, $query);
    while ($Char=mysqli_fetch_assoc($getChar)){
      array_push($AllCharacter, $Char);
    };
    return $AllCharacter;
}
?>