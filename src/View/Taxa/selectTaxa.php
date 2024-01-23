<?php

    use App\Code\Lib\HTMLGenerator;
    use App\Code\Lib\UserSession;
    use App\Code\Model\API\RedListIdentifier;
    use App\Code\Model\API\TaxaAPI;
    use App\Code\Model\API\TaxaHabitatIdentifier;
    use App\Code\Model\Repository\TaxaRegisters;

    if (isset($taxa))
    {
        $taxaId = $taxa->getId();
        $taxaAuthority = $taxa->getAuthority();
        $taxaParentId = $taxa->getParentId();
        $taxaScientificName = $taxa->getScientificName();
        $taxaVernacularName = $taxa->getVernacularName();
        $taxaRank = $taxa->getRankName();
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
        $worldRedListStatus = $taxaStatus['worldRedList'] ?? null;
        $europeanRedListStatus = $taxaStatus['europeanRedList'] ?? null;
        $nationalRedList = $taxaStatus['nationalRedList'] ?? null;
        $localRedList = $taxaStatus['localRedList']  ?? null;

        $BioGeoId = $taxaStatus['biogeoStatus'] ?? null;
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
                        Authorité : <?php echo $taxaAuthority?><br>
                        Rang taxonomique : <?php echo $taxaRank?>
                    </p>
                </div>
                <div class="image-taxon"></div>
                <img class="taxaImage" src="<?php echo $taxaImage ?>" alt="image-taxon">
            </div>

            <a href="Taxa/<?php echo $taxaParentId ?>">Taxon parent</a>

            <?php
                // Check if the taxa has a factsheet
                $factsheet = TaxaAPI::GetTaxaFactsheet($taxaId);
                if ($factsheet && is_array($factsheet)) {
                    echo '<a href="Taxa/' . $taxaId . '/factsheet">Factsheet</a>';
                }

                // Display register button if the user is connected
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
                <?php
                    if (isset($BioGeoId)) {
                        echo HTMLGenerator::GenerateBiogeographicStatusHTML($BioGeoId);
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