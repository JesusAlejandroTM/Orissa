<div class="loader--hidden"></div>
<h1 class="searchTitle">Recherche de taxon</h1>
<div>
    <div id="filtre">
        <span><b>Filtres de recherche</b></span>
        <ul>
            <li>
                <label for="territory">Territoires :</label><br>
                <select id="territory">
                    <option value="">Sélection territoire</option>
                    <option value="fr">France métropolitaine</option>
                    <option value="gf">Guyane française</option>
                    <option value="gua">Guadeloupe</option>
                    <option value="mar">Martinique</option>
                    <option value="sm">Saint-Martin</option>
                    <option value="sb">Saint-Barthélemy</option>
                    <option value="spm">Saint-Pierre-et-Miquelon</option>
                    <option value="epa">Îles éparses</option>
                    <option value="may">Mayotte</option>
                    <option value="reu">Réunion</option>
                    <option value="sa">Îles subantarctiques</option>
                    <option value="ta">Terre Adélie</option>
                    <option value="nc">Nouvelle-Calédonie</option>
                    <option value="wf">Wallis et Futuna</option>
                    <option value="pf">Polynésie française</option>
                    <option value="cli">Clipperton</option>
                </select>
            </li>
            <li>
                <label for="domain">Domaines :</label><br>
                <select id="domain">
                    <option value="">Sélection domaine</option>
                    <option value="continental">Continental</option>
                    <option value="marin">Marin</option>
                </select>
            </li>
            <li>
                <label for="habitat">Habitats :</label><br>
                <select id="habitat">
                    <option value="">Sélection habitat</option>
                    <option value="1">Marin</option>
                    <option value="2">Eau douce</option>
                    <option value="3">Terrestre</option>
                    <option value="4">Marin et eau douce</option>
                    <option value="5">Marin et terrestre</option>
                    <option value="6">Eau saumâtre</option>
                    <option value="7">Continental (terrestre et/ou eau douce)</option>
                    <option value="8">Continental (terrestre et eau douce)</option>
                </select>
            </li>
            <li>
                <label for="taxonomicRank">Rang taxonomique :</label>
                <select id="taxonomicRank">
                    <option value="">Sélection rang taxonomique</option>
                    <option value="Dumm">Domaine</option>
                    <option value="KD">Règne</option>
                    <option value="PH">Phylum</option>
                    <option value="CL">Classe</option>
                    <option value="OR">Ordre</option>
                    <option value="FM">Famille</option>
                    <option value="SBFM">Sous-Famille</option>
                    <option value="TR">Tribu</option>
                    <option value="GN">Genre</option>
                    <option value="AGES">Agrégat</option>
                    <option value="ES">Espèce</option>
                    <option value="SSES">Sous-Espèce</option>
                    <option value="NAT">Natio</option>
                    <option value="VAR">Variété</option>
                    <option value="SVAR">Sous-Variété</option>
                    <option value="FO">Forme</option>
                    <option value="SSFO">Sous-Forme</option>
                    <option value="RACE">Race</option>
                    <option value="CAR">Cultivar</option>
                    <option value="AB">Abberatio</option>
                </select>
            </li>
        </ul>
    </div>


    <div id="recherche_barre">
        <input type="text" name="taxaName" placeholder="Nom de taxon" id="taxaName" required>
        <input type="submit" value="Rechercher" onclick="searchApi()">
    </div>

    <div id="resultats">
        <ul id="liste">
        </ul>
    </div>

    <div id="pagination-container">
    </div>

<?php
    // RECHERCHE API EN PHP NON UTILISEE
//        if (isset($taxaArrays)) {
//            echo '<div id="resultats">
//                        <ul id="liste">';
//            foreach ($taxaArrays as $taxa) {
//                $taxaId = $taxa->getId();
//                $taxaName = $taxa->getVernacularName();
//
//                // Get the image
//                $taxaMedia = $taxa->getLinks()['media']['href'];
//                $mediaContent = file_get_contents($taxaMedia);
//                $mediaData = json_decode($mediaContent, true);
//
//                // Check if the image is valid
//                if (!empty($mediaData['_embedded']['media'][0]['_links']['file']['href'])) {
//                    $taxonThumbnailUrl = $mediaData['_embedded']['media'][0]['_links']['file']['href'];
//                    $resultat['taxonMedia'] = $taxonThumbnailUrl;
//                    $image = $resultat['taxonMedia'];
//
//                    if(!@is_array(getimagesize($image))){
//                        $image = 'Orissa/../assets/img/taxaUnavailable.png';
//                    }
//                } else $image = 'Orissa/../assets/img/taxaUnavailable.png';
//                echo '
//                        <li>
//                            <div class="image">
//                                <a href="/Orissa/Taxa/' . $taxaId . '" class="imageLink">
//                                    <img src="' . $image . '" alt="image">
//                                </a>
//                            </div>
//
//                            <div class="caption">
//                                <p>' . $taxaName . '</p>
//                            </div>
//                        </li>';
//            }
//            echo '    </ul>
//                </div>';
//        }
//    ?>
</div>