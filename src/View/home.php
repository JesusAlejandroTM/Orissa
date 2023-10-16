<html lang="fr">
<head>
    <link rel="stylesheet" type="text/css" href="./../../assets/css/style.css">
    <meta charset="UTF-8">
    <title><?php if (isset($pagetitle)) echo $pagetitle; ?></title>
</head>
<body>
<header>
</header>
<main>
    <p>Hello there</p>
    <?php
        if (isset($cheminVueBody)) require __DIR__ . $cheminVueBody;
    ?>
    <a href="Home">Home</a>
    <a href="Login">Login</a>
</main>
<footer>
    <p>
        ORISSA
    </p>
</footer>
</body>
</html>
