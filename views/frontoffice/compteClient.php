<?php


session_start();

if (!isset($_SESSION['user_data'])) {
    $_SESSION['user_data'] = [
        'pseudo' => 'nlehebel',
        'prenom' => 'Nathan',
        'nom' => 'Lehebel',
        'dateNaissance' => '2006-09-22', 
        'adresse1' => '12 Rue des Fleurs',
        'adresse2' => 'Bâtiment B, Appartement 34',
        'codePostal' => '75015',
        'ville' => 'Paris',
        'pays' => 'France',
        'telephone' => '0612345678',
        'email' => 'nathann.lehebel@gmail.com'
    ];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    //update la BDD avec les nouvelles infos du user



    $_SESSION['user_data'] = [
        'pseudo' => $_POST['pseudo'] ?? '',
        'prenom' => $_POST['prenom'] ?? '',
        'nom' => $_POST['nom'] ?? '',
        'dateNaissance' => $_POST['dateNaissance'] ?? '',
        'adresse1' => $_POST['adresse1'] ?? '',
        'adresse2' => $_POST['adresse2'] ?? '',
        'codePostal' => $_POST['codePostal'] ?? '',
        'ville' => $_POST['ville'] ?? '',
        'pays' => $_POST['pays'] ?? '',
        'telephone' => $_POST['telephone'] ?? '',
        'email' => $_POST['email'] ?? ''
    ];
    
    if (isset($_FILES['photoProfil']) && $_FILES['photoProfil']['tmp_name'] != '') {
        $id = 1;
        move_uploaded_file($_FILES['photoProfil']['tmp_name'], '../../public/images/photoDeProfil/photo_profil'.$id.'.png');
    }
}

$userData = $_SESSION['user_data'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Compte</title>
    <link rel="stylesheet" href="../../public/style.css">
</head>
<body>
    <?php include 'partials/headerConnecte.php'; ?>

    <main class="mainCompteClient">
        <form method="POST" enctype="multipart/form-data" action="">
            <div id="titreCompte">
                <div class="photo-container">
                    <?php 
                        $id = 1;
                        $photoPath = '../../public/images/photoDeProfil/photo_profil'.$id.'.png';
                        if (file_exists($photoPath)) {
                            echo '<img src="'.$photoPath.'?t='.time().'" alt="photoProfil" id="imageProfile">';
                        } else {
                            echo '<img src="../../public/images/profil.png" alt="photoProfil" id="imageProfile">';
                        }
                    ?>
                </div>
                <h1>Mon Compte</h1>
            </div>

            <section>
                <article>
                    <p><?php echo htmlspecialchars($userData['pseudo']); ?></p>
                    <p><?php echo htmlspecialchars($userData['nom']); ?></p>
                    <p><?php echo htmlspecialchars($userData['prenom']); ?></p>
                    <p><?php echo htmlspecialchars($userData['dateNaissance']); ?></p>
                </article>

                <article>
                    <p><?php echo htmlspecialchars($userData['adresse1']); ?></p>
                    <p><?php echo htmlspecialchars($userData['adresse2']); ?></p>
                    <div>
                        <p><?php echo htmlspecialchars($userData['codePostal']); ?></p>
                        <p><?php echo htmlspecialchars($userData['ville']); ?></p>
                    </div>
                    <p><?php echo htmlspecialchars($userData['pays']); ?></p>
                </article>

                <article>
                    <p><?php echo htmlspecialchars($userData['telephone']); ?></p>
                    <p><?php echo htmlspecialchars($userData['email']); ?></p>
                </article> 
            </section>

            <div id="buttonsCompte">
                <button type="button" onclick="popUpModifierMdp()" class="boutonModifierMdp">Modifier le mot de passe</button>
                <button type="button" class="boutonModiferProfil">Modifier</button>
            </div>
        </form>
    </main>
    
    <?php include 'partials/footerConnecte.php'; ?>

    <script>
        function popUpModifierMdp(){
            const overlay = document.createElement("div");
            overlay.className = "overlayPopUpCompteClient";
            overlay.innerHTML = `
                <main class="mainPopUpCompteClient">
                <h1>Modification de votre mot de passe</h1>
               
                <section>
                    <div class="formulaireMdp">
                        <form action="">
                            <input type="text" placeholder="Ancien mot de passe">
                            <input type="text" placeholder="Nouveau mot de passe">
                            <input type="text" placeholder="Confirmer le nouveau mot de passe">
                        
                            <article>
                                <div class="croix">
                                    <div></div>
                                    <div></div>
                                </div> 
                                <p>Longueur minimale de 12 charactères</p>
                            </article>

                            <article>
                                <div class="croix">
                                    <div></div>
                                    <div></div>
                                </div> 
                                <p>Au moins une minuscule / majuscule</p>
                            </article>

                            <article>
                                <div class="croix">
                                    <div></div>
                                    <div></div>
                                </div> 
                                <p>Au moins un chiffre</p>
                            </article>

                            <article>
                                <div class="croix">
                                    <div></div>
                                    <div></div>
                                </div>  
                                <p>Au moins un charactères spéciale</p>
                            </article>
                        </div>
                            <button type="button" onclick="fermerFenetre()">Valider</button>
                        </form>
                    </section>
                </main>`;
            document.body.appendChild(overlay);

        }

        function verifierChamp() {
            const bouton = document.querySelector(".boutonModiferProfil");
            const champs = document.querySelectorAll("section input");
            let tousRemplis = true;

            for (let i = 0; i < champs.length; i++) {
                let valeur = champs[i].value.trim();
                
                if (i !== 5 && valeur === "") {
                    tousRemplis = false;
                    break;
                }

                if (i === 9) { 
                    if (!/^0[67](\s[0-9]{2}){4}$/.test(valeur)) {
                        tousRemplis = false;
                        break;
                    }
                }

                if (i === 10) {
                    if (!/^[a-zA-Z0-9._-]+@[a-zA-Z0-9._-]+\.[a-zA-Z]{2,}$/.test(valeur)) {
                        tousRemplis = false;
                        break;
                    }
                }            
            }

            bouton.disabled = !tousRemplis;
        }

        let enModif = false;
        let ajoutPhoto = document.createElement("input");
        ajoutPhoto.type = "file";
        ajoutPhoto.id = "photoProfil";
        ajoutPhoto.name = "photoProfil";
        ajoutPhoto.accept = "image/*";
        ajoutPhoto.style.display = "none";
        ajoutPhoto.autocomplete = "off";
        
        let conteneur = document.getElementById("titreCompte");
        let imageProfile = document.getElementById("imageProfile");
        let bnModifier = document.getElementsByClassName("boutonModiferProfil");
        let bnModifMdp = document.getElementsByClassName("boutonModifierMdp");

        function modifierProfil(event) {
            event.preventDefault();

            if (!enModif) {
                let elems = document.querySelectorAll("section p");
                const nomsChamps = [
                    "pseudo", "nom", "prenom", "dateNaissance",
                    "adresse1", "adresse2", "codePostal", "ville", "pays",
                    "telephone", "email"
                ];

                for (let i = 0; i < elems.length; i++) {
                    let texteActuel = elems[i].innerText;
                    let input = document.createElement("input");
                    input.value = texteActuel;
                    input.name = nomsChamps[i];
                    input.id = nomsChamps[i];
                    input.autocomplete = nomsChamps[i];

                    if (i === 9) input.type = "tel";
                    else if (i === 10) input.type = "email";
                    else if (i === 3) input.type = "date";
                    else input.type = "text";

                    elems[i].parentNode.replaceChild(input, elems[i]);
                }

                bnModifier[0].innerHTML = "Enregistrer";
                bnModifier[0].style.backgroundColor = "#64a377";
                bnModifier[0].style.color = "#FFFEFA";
                conteneur.appendChild(ajoutPhoto);
                
                imageProfile.style.cursor = "pointer";
                imageProfile.onclick = () => ajoutPhoto.click();
                
                enModif = true;

                document.querySelector("section").addEventListener("input", verifierChamp);
                verifierChamp();

            } else {
                document.querySelector("form").submit();
            }
        }

        bnModifier[0].addEventListener("click", modifierProfil);

        function fermerFenetre(){
                window.close();
            }
    </script>
</body>
</html>