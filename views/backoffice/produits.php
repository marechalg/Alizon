<?php //require_once '/var/www/controllers/pdo.php' ;
    // $stmt = $pdo->query("SELECT * FROM _client");
    // $clients = $stmt->fetchAll(PDO::FETCH_ASSOC); 
    // print_r ($clients);
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
        <?php require_once './partials/headerMain.php' ?>

        <?php require_once './partials/aside.php' ?>

        <main class="produitBackOffice">
            <h1>Produits en Vente</h1>
            <section>
                <article>
                    <img src="/public/images/rilletes.svg" alt="">
                    <div class="nomEtEvaluation">
                        <p>Rillettes</p>
                        <div class="evaluation">
                            <div class="etoiles">
                                <img src="/public/images/etoile.svg"" alt="">
                                <p>3</p>
                            </div>
                            <p>200 évaluation</p>
                        </div>
                    </div>
                    <div class="prix">
                        <p>29.99 €</p>
                        <p>99.72€ / kg</p>
                    </div>
                    <div>
                        <img src="/public/images/iconeFiltre.svg" alt="">
                        <button> Options</button>
                    </div>

                </article>
            </section>
        </main>

        <?php require_once './partials/footer.php' ?>
    </body>
</html>