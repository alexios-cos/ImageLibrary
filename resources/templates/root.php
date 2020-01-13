<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title><?= $this->head['title'] ?> </title>
    <meta name="description" content="<?= $this->head['description'] ?>">
    <link href="resources/css/styles.css" rel="stylesheet" type="text/css">
</head>

<body>
    <?php
        /** @var app\Views\ViewModel $this */
        $this->renderView('root-content');
    ?>
    <script src="resources/js/jquery/jquery-3.4.1.js"></script>
    <script src="resources/js/scripts.js"></script>
</body>

</html>
