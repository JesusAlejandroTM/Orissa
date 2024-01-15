<!DOCTYPE html>
<html lang="fr">
<?php
    // Require the head of HTML
    require_once(__DIR__ . '/../../assets/html/head.php');?>

<body>
<?php
    // Require the header of HTML
    require_once(__DIR__ . '/../../assets/html/header.php');

    // Check message if there's one
    App\Code\Lib\FlashMessages::executeMessage();


    // Require the view from path
    if (isset($pathViewBody)) require __DIR__ . $pathViewBody;

    // Require the footer of HTML
    require_once(__DIR__ . '/../../assets/html/footer.html');
    ?>
</body>
</html>


