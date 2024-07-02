<?php
	$hote='localhost';

	$bd='energy_data';
	$utilisateur='root';
	$mdp='';

	$connexion=mysqli_connect($hote,$utilisateur,$mdp, $bd);
	if (!$connexion)
	{
		//echo "La connexion a échouée !";
	}
	else{
		//echo "co";
	}
?>