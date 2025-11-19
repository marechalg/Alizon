<?php require_once "../../controllers/pdo.php" ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../public/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <title>Ajouter un produit au catalogue</title>
</head>
<body class="backoffice">
    <header>
        <?php require_once "./partials/header.php"?>
    </header>
    <?php require_once "./partials/aside.php"?>
        
    <main class="AjouterProduit"> 
        <div class="product-content">
            
            <div class="left-section">
                <div class="ajouterPhoto" id="zoneUpload">
                    <input type="file" id="photoUpload" name="photo" accept="image/*" hidden>
                    
                    <div class="etat-vide" id="etatVide">
                        <div class="icone-wrapper">
                            <img src="../../../public/images/ajouterPhoto.svg" alt="Icône ajout">
                        </div>
                        <p>Cliquer pour ajouter une photo</p>
                    </div>

                    <div class="etat-preview" id="etatPreview" style="display: none;">
                        <img src="" alt="Prévisualisation du produit" id="imagePreview">
                        <div class="overlay-modifier">
                            <span>Cliquer pour modifier la photo</span>
                        </div>
                    </div>
                </div>

                <div class="form-details">
                    <input type="text" class="product-name-input" placeholder="Intitulé du produit" required>
                
                    <div class="price-weight-kg">
                        <input type="text" placeholder="Prix" required>
                        <input type="text" placeholder="Poids" required>
                        <span class="prix-kg-label">Prix au Kg:</span>
                    </div>

                    <input type="text" class="keywords-input" placeholder="Mots clés (séparés par des virgules)">
                </div>
            </div>

            <div class="right-section">
                <div class="product-desc-box">
                    <label for="product-description">Description du produit</label>
                    <textarea id="product-description" placeholder="Description de votre produit" maxlength="1000"></textarea>
                    <div class="char-count">0/1000</div> 
                </div>

                <div class="form-actions">
                    <a href="#"><button type="button" class="btn-previsualiser">Prévisualiser</button></a>
                    <a href="#"><button type="button" class="btn-annuler">Annuler</button></a>
                    <a href="#"><button type="submit" class="btn-ajouter">Ajouter le produit</button></a>
                </div>
            </div>
        </div>
    </main>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const zoneUpload = document.getElementById('zoneUpload');
        const photoInput = document.getElementById('photoUpload');
        const etatVide = document.getElementById('etatVide');
        const etatPreview = document.getElementById('etatPreview');
        const imagePreview = document.getElementById('imagePreview');

        // Clic sur la zone déclenche l'input file
        zoneUpload.addEventListener('click', function() {
            photoInput.click();
        });

        // Changement de fichier
        photoInput.addEventListener('change', function() {
            const file = this.files[0];
            
            if (file && file.type.startsWith('image/')) {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    imagePreview.src = e.target.result;
                    // Basculer l'affichage
                    etatVide.style.display = 'none';
                    etatPreview.style.display = 'block';
                    // Ajouter une classe pour le style si besoin
                    zoneUpload.classList.add('has-image');
                };
                
                reader.readAsDataURL(file);
            } else {
                // Réinitialiser si pas d'image ou annulation (optionnel selon le comportement souhaité sur annulation)
                // Si on veut garder l'ancienne image en cas d'annulation, ne rien faire ici.
                // Si on veut tout reset en cas de fichier invalide :
                if(this.files.length > 0) { // Si un fichier invalide a été choisi
                    alert("Veuillez sélectionner une image valide.");
                }
            }
        });
    });
    </script>

    <?php require_once "./partials/footer.php"?>
</body>
</html>