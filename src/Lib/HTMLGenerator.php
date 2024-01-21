<?php

    namespace App\Code\Lib;

    class HTMLGenerator
    {
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

        public static function GenerateLibraryUnitHTML(int $libraryId, string $libraryTitle): string
        {
            return '
           <div class="libraryUnit">
                <div class="imageSpace">
                    <a href="Library/' . $libraryId . '" class="libraryLink">
                    <div class="backgroundLock">
                        <div class="boutonLock">
                            <div id="img"></div>
                        </div>
                    </div>
                    </a>
                </div>
                <div class="name-library">
                    <span class="innerName">' . $libraryTitle . '</span>
                </div>
            </div>';
        }
    }