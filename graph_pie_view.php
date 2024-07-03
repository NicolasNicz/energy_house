<?php
include 'header.php';
?>

<main class="main-content">
    <h1 class="title">Diagramme camembert</h1>

    <div id="widget-category-container">
        <a class="category-container">bouton</a>
        <a class="category-container">bouton</a>
        <a class="category-container">bouton</a>
    </div>

    <div class="widget-container center">
        <?php
        include 'graph_pie.php'
        ?>
    </div>
</main>

</body>

</html>