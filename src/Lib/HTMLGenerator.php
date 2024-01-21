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
    }