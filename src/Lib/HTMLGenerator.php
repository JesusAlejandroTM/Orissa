<?php

    namespace App\Code\Lib;

    use App\Code\Model\API\BiogeographicStatusIdentifier;
    use App\Code\Model\API\RedListIdentifier;

    /**
     * Class HTMLGenerator
     * Generates HTML strings for displaying data in the views
     * @package App\Code\Lib
     */
    class HTMLGenerator
    {
        /**
         * Generates an HTML unit for a taxa in the library view
         * @param int $taxaId the id of the taxa
         * @return string the HTML unit
         */
        public static function GenerateTaxaUnitHTML(int $taxaId) : string
        {
            return '
            <li>
                <div class="image">
                    <a id="' . $taxaId .'" href="/Orissa/Taxa/' . $taxaId . '" class="taxaLink">
                        <img class="taxaHref" src="Orissa/../assets/img/taxaUnavailable.png" alt="image">
                    </a>
                </div>
                <div class="caption">
                    <p class="taxaName"></p>
                </div>
            </li>';
        }

        /**
         * Generates an HTML unit for a library in the list of libraries view
         * @param int $libraryId the id of the library
         * @param string $libraryTitle the title of the library
         * @return string the HTML unit
         */
        public static function GenerateLibraryUnitHTML(int $libraryId, string $libraryTitle): string
        {
            return '
           <div class="libraryUnit">
                <div class="imageSpace" id="imageSpace">
                    <div class="boutonLock">
                        <a href="Library/' . $libraryId . '/Delete">
                        <img id="img" src="assets/img/delete_image.png" alt="delete">
                        
                    </div>
                    </a>
                </div>
                <div class="name-library">
                    <a href="Library/' . $libraryId . '" class="libraryLink">' . $libraryTitle . '</a>
                </div>
            </div>';
        }

        /**
         * Generates an HTML unit for a registered taxa in the profile view
         * @param int $taxaId the id of the taxa
         * @return string the HTML unit
         */
        public static function GenerateRegisteredProfileHTML(int $taxaId): string
        {
            return '
           <div class="libraryUnit">
                <div class="imageSpace" id="imageSpace">
                    <a id="' . $taxaId . '" href="Taxa/' . $taxaId . '" class="libraryLink">
                    </a>
                </div>
                <div class="name-library" id="name-library">
                    <span class="innerName"></span>
                </div>
            </div>';
        }


        /**
         * Generates an HTML unit for an interaction in the profile view
         * @param int $sourceId the id of the source taxa
         * @param string $sourceName the name of the source taxa
         * @param string $relationId the id of the relation
         * @param string $relationName the name of the relation
         * @return string the HTML unit
         */
        public static function GenerateInteractionTableRow(int    $sourceId, string $sourceName,
                                                           string $relationId, string $relationName) : string
        {
            return '
            <tr>
                <td><a class="interactionLink" href="Taxa/' . $sourceId . '">' . $sourceId . '</a></td>
                <td>' . $sourceName . '</td>
                <td>' . $relationId . '</td>
                <td>' . $relationName . '</td>
            </tr>
            ';
        }

        /**
         * Generates an interaction table for the taxa view using GenerateInteractionTableRow
         * @param array $interactions the interactions to display
         * @return string the HTML table
         */
        public static function GenerateInteractionTable(array $interactions) : string
        {
            $tableRowsHTML = '';
            foreach ($interactions as $row) {
                $sourceTaxaId = $row['taxon']['id'];
                $sourceTaxaName = $row['taxon']['fullNameHtml'];
                $relationId = $row['relationId'];
                $relationName = $row['relationName'];
                $tableRowsHTML .= self::GenerateInteractionTableRow($sourceTaxaId, $sourceTaxaName,
                    $relationId, $relationName);
            }
            return
            '
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
                    <tbody>'
                    .
                    $tableRowsHTML
                    .
                    '</tbody>
                </table>
            </div>';
        }

        /**
         * Generates an HTML unit for an entire red list status in the taxa view
         * @param string $worldStatus the world status
         * @param string $europeStatus the european status
         * @param string $nationalStatus the national status
         * @param string $localStatus the local status
         * @return string
         */
        public static function GenerateRedListHTML(string $worldStatus, string $europeStatus,
                                                   string $nationalStatus, string $localStatus): string
        {
            $html = "<h3>Status listes rouges </h3>";

            $html .= self::generateRedListHTMLBlock("Liste rouge international", $worldStatus);
            $html .= self::generateRedListHTMLBlock("Liste rouge européen", $europeStatus);
            $html .= self::generateRedListHTMLBlock("Liste rouge nationale", $nationalStatus);
            $html .= self::generateRedListHTMLBlock("Liste rouge locale", $localStatus);

            return $html;
        }

        /**
         * Generates an HTML block for a single red list status
         * @param string $title the title of the block
         * @param string $status the status string
         * @return string
         */
        private static function generateRedListHTMLBlock(string $title, string $status): string
        {
            $status = str_replace(',', '', $status);
            $htmlBlock = "<p>$title : ";

            foreach (str_split($status, 2) as $char) {
                $statusName = RedListIdentifier::GetAcronymDescription($char);
                if ($char == ',') continue;
                $htmlBlock .= "$statusName, ";
            }

            return rtrim($htmlBlock, ', ') . "</p>";
        }

        /**
         * Generates an HTML unit for the header logo in the header view depending on the user session
         * @return string the HTML unit
         */
        public static function GenerateHeaderLogo(): string
        {
            if (UserSession::isConnected()) {
                $link = 'Profile';
                $icon = 'people-outline';
            } else {
                $link = 'Login';
                $icon = 'log-in-outline';
            }

            return '
            <a href="' . $link . '">
            <span>
                <ion-icon name="' . $icon . '" class="searchBtn"></ion-icon>
            </span>
            </a>';
        }


        /**
         * Generates an HTML unit for the biogeo status in the taxa view
         * Multiple biogeo status can be displayed at the same time
         * @param string $statusIds the ids of the biogeo status to display, can be separated by commas (ex: 'A,E')
         * @return string
         */
        public static function GenerateBiogeographicStatusHTML(string $statusIds) : string
        {
            $html = "<h3>Status biogéographique</h3>";
            for ($i = 0; $i < strlen($statusIds); $i++)
            {
                $char = $statusIds[$i];
                $statusName = BiogeographicStatusIdentifier::GetBiogeographicStatusName($char);
                if ($i == 0) $html .= "<h4>$statusName";
                else if ($char == ',') continue;
                else $html .= ", $statusName";
            }
            $html .= '</h4>';
            for ($i = 0; $i < strlen($statusIds); $i++)
            {
                $char = $statusIds[$i];
                if ($char == ',') continue;
                $statusName = BiogeographicStatusIdentifier::GetBiogeographicStatusDescription($char);
                $html .= "<p>$statusName</p>";
            }
            return $html;
        }
    }