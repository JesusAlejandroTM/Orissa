<?php

    namespace App\Code\Lib;
    use App\Code\Model\HTTP\Session;

    class FlashMessages
    {
        private static string $cleFlash = "_flashMessage";

        /**
         * Add a message to the session to be displayed on the next page
         * @param string $type the type of the message (success, info, warning, danger)
         * @param string $message
         * @return void
         */
        public static function add(string $type, string $message) : void
        {
            if ($session = Session::getInstance()) {
                $messageData = array($type, $message);
                $cookieData = serialize($messageData);
                $session->save(static::$cleFlash, $cookieData);
            }
        }

        /**
         * Check if a message is stored in the session
         * @return bool true if a message is stored in the session, false otherwise
         */
        public static function containsMessage() : bool
        {
            $session = Session::getInstance();
            return $session->contains(static::$cleFlash);
        }

        /**
         * Read the message stored in the session and delete it
         * @return string|bool the message if it exists, false otherwise
         */
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

        /**
         * Execute the message stored in the session if it exists
         * @return void
         */
        public static function executeMessage(): void
        {
            if (FlashMessages::containsMessage()) {
                echo FlashMessages::readMessage();
            }
        }

        /**
         * Convert a message array to HTML to be displayed in the view
         * @param array $messageArray the message array to convert
         * @return string the message converted to HTML
         */
        private static function convertMessageToHTML(array $messageArray) : string
        {
            return '<div class="alert alert-'. $messageArray[0] . '" role="alert">' .
                '<strong>' . ucwords($messageArray[0]) . '!</strong>' . '&nbsp' . $messageArray[1]
                . '</div>';
        }
    }