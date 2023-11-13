<?php

    namespace App\Code\Lib;
    use App\Code\Model\HTTP\Session;

    class FlashMessages
    {
        private static string $cleFlash = "_flashMessage";

        public static function add(string $type, string $message) : void
        {
            if ($session = Session::getInstance()) {
                $messageData = array($type, $message);
                $cookieData = serialize($messageData);
                $session->save(static::$cleFlash, $cookieData);
            }
        }

        public static function containsMessage() : bool
        {
            $session = Session::getInstance();
            return $session->contains(static::$cleFlash);
        }

        public static function readMessage() : string|bool
        {
            if ($session = Session::getInstance()){
                $cookieData = $session->read(static::$cleFlash);

                if (!(is_null($cookieData))) {
                    $session->delete(static::$cleFlash);
                    $messageArray = unserialize($cookieData);
                    return self::convertMessageToHTML($messageArray);
                }
                else return false;
            }
            return false;
        }

        public static function executeMessage(): void
        {
            if (FlashMessages::containsMessage()) {
                echo FlashMessages::readMessage();
            }
        }

        private static function convertMessageToHTML(array $messageArray) : string
        {
            return '<div class="alert alert-'. $messageArray[0] . '" role="alert">' .
                '<strong>' . ucwords($messageArray[0]) . '!</strong> ' . $messageArray[1]
                . '</div>';
        }
    }