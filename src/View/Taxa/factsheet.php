<div class="factsheetText">
<?php
    if (isset($taxaId)) {
        if (isset($factsheet)) {
            $taxaTitle = $factsheet["taxon"]["scientificName"];
            echo "<h1>" . $taxaTitle . "</h1><br>";
            echo $factsheet['text'];
            echo "<br>";
            echo '<a href="Taxa/' . $taxaId . '">Retour</a>';
        }
        else if (isset($exceptionMessage)) {
            echo "<p>$exceptionMessage</p>";
            echo '<a href="Taxa/' . $taxaId . '">Retour</a>';
        }
    }
    else {
        echo "<p>Ce taxon n'existe pas</p>";
    }
    ?>
</div>

