<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <base href="http://localhost/Orissa/">
    <title><?php if (isset($pageTitle)) echo $pageTitle ?></title>
    <?php  if (isset($cssArray)) {
        foreach ($cssArray as $cssFile){
            echo '<link rel="stylesheet" href="Orissa/../assets/css/' . $cssFile . '">';
        }
    } ?>
</head>