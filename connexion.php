<?php
	$hote='localhost';

	$bd='energy_data';
	$utilisateur='root';
	$mdp='';

$connexion=mysqli_connect($hote,$utilisateur,$mdp, $bd);
if (!$connexion)
{
	echo "La connexion a échouée !";
}

$connexion->set_charset("utf8mb4");
?>