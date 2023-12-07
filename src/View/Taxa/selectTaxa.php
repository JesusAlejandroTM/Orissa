<?php
    /** @var Taxa $taxa*/

    use App\Code\Model\DataObject\Taxa;

    if (isset($taxa)) {
        echo "<p>Taxa here look : </p>";
        echo "<p>$taxa</p>";
        $taxaId = $taxa->getId();
        echo '<a href="Taxa/' . $taxaId . '/factsheet">Factsheet</a>';

        $parentTaxaId = $taxa->getParentId();
        if (!is_null($parentTaxaId)) {
            echo "<br>";
            echo '<a href="Taxa/' . $parentTaxaId . '">Parent</a>';
        }

        $links = $taxa->getLinks();
        var_dump($links);

    }
    else echo "<p>Taxa not found bro</p>";