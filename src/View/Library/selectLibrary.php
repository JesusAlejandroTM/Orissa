<?php

    if (isset($library) && !is_string($library))
    {
        var_dump($library);
    }
    else {
        \App\Code\Lib\FlashMessages::add("warning", "Cette naturothèque n'existe pas");
        header("Location: /Orissa/Profile");
        exit();
    }
