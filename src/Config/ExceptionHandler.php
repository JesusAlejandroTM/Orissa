<?php

    namespace App\Code\Config;

    use Exception;

    class ExceptionHandler
    {
        protected static array $errorMessages = [
            101 => "Taxon n'existe pas",
            102 => "Erreur avec le décodage de votre requête",
            404 => "Page non trouvée",
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
        public static function checkValueOverLimit($value, int $limit, int $errorCode): void
        {
            if ($value > $limit)
                self::throwException($errorCode);
        }

        public static function checkValueEquality(mixed $value1, mixed $value2, int $errorCode): void
        {
            if ($value1 !== $value2)
                self::throwException($errorCode);
        }

        public static function checkInstanceClass(mixed $instance, string $instanceClassName, int $errorCode): void
        {
            if (!$instance instanceof $instanceClassName) {
                self::throwException($errorCode);
            }
        }


        public static function checkTrueValue(mixed $value, int $errorCode): void
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