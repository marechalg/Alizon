<?php
require_once '../../controllers/pdo.php';
require_once '../../controllers/prix.php';
require_once '../../controllers/date.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alizon</title>

    <link rel="stylesheet" href="../../public/style.css">
    <link rel="icon" href="/public/images/logoBackoffice.svg">
</head>

<body class="backoffice">
    <?php require_once './partials/header.php' ?>

    <?php require_once './partials/aside.php' ?>

    <main class="modifierProduit">
    
    <?php require_once './partials/retourEnHaut.php' ?>
    
    </main>

    <?php require_once './partials/footer.php' ?>

    <script src="../../public/amd-shim.js"></script>
    <script src="../../public/script.js"></script>
</body>

</html>