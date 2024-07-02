<?php
$hote='localhost';

$port='3308';
$bd='energy_data';
$utilisateur='root';
$mdp='';
$dsn='mysql:dbname='.$bd.';host='.$hote.';port='. $port;


$connexion=mysqli_connect($hote,$utilisateur,$mdp, $bd);
if (!$connexion)
{
	echo "La connexion a échouée !";
}

?>
