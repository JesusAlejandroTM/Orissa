<!DOCTYPE html>
<html lang="fr">
<?php require_once(__DIR__ . '/../../assets/html/head.php');?>
<body>
<?php require_once(__DIR__ . '/../../assets/html/header.php');
echo "<p> ----------HEAD ---------</p>";
if (isset($cheminVueBody)) require __DIR__ . $cheminVueBody;
echo "<p>----------FOOTER ---------</p>";
require_once(__DIR__ . '/../../assets/html/footer.php');?>
</body>
</html>


