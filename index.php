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

if ($dif_hier>=10){
    $difcredit = 10;
} elseif ($dif_hier >= 0 && $dif_hier <10) {
    $difcredit = 5;
} elseif ($dif_hier < 0 && $dif_hier > -10) {
    $difcredit = - 5;
} else{
    $difcredit = - 10;
}

include ("header.php");
?>

<div class="main-content">
            <header>
                <h1>Votre Consommation Énergétique</h1>
            </header>
            <main>
                <section id="home">
                    <h2>Credit Actuel</h2>
                    <p><?=$nbcredit?></p>
                </section>
                <section id="about">
                    <h2>Hier </h2>
                    <p><?=$difcredit?></p>
                </section>
                <section id="services">
                    <h2>Astuce du jour !</h2>
                    <p><?=$le_tip_of_day?></p>
                </section>
            </main>
        </div>
    </div>
</body>
</html>



