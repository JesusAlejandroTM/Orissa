<?php
    /** @var Taxa $taxa*/

    use App\Code\Model\DataObject\Taxa;

    if (isset($taxa)) {
        echo "<p>Taxa here look : </p>";
        echo "<p>$taxa</p>";
        $taxaId = $taxa->getId();
        echo '<p><a href="Taxa/' . $taxaId . '/factsheet">Factsheet</a></p>';
        echo '<p><a href="Taxa/' . $taxaId . '/interactions">Interactions</a></p>';

        $parentTaxaId = $taxa->getParentId();
        if (!is_null($parentTaxaId)) {
            echo '<p><a href="Taxa/' . $parentTaxaId . '">Parent</a></p>';
        }
    }
    else echo "<p>Taxa not found bro</p>";