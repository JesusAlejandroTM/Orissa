<?php

    use App\Code\Lib\HTMLGenerator;

    if (!isset($library) || is_string($library)) {
        \App\Code\Lib\FlashMessages::add("warning", "Cette naturothèque n'existe pas");
        header("Location: /Orissa/Profile");
        exit();
    }
    ?>
<main class="libaryContainer">
    <h2 class="libraryTitle"><?php echo $library->getTitle()?></h2>
    <div id="resultats">
        <ul id="liste">
            <?php
                if (isset($taxas) && !empty($taxas) && !is_string($taxas))
                {
                    foreach ($taxas as $taxa){
                        echo HTMLGenerator::GenerateTaxaUnitHTML($taxa);
                    }
                }
                else if (isset($taxas) && is_string($taxas)) echo $taxas;
                ?>
        </ul>
    </div>
</main>
