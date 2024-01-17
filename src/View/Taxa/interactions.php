<?php
    if (isset($taxaId)) {
        if (isset($interactions)) {
            var_dump($interactions['_embedded']['interactions']);
            $taxaTitle = $interactions["taxon"]["scientificName"];
            echo "<h1>" . $taxaTitle . "</h1><br>";
            echo $interactions['text'];
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