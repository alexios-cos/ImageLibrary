<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title><?= $this->head['title'] ?> </title>
    <meta name="description" content="<?= $this->head['description'] ?>">
    <link href="resources/css/styles.css" rel="stylesheet" type="text/css">
</head>

<body>
    <div id="content-container">
        <?php
        /** @var app\Views\ViewModel $this */
        $this->renderView('root-content');
        ?>
    </div>
    <script src="resources/js/jQuery/jQuery-3.4.1.js"></script>
    <script src="resources/js/DataCollector.js"></script>
    <script src="resources/js/Notifier.js"></script>
    <script src="resources/js/Validator.js"></script>
    <script src="resources/js/EventsHandler.js"></script>
</body>

</html>
