<?php
    if (isset($factsheet)) {
        $taxaTitle = $factsheet["taxon"]["scientificName"];
        echo "<h1>" . $taxaTitle . "   </h1><br>";
        echo $factsheet['text'];
    }
    else echo "Ce taxon n'existe pas";