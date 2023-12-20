<?php

    namespace App\Code\Config;

    use Exception;

    class ExceptionHandler
    {
        // 100 = users
        // 200 = taxas
        // idk for the rest
        protected static array $errorMessages = [
            103 => "Vérifiez votre nom d'utilisateur ou votre mot de passe",
            104 => "Cet utilisateur existe déjà",
            204 => "Ce taxon n'a pas de fiche d'informations disponible",
            205 => "Ce taxon n'a pas de fiche d'interactions disponible",
            404 => "Page non trouvée",
            301 => "Erreur pendant la requête à l'API",
            302 => "Erreur avec le décodage de votre requête",
            303 => "Taxa introuvable",
        ];

        private static function throwException($errorCode): void
        {
            throw new Exception('Erreur ' . $errorCode . ': ', $errorCode);
        }

        public static function triggerException($errorCode): Exception
        {
            return new Exception('Erreur ' . $errorCode . ': ', $errorCode);
        }

        public static function getErrorMessage(int $errorCode): string
        {
            return "Erreur $errorCode : " . self::$errorMessages[$errorCode] ?? 'Erreur inconnue';
        }

        // INVALID ARGUMENT EXCEPTIONS HANDLING DANS LES 100
        public static function checkIsOverLimit($value, int $limit, int $errorCode): void
        {
            if ($value > $limit)
                self::throwException($errorCode);
        }

        public static function checkIsEqual(mixed $value1, mixed $value2, int $errorCode): void
        {
            if ($value1 !== $value2)
                self::throwException($errorCode);
        }

        public static function checkIsInstanceOf(mixed $instance, string $instanceClassName, int $errorCode): void
        {
            if (!$instance instanceof $instanceClassName) {
                self::throwException($errorCode);
            }
        }


        public static function checkIsTrue(mixed $value, int $errorCode): void
        {
            if (is_bool($value))
                if (!$value) {
                    self::throwException($errorCode);
                }
            if (is_array($value)) {
                foreach ($value as $bool) {
                    if (!$bool) {
                        self::throwException($errorCode);
                    }
                }
            }
        }
    }