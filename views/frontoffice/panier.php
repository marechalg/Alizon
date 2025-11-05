<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../public/style.css">
    <title>Alizon - Votre panier</title>
</head>
<body class="panier">
    <?php include "../../views/frontoffice/partials/headerConnecte.php"; ?>

    <main>
        <section class="listeProduit">
            <?php for ($i = 0; $i < 5; $i++) { ?> 
                <article>
                    <div class="imgProduit">
                        <input type="checkbox" name="selectionProduit" id="selectionProduit">
                        <img src="../../public/images/defaultImageProduitCard.png" alt="Image du produit">
                                        </div>
                        <div class="infoProduit">
                            <div>
                                <h2>Lot de rilettes bretonne</h2>
                                <h4>En stock</h4>
                            </div>
                            <div class="quantiteProduit">
                                <img src="../../public/images/minusDarkBlue.svg" alt="Symbole moins">
                                <p>0</p>
                                <img src="../../public/images/plusDarkBlue.svg" alt="Symbole plus">
                            </div>
                        </div>
                    <div class="prixOpt">
                        <h2><b>29.99€</b></h2>
                        <img src="../../public/images/binDarkBlue.svg" alt="Enelever produit">
                    </div>
                </article>
            <?php } ?>
        </section>
        <section class="recapPanier">
            <h1>Votre panier</h1>
            <div class="cardRecap">
                <article>
                    <h2><b>Récapitulatif de votre panier</b></h2>
                    <div class="infoCommande">
                        <section>
                            <h2>Nombres d'articles</h2>
                            <h2 class="val">0</h2>
                        </section>
                        <section>
                            <h2>Prix HT</h2>
                            <h2 class="val">0€</h2>
                        </section>
                        <section>
                            <h2>TVA</h2>
                            <h2 class="val">0€</h2>
                        </section>
                        <section>
                            <h2>Total</h2>
                            <h2 class="val">0€</h2>
                        </section>
                    </div>
                </article>
                <a href=""><p>Passer la commande</p></a>
            </div>
            <a href="" class="viderPanier">Vider le panier</a>
        </section>
    </main>

    <?php include "../../views/frontoffice/partials/footerConnecte.php"; ?>
</body>
</html>