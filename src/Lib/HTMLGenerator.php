<?php

    namespace App\Code\Lib;

    class HTMLGenerator
    {
        public static function GenerateTaxaUnitHTML(int $taxaId) : string
        {
            return '
            <li>
                <div class="image">
                    <a id="' . $taxaId .'" href="/Orissa/Taxa/' . $taxaId . '" class="imageLink">
                        <img class="taxaHref" src="BLANK" alt="image">
                    </a>
                </div>
                <div class="caption">
                    <p class="taxaName">BLANK</p>
                </div>
            </li>';
        }
    }