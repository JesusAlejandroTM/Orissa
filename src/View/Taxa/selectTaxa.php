<?php

    use App\Code\Lib\HTMLGenerator;
    use App\Code\Lib\UserSession;
    use App\Code\Model\API\RedListIdentifier;
    use App\Code\Model\API\TaxaHabitatIdentifier;
    use App\Code\Model\Repository\TaxaRegisters;

    if (isset($taxa))
    {
        /** @var \App\Code\Model\DataObject\Taxa $taxa */
        $taxaId = $taxa->getId();
        $taxaAuthority = $taxa->getAuthority();
        $taxaParentId = $taxa->getParentId();
        $taxaScientificName = $taxa->getScientificName();
        $taxaVernacularName = $taxa->getVernacularName();
        $taxaKingdomName = $taxa->getKingdomName() ?? "Indeterminé";
        $taxaPhylumName = $taxa->getPhylumName() ?? "Indeterminé";
        $taxaClassName = $taxa->getClassName() ?? "Indeterminé";
        $taxaOrderName = $taxa->getOrderName() ?? "Indeterminé";
        $taxaFamilyName = $taxa->getFamilyName() ?? "Indeterminé";
        $taxaGenusName = $taxa->getGenusName() ?? "Indeterminé";
        $taxaHabitat = $taxa->getHabitat();
        $taxaHabitatName = TaxaHabitatIdentifier::GetNameHabitat($taxaHabitat);
        $taxaHabitatDescription = TaxaHabitatIdentifier::GetDescriptionHabitat($taxaHabitat);
    }
    if (isset($taxaImage)) {
        if(!$taxaImage || !@is_array(getimagesize($taxaImage))){
            $taxaImage = "Orissa/../assets/img/taxaUnavailable.png";
        }
    }
    if (isset($taxaStatus)) {
        $worldRedListStatus = RedListIdentifier::GetAcronymDescription($taxaStatus['worldRedList']);
        $europeanRedListStatus = RedListIdentifier::GetAcronymDescription($taxaStatus['europeanRedList']);
        $nationalRedList = RedListIdentifier::GetAcronymDescription($taxaStatus['nationalRedList']);
        $localRedList = RedListIdentifier::GetAcronymDescription($taxaStatus['localRedList']);
    }
    if (isset($interactions) && is_array($interactions))
    {
        // Clean interactions data (duplicates happen)
        $interactions = $interactions['_embedded']['interactions'];
        $interactionResults = [];
        $existingIds = [];
        foreach ($interactions as $row) {
            $sourceTaxaId = $row['taxon']['id'];
            if (in_array($sourceTaxaId, $existingIds)) {
                continue;
            }
            $existingIds[] = $sourceTaxaId;
            $interactionResults[] = $row;
        }
    }
    ?>

<div class="html">
    <div class="taxaGrid">
        <!--colonne a gauche-->
        <div class="left-column">
            <!-- head contient nom image et son -->
            <div class="head">
                <div class="zone-de-texte">
                    <h1><?php echo $taxaScientificName ?></h1>
                    <h2><?php echo $taxaVernacularName ?></h2>
                    <p>Identifiant TaxRef : <?php echo $taxaId?><br>
                        Authorité : <?php echo $taxaAuthority?></p>
                </div>
                <div class="image-taxon"></div>
                <img class="taxaImage" src="<?php echo $taxaImage ?>" alt="image-taxon">
            </div>
        </div>
        <!--fin de head-->


        <!--fin de la colonne gauche -->

        <!-- colonne droite -->
        <div class="right-column">
            <div class="section">
                <?php
                    if (isset($taxaStatus))
                    {
                        echo HTMLGenerator::GenerateRedListHTML($worldRedListStatus, $europeanRedListStatus,
                            $nationalRedList, $localRedList);
                    }
                ?>
            </div>

            <div class="section">
                <h3>Type d'habitat</h3>

                <h4><?php echo $taxaHabitatName ?></h4>
                <p><?php echo $taxaHabitatDescription ?></p>
            </div>

            <div class="section">
                <h3>Taxonomie</h3>
                <p>Règne : <?php echo $taxaKingdomName ?><br>
                Division : <?php echo $taxaPhylumName ?><br>
                Classe : <?php echo $taxaClassName ?><br>
                Ordre : <?php echo $taxaOrderName ?><br>
                Famille : <?php echo $taxaFamilyName ?><br>
                Genre : <?php echo $taxaGenusName ?><br></p>
            </div>
            <a href="Taxa/<?php echo $taxaParentId ?>">Taxon parent</a>
            <a href="Taxa/<?php echo $taxaId ?>/factsheet">Factsheet</a>
            <?php
                if (UserSession::isConnected()) {
                    if (!TaxaRegisters::CheckRegisteredTaxa($taxaId)) {
                        echo '<p><a href="Taxa/' . $taxaId . '/register">Register</a></p>';
                    }
                    else {
                        echo '<p><a href="Taxa/' . $taxaId . '/unregister">Unregister</a></p>';
                    }
                }
            ?>
        </div>
        <!--fin de la colonne droite -->
    </div>
    <?php
        if (isset($interactionResults) && is_array($interactionResults))
        {
            echo HTMLGenerator::GenerateInteractionTable($interactionResults);
        }
    ?>
    <!-- fin de la partie tableau -->
</div>