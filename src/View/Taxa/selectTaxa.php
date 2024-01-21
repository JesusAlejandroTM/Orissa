<?php

    use App\Code\Model\API\RedListIdentifier;

    if (!isset($taxa))
    {
        header("Location: Search");
    }

    if (isset($taxaImage)) {
        if(!@is_array(getimagesize($taxaImage))){
            $taxaImage = "../../taxaUnavailable.png";
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
    <!--colonne a gauche-->
    <div class="left-column">
        <!-- head contient nom image et son -->
        <div class="head">
            <div class="zone-de-texte">
                <h1>NOM TAXONeeeeEEEEEEEEEEEE EEEEEEEEEEEEEEEEEEE</h1>
                <h2>Scientific Name / Full NamegfAAAAAAAAAAAA AAAAAAAAAAAAAAAAAAAAA</h2>
            </div>
            <div class="image-taxon"></div>
            <img src="<?php echo $taxaImage ?>" alt="image-taxon">
        </div>
    </div>
    <!--fin de head-->


    <!--fin de la colonne gauche -->

    <!-- colonne droite -->
    <div class="right-column">
        <div class="section">
            <h3>Evolution status protection</h3>
            <p>Type de liste : parametre </p>
            <p>statue : parametre </p>

        </div>

        <div class="section">
            <h3>Domain et Territoire</h3>

            <p>Domain: para </p>
            <p>Territoire: parametre </p>
        </div>

        <div class="section">
            <h3>Habitat</h3>
            <p>Habitat: param</p>
        </div>
        <div class="section">
            <h3>Nombre</h3>
            <p>Nombre: para </p>
        </div>
    </div>
    <!--fin de la colonne droite -->

    <!-- partie tableau -->
    <div class="section">

        <h3>Relations</h3>
        <table>
            <thead>
            <tr>
                <th>ID taxon</th>
                <th>Image taxon </th>
                <th>Nom taxon</th>
                <th>ID de la relation </th>
                <th>Nom de la relation</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>parametre</td>
                <td><img src="taxon.jpg" alt="image-taxon"></td>
                <td>parametre</td>
                <td>parametre</td>
                <td>parametre</td>
            </tr>
            <tr>
                <td>parametre</td>
                <td><img src="taxon.jpg" alt="image-taxon"></td>
                <td>paramefffffffffffffffff tre</td>
                <td>parametre</td>
                <td>parametre</td>
            </tr>
            <tr>
                <td>parametre</td>
                <td><img src="taxon.jpg" alt="image-taxon"></td>
                <td>parametre</td>
                <td>parametre</td>
                <td>parametre</td>

            </tr>
            </tbody>
        </table>
    </div>
    <!-- fin de la partie tableau -->
</div>