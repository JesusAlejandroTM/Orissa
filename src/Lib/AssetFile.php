<?php

    namespace App\Web\Lib;

    use App\Code\Config\Conf;

    class AssetFile
    {
        private static string $assetDirectory = '/assets';

        private static string $imgDirectory = '/img/';
        private static string $cssDirectory = '/css/';

        private static function getAssetDirectory() : string {
            return static::$assetDirectory;
        }

        private static function getImgDirectory(): string
        {
            return self::$imgDirectory;
        }

        private static function getCssDirectory(): string
        {
            return self::$cssDirectory;
        }

        public static function getImageFile(string $filename) : void {
            echo '<img src="'. Conf::getBaseUrl() . self::getAssetDirectory() . self::getImgDirectory() . $filename . ' alt="' . $filename. '">';
        }

        public static function getCssFile(string $filename) : void {
            echo '<link rel="stylesheet" href="'. Conf::getBaseUrl() . self::getAssetDirectory() . self::getCssDirectory() . $filename . '">';
        }

    }