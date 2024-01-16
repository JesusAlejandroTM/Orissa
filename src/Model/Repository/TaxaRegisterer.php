<?php

    namespace App\Code\Model\Repository;

    use App\Code\Lib\UserSession;

    class TaxaRegisterer
    {
        public static function RegisterTaxa(int $taxaId)
        {
            $user = UserSession::getLoggedUser();

        }
    }