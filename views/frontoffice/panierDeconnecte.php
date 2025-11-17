<?php
require_once "../../controllers/pdo.php";

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../public/style.css">
    <title>Alizon - Votre panier</title>
</head>
<body class="panier">
    <?php include "../../views/frontoffice/partials/headerDeconnecte.php"; ?>

    <main>
        <section class="listeProduit">
            <?php foreach ($cart as $item) { ?>
                <article>
                    <div class="imgProduit">
                        <?php 
                            $idProduit = $item['idProduit'] ?? 0;
                            $stmtImg = $pdo->prepare("SELECT URL FROM _imageDeProduit WHERE idProduit = :idProduit");
                            $stmtImg->execute([':idProduit' => $idProduit]);
                            $imageResult = $stmtImg->fetch(PDO::FETCH_ASSOC);
                            $image = !empty($imageResult) ? $imageResult['URL'] : '../../public/images/defaultImageProduit.png';    
                        ?>
                    <img src="<?= htmlspecialchars($image) ?>" alt="<?= htmlspecialchars($item['nom'] ?? '') ?>">
                    </div>
                    <div class="infoProduit">
                        <div>
                            <h2><?= htmlspecialchars($item['nom'] ?? 'N/A') ?></h2>
                            <h4>En stock</h4>
                        </div>
                        <div class="quantiteProduit">
                        <button class="minus" data-id="<?= htmlspecialchars($item['idProduit'] ?? '') ?>">
                            <img src="../../public/images/minusDarkBlue.svg" alt="Symbole moins">
                        </button>                            
                        <p class="quantite"><?= htmlspecialchars($item['qty'] ?? 'N/A') ?></p> 
                        <button class="plus" data-id="<?= htmlspecialchars($item['idProduit'] ?? '') ?>">
                            <img src="../../public/images/plusDarkBlue.svg" alt="Symbole plus">
                        </button> 
                        </div>
                    </div>
                    <div class="prixOpt">
                    <?= htmlspecialchars($item['prix'] ?? 'N/A') ?>          
                    <button class="delete" data-id="<?= htmlspecialchars($item['idProduit'] ?? '') ?>">
                        <img src="../../public/images/binDarkBlue.svg" alt="Enlever produit">
                    </button>
                    </div>
                </article> 
            <?php } if ($cart==0) { ?>
                <h1 class="aucunProduit">Aucun produit</h1>
            <?php } else { ?>
        </section>
        <section class="recapPanier">
            <h1>Votre panier</h1>
            <div class="cardRecap">
                <article>
                    <?php  
                        $stmt = $pdo->query("SELECT idPanier FROM _panier WHERE idClient = $idClient ORDER BY idPanier DESC LIMIT 1");
                        $panier = $stmt ? $stmt->fetch(PDO::FETCH_ASSOC) : false;
                        
                        if ($panier) {
                            $idPanier = intval($panier['idPanier']);
                            
                            // Calcul en temps réel
                            $sqlTotals = "
                                SELECT 
                                    SUM(pap.quantiteProduit) AS nbArticles,
                                    SUM(p.prix * pap.quantiteProduit) AS prixHT,
                                    SUM(p.prix * pap.quantiteProduit * COALESCE(t.pourcentageTva, 20.0) / 100) AS prixTotalTvaPanier,
                                    SUM(p.prix * pap.quantiteProduit * (1 + COALESCE(t.pourcentageTva, 20.0) / 100)) AS sousTotal
                                FROM _produitAuPanier pap
                                JOIN _produit p ON pap.idProduit = p.idProduit
                                LEFT JOIN _tva t ON p.typeTva = t.typeTva
                                WHERE pap.idPanier = $idPanier
                            ";
                            
                            $stmt = $pdo->query($sqlTotals);
                            $totals = $stmt ? $stmt->fetch(PDO::FETCH_ASSOC) : [];
                        }
                    ?>

                    <h2><b>Récapitulatif de votre panier</b></h2>
                    <div class="infoCommande">
                        <section>
                            <h2>Nombres d'articles</h2>
                            <h2 class="val"><?= $totals['nbArticles'] ?? 0 ?></h2>
                        </section>
                        <section>
                            <h2>Prix HT</h2>
                            <h2 class="val"><?= number_format($totals['prixHT'] ?? 0, 2) ?>€</h2>
                        </section>
                        <section>
                            <h2>TVA</h2>
                            <h2 class="val"><?= number_format($totals['prixTotalTvaPanier'] ?? 0, 2) ?>€</h2>
                        </section>
                        <section>
                            <h2>Total</h2>
                            <h2 class="val"><?= number_format($totals['sousTotal'] ?? 0, 2) ?>€</h2>
                        </section>
                    </div>
                </article>
                <a href="../../views/frontoffice/pagePaiement.php"><p>Passer la commande</p></a>
            </div>
            <a href="" class="viderPanier">Vider le panier</a>
        </section>
        <?php } ?>
    </main>

    <?php include "../../views/frontoffice/partials/footerDeconnecte.php"; ?>

    <script src="../scripts/frontoffice/paiement-ajax.js"></script>
    <script src="../../public/amd-shim.js"></script>
    <script src="../../public/script.js"></script>
</body>
</html>