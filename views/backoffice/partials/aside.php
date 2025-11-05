<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>

        <link rel="stylesheet" href="/public/style.css">
    </head>

    <body class="backoffice">
        <?php require_once './headerMain.php' ?>

        <aside class="backoffice">
            <ul>
                <li class="aside-btn here">
                    <figure>
                        <img src="/public/images/homeDarkBlue.svg">
                        <figcaption>Accueil</figcaption>
                    </figure>
                </li>
                <li class="aside-btn">
                    <figure>
                        <img src="/public/images/courbeDark.svg">
                        <figcaption>Statistiques</figcaption>
                    </figure>
                </li>
                <li class="aside-btn">
                    <figure>
                        <img src="/public/images/cartDarkBlue.svg">
                        <figcaption>Produits</figcaption>
                    </figure>
                </li>
                <li class="aside-btn">
                    <figure>
                        <img src="/public/images/boiteDark.svg">
                        <figcaption>Stock</figcaption>
                    </figure>
                </li>
                <li class="aside-btn">
                    <figure>
                        <img src="/public/images/chatDark.svg">
                        <figcaption>Avis</figcaption>
                    </figure>
                </li>
                <li class="aside-btn">
                    <figure>
                        <img src="/public/images/cartCheckDark.svg">
                        <figcaption>Commandes</figcaption>
                    </figure>
                </li>
                <li class="aside-btn">
                    <figure>
                        <img src="/public/images/enveloppeDark.svg">
                        <figcaption>Retours</figcaption>
                    </figure>
                </li>
            </ul>
        </aside>

        <?php require_once './footer.php' ?>

        <script type="module" src="/public/script.js"></script>
    </body>
</html>