<?php
session_start();
header( 'Content-type: text/html; charset=UTF-8' );

include ("function/credit.php");
include ("function/tip.php");

$credits = get_credit();
$random_tip = get_random_tip();
$le_random_tip = $random_tip[0]['tip'];

if (!isset($_SESSION['tip_of_day'])){
    $_SESSION['tip_of_day'] = $le_random_tip;
    $le_tip_of_day = $le_random_tip;
} else {
    $le_tip_of_day = $_SESSION['tip_of_day'];
}

foreach ($credits as $credit){
    $nbcredit = $credit['nb_credit'];
    $maj = $credit['maj'];
}

$getdif_Hier = get_dif_of_today();
foreach ($getdif_Hier as $hier) {
    $date_hier = $hier['Date'];
    $totalPredictions_hier = $hier['TotalPredictions'];
    $totalActuals_hier = $hier['TotalActuals'];
    $dif_hier = $hier['Difference'];
}

$date = new DateTime();
$date->modify('-1 day');
$yesterday = $date->format('Y-m-d');

if ($maj<$yesterday){
    update_credit($nbcredit, $dif_hier, $yesterday);
}

$dif_hier= 10;
if ($dif_hier>=10){
    $difcredit = 10;
} elseif ($dif_hier >= 0 && $dif_hier <10) {
    $difcredit = 5;
} elseif ($dif_hier < 0 && $dif_hier > -10) {
    $difcredit = 0;
} else{
    $difcredit = 0;
}

include ("header.php");

?>

<div class="main-content">
            <header>
                <h1>Votre Consommation Énergétique</h1>
            </header>
            <main>
                <section id="home">
                    <h2 style="text-align:center;">Credit Actuel</h2>
                    <p class="credit"><?=$nbcredit?></p>
                </section>

                <section>
                    <h2>Utilisez votre crédit</h2>
                
                    <div id="widget-category-container">
                        <a class="category-container" href="#">
                        🔆Réductions sur les Factures d'Énergie
                        </a>
                        <a class="category-container" href="#">
                        📺Réductions Équipements Énergétiques
                    </a>
                    <a class="category-container" href="#">
                        🛴Produits écologiques
                    </a>
                    <a class="category-container" href="#">
                        🎁Cartes-cadeaux
                    </a>
                    <a class="category-container" href="#">
                        💵Billets pour des événements locaux
                    </a>

                    

                    
                    </div>
                </section>



                <section id="about">
                    <h2>✅ Dépassez vos prédictions ! </h2>
                    <?php if ($dif_hier>=0){
                         echo "<b class='lecredit'> ↪ + $difcredit </b>";
                        echo "<br>Félicitation ! Hier, vous avez consommés <b> 126 Watt</b> en moins que prévu par rapport aux prédictions pour Juin! <br>";
                       

                    }else{
                        $difafficher = $dif_hier - $dif_hier*2;
                        $difafficher = round($difafficher, 2);
                        echo "Attention ! Hier, vous avez consommés <b> $difafficher Watt </b> en trop par rapport aux prédictions! <br>";
                        echo "vous ne gagnez aucun crédit !";
                    
                    }?>
                    
                </section>



                <section>
                    <h2>✅ Faite partie du top français !</h2>
                    <b class='lecredit'> ↪ + 25</b>
                    <p>Vous faites partie des 10% des français qui consomme le moins en Mai ! (230 kWh)</p>
                </section>

                <section>
                    <h2>✅ Restez en dessous des 150 Watteur</h2>
                    <b class='lecredit'> ↪ + 5</b>
                    <p>Vous avez respecté l'appel d'offre d'effacement de 150 Watteur en 2 heures (de 18h à 22h)</p>
                    
                </section>


                <section>
                    <h2>🔲 Restez en dessous des 300 Watteur</h2>
                    <b class='lecreditnon'> + 10</b>
                    <p>Vous devez respecté l'appel d'offre d'effacement de 300 Watteur en 4 heures (de 18h à 22h)</p>
                    
                </section>

                <section>
                    <h2>🔲 Un 14 juillet sobre !</h2>
                    <b class='lecreditnon'> + 20</b>
                    <p>Le 14 juillet prochain consommez moins de 7 000 Watteur (de 0h à 23h59)</p>
                    
                </section>
            </main>
        </div>
    </div>
</body>
</html>



