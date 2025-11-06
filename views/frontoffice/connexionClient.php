<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../public/style.css">
    <title>Page de connexion</title>
</head>

<body class="pageConnexionCLient">
    <?php include '../../views/frontoffice/partials/headerDeconnecte.php'; ?>

    <main>
        <div class="profile">
            <img src="../../public/images/utilLightBlue.svg" alt="">
        </div>
        <h2>Connexion à votre compte Alizon</h2>

        <form action="">
            <input type="email" placeholder="Adresse mail ou numéro de téléphone*" class="inputConnexionClient">
            <input type="password" placeholder="Mot de passe*" class="inputConnexionClient">

            <div>
                <a href="#">Pas encore client ? Inscrivez-vous ici</a>
                <a href="#">Mot de passe oublié ? Cliquez ici</a>
                <button class="boutonConnexionClient">Se connecter</button>
            </div>
        </form>

        <p class="petitTexte">
            Alizon, en tant que responsable de traitement, traite les données recueillies à
            des fins de gestion de la relation client, gestion des commandes et des livraisons,
            personnalisation des services, prévention de la fraude, marketing et publicité ciblée.
            Pour en savoir plus, reportez-vous à la Politique de protection de vos données personnelles
        </p>
    </main>

    <?php include '../../views/frontoffice/partials/footerDeconnecte.php'; ?>
</body>

</html>