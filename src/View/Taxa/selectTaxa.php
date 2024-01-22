<?php

    use App\Code\Model\API\RedListIdentifier;
    use App\Code\Model\API\TaxaHabitatIdentifier;

    if (isset($taxa))
    {
        $taxaId = $taxa->getId();
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
                    <p>Identifiant TaxRef : <?php echo $taxaId?></p>
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
                <h3>Status listes rouges </h3>
                <p>Liste rouge international : <?php echo $worldRedListStatus ?></p>
                <p>Liste rouge européenne : <?php echo $europeanRedListStatus ?></p>
                <p>Liste rouge nationale : <?php echo $nationalRedList ?></p>
                <p>Liste rouge locale : <?php echo $localRedList ?></p>

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
    <!-- partie tableau -->
    <div class="table-section">
        <h3>Relations</h3>
        <table>
            <thead>
            <tr>
                <th>ID taxon</th>
                <th>Nom taxon</th>
                <th>ID de la relation</th>
                <th>Nom de la relation</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>parametre</td>
                <td>parametre</td>
                <td>parametre</td>
                <td>parametre</td>
            </tr>
            <tr>
                <td>parametre</td>
                <td>parametre</td>
                <td>parametre</td>
                <td>parametre</td>
            </tr>
            <tr>
                <td>parametre</td>
                <td>parametre</td>
                <td>parametre</td>
                <td>parametre</td>

            </tr>
            </tbody>
        </table>
    </div>
    <!-- fin de la partie tableau -->
</div>