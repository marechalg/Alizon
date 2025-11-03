<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">  
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link rel="stylesheet" href="../public/style/styleTemplate.css">
  <link rel="stylesheet" href="../public/style/styleAcceuil.css">
  <title>Alizon - Acceuil</title>
</head>
<body>
    <?php include '../views/partials/header.php'; ?>

    <section class="banniere">
        <img src="../public/images/leftArrowDarkBlue.svg" class="fleche" alt="Fleche vers la gauche">
        <div>
            <h1>Plus de promotion à venir !</h1>
            <img src="../public/images/defaultImageProduit.png" alt="Image de produit par défaut">
        </div>
        <img src="../public/images/rightArrowDarkBlue.svg" class="fleche" alt="Fleche vers la droite">
    </section>

    <main>
        <section>
            <div class="nomCategorie">
                <h2>Promotion</h2>
                <hr>
            </div>
            <div class="listeArticle">
                <?php for ($i=0 ; $i < 15 ; $i++) { ?>
                    <article>

                    </article>
                <?php } ?>
            </div>
        </section>

        <section>
            <div class="nomCategorie">
                <h2>Nouveautés</h2>
                <hr>
            </div>
            <div class="listeArticle">
                <?php for ($i=0 ; $i < 15 ; $i++) { ?>
                    <article>

                    </article>
                <?php } ?>
            </div>
        </section>

        <section>
            <div class="nomCategorie">
                <h2>Charcuteries</h2>
                <hr>
            </div>
            <div class="listeArticle">
                <?php for ($i=0 ; $i < 15 ; $i++) { ?>
                    <article>

                    </article>
                <?php } ?>
            </div>
        </section>

        <section>
            <div class="nomCategorie">
                <h2>Alcools</h2>
                <hr>
            </div>
            <div class="listeArticle">
                <?php for ($i=0 ; $i < 15 ; $i++) { ?>
                    <article>

                    </article>
                <?php } ?>
            </div>
        </section>

        <section>
            <div class="nomCategorie">
                <h2>Consultés récemment</h2>
                <hr>
            </div>
            <div class="listeArticle">
                <?php for ($i=0 ; $i < 15 ; $i++) { ?>
                    <article>

                    </article>
                <?php } ?>
            </div>
        </section>
    </main>

    <?php include '../views/partials/footer.php'; ?>
</body>
</html>