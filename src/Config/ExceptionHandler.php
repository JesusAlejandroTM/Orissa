<?php

    namespace App\Code\Config;

    use Exception;

    class ExceptionHandler
    {
        /**
         * All error messages used in the application are stored here with their corresponding error code
         * @var array|string[] $errorMessages array of error messages
         */
        protected static array $errorMessages = [
            103 => "Vérifiez votre nom d'utilisateur ou votre mot de passe",
            104 => "Cet utilisateur existe déjà",
            105 => "Erreur durant la suppréssion de votre compte, veuillez réessayer",
            203 => "Ce taxon n'existe pas",
            204 => "Ce taxon n'a pas de fiche d'informations disponible",
            205 => "Ce taxon n'a pas de fiche d'interactions disponible",
            301 => "Erreur pendant la requête à l'API",
            302 => "Erreur avec le décodage de votre requête",
            303 => "Taxa introuvable",
            304 => "Les caractères spéciaux ne sont pas autorisés",
            404 => "Cette page n'existe pas!",
            501 => "Vérifiez vos données",
            605 => "Erreur dans la création de naturothèque",
            606 => "Vous avez déjà une naturothèque avec ce titre",
            607 => "Erreur ajout des taxons dans votre naturothèque",
            608 => "Vous n'avez pas l'autorisation d'accéder à cette naturothèque",
            609 => "Vous n'avez pas l'autorisation de supprimer cette naturothèque",
            610 => "Erreur durant la suppréssion de votre naturothèque, veuillez réessayer",
        ];

        /**
         * Throw an exception with the corresponding error code
         * @param $errorCode int the error code
         * @return void
         * @throws Exception the exception with the error code
         */
        private static function throwException(int $errorCode): void
        {
            throw new Exception('Erreur ' . $errorCode . ': ', $errorCode);
        }

        public static function triggerException($errorCode): Exception
        {
            return new Exception('Erreur ' . $errorCode . ': ', $errorCode);
        }

        /**
         * Get the error message corresponding to the error code
         * @param int $errorCode the error code
         * @return string the error message
         */
        public static function getErrorMessage(int $errorCode): string
        {
            return self::$errorMessages[$errorCode] ?? 'Erreur inconnue';
        }

        /**
         * Check if the value is over a limit
         * @param int $value the value to check
         * @param int $limit the limit to check
         * @param int $errorCode the error code to throw if the value is over the limit
         * @return void
         * @throws Exception the exception with the error code
         */
        public static function checkIsOverLimit(int $value, int $limit, int $errorCode): void
        {
            if ($value > $limit)
                self::throwException($errorCode);
        }

        /**
         * Check if the value is equal to another value
         * @param mixed $value1 the first value to check
         * @param mixed $value2 the second value to check
         * @param int $errorCode the error code to throw if the values are not equal
         * @return void
         * @throws Exception the exception with the error code
         */
        public static function checkIsEqual(mixed $value1, mixed $value2, int $errorCode): void
        {
            if ($value1 !== $value2)
                self::throwException($errorCode);
        }

        /**
         * Check if the value is an instance of a class name
         * @param mixed $instance the instance to check
         * @param string $instanceClassName the class name to check
         * @param int $errorCode the error code to throw if the instance is not an instance of the class name
         * @return void
         * @throws Exception the exception with the error code
         */
        public static function checkIsInstanceOf(mixed $instance, string $instanceClassName, int $errorCode): void
        {
            if (!$instance instanceof $instanceClassName) {
                self::throwException($errorCode);
            }
        }


        /**
         * Check if the passed value is true
         * If the value is an array, check if all the values inside are true
         * @param mixed $value the value to check, can be an array
         * @param int $errorCode the error code to throw if the value is not true
         * @return void
         * @throws Exception the exception with the error code
         */
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