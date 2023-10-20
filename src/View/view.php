<!DOCTYPE html>
<html lang="fr">
<?php require_once(__DIR__ . '/../../assets/html/head.php');?>
<body>
<?php require_once(__DIR__ . '/../../assets/html/header.php');
echo "<p> ----------HEAD ---------</p>";
if (isset($pathViewBody)) require __DIR__ . $pathViewBody;
echo "<p>----------FOOTER ---------</p>";
require_once(__DIR__ . '/../../assets/html/footer.php');?>
</body>
</html>


