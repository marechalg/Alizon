<?php 
require_once "../../controllers/pdo.php";
session_start();

// Log de début de script
error_log("=== DÉBUT CONNEXION CLIENT ===");
error_log("Session ID: " . session_id());
error_log("Session data: " . print_r($_SESSION, true));

$error = '';
$email_tel = '';
$password = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    error_log("=== METHODE POST DÉTECTÉE ===");
    
    $email_tel = trim($_POST['email_tel']);
    $password_chiffre = trim($_POST['password_chiffre']); 
    
    error_log("Email/Tel reçu: " . $email_tel);
    error_log("Password chiffré reçu: " . $password_chiffre);
    error_log("Longueur password: " . strlen($password_chiffre));
    
    //email ou un numéro de téléphone
    if (filter_var($email_tel, FILTER_VALIDATE_EMAIL)) {
        //email
        error_log("Validation: Email détecté");
        $sql = "SELECT idClient, email, mdp, noTelephone, prenom, nom FROM _client WHERE email = ?";
    } else {
        // numéro de téléphone
        error_log("Validation: Téléphone détecté");
        $tel_clean = preg_replace('/[^0-9]/', '', $email_tel);
        $sql = "SELECT idClient, email, mdp, noTelephone, prenom, nom FROM _client WHERE REPLACE(noTelephone, ' ', '') = ?";
        $email_tel = $tel_clean;
        error_log("Téléphone nettoyé: " . $email_tel);
    }
    
    error_log("Requête SQL: " . $sql);
    error_log("Valeur recherchée: " . $email_tel);
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$email_tel]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($user) {
        error_log("=== UTILISATEUR TROUVÉ ===");
        error_log("ID Client: " . $user['idClient']);
        error_log("Email: " . $user['email']);
        error_log("MDP BDD: " . $user['mdp']);
        error_log("Longueur MDP BDD: " . strlen($user['mdp']));
        error_log("MDP Formulaire: " . $password_chiffre);
        error_log("Longueur MDP Formulaire: " . strlen($password_chiffre));
        
        // Comparaison détaillée
        error_log("Comparaison exacte: " . ($password_chiffre === $user['mdp'] ? 'TRUE' : 'FALSE'));
        error_log("Comparaison loose: " . ($password_chiffre == $user['mdp'] ? 'TRUE' : 'FALSE'));
        
        // Comparer les mots de passe chiffrés 
        if ($password_chiffre === $user['mdp']) {
            // Connexion réussie
            error_log("=== CONNEXION RÉUSSIE ===");
            
            $_SESSION['user_id'] = $user['idClient'];
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['user_name'] = $user['prenom'] . ' ' . $user['nom'];
            $_SESSION['user_prenom'] = $user['prenom'];
            $_SESSION['user_nom'] = $user['nom'];
            
            error_log("Session après connexion: " . print_r($_SESSION, true));
            
            // Redirection vers la page d'accueil apres connexion
            error_log("Redirection vers acceuilConnecte.php");
            header('Location: ../../views/frontoffice/acceuilConnecte.php');
            exit;
        } else {
            error_log("=== MOT DE PASSE INCORRECT ===");
            error_log("Différence de caractères:");
            for ($i = 0; $i < min(strlen($password_chiffre), strlen($user['mdp'])); $i++) {
                if ($password_chiffre[$i] !== $user['mdp'][$i]) {
                    error_log("Position $i: '" . $password_chiffre[$i] . "' vs '" . $user['mdp'][$i] . "'");
                    error_log("Code: " . ord($password_chiffre[$i]) . " vs " . ord($user['mdp'][$i]));
                }
            }
            $error = "Identifiants incorrects (mdp)";
        }
    } else {
        error_log("=== AUCUN UTILISATEUR TROUVÉ ===");
        error_log("Aucun utilisateur avec: " . $email_tel);
        $error = "Identifiants incorrects (user not found)";
    }
} else {
    error_log("=== METHODE GET ===");
}

error_log("=== FIN CONNEXION CLIENT ===");
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../public/style.css">
    <title>Page de connexion - DEBUG</title>
    <style>
    .debug-info {
        background: #f0f0f0;
        border: 1px solid #ccc;
        padding: 10px;
        margin: 10px 0;
        border-radius: 5px;
        font-family: monospace;
        font-size: 12px;
    }

    .debug-section {
        background: #e0e0e0;
        padding: 15px;
        margin: 15px 0;
        border-radius: 8px;
    }

    .debug-title {
        color: #333;
        font-weight: bold;
        margin-bottom: 10px;
    }

    .password-display {
        background: #ffeb3b;
        padding: 5px;
        border-radius: 3px;
        margin: 5px 0;
        word-break: break-all;
    }
    </style>
</head>

<body class="pageConnexionCLient">
    <?php include '../../views/frontoffice/partials/headerDeconnecte.php'; ?>

    <main>
        <div class="debug-section">
            <div class="debug-title">🔍 INFORMATIONS DE DÉBOGAGE</div>
            <div class="debug-info">
                <strong>Session ID:</strong> <?php echo session_id(); ?><br>
                <strong>User ID en session:</strong> <?php echo $_SESSION['user_id'] ?? 'Non connecté'; ?><br>
                <strong>Méthode:</strong> <?php echo $_SERVER['REQUEST_METHOD']; ?><br>
                <strong>Timestamp:</strong> <?php echo date('Y-m-d H:i:s'); ?>
            </div>
        </div>

        <div class="profile">
            <img src="../../public/images/utilLightBlue.svg" alt="">
        </div>
        <h2>Connexion à votre compte Alizon - DEBUG</h2>

        <?php if ($error): ?>
        <div class="error-message"
            style="color: red; margin-bottom: 15px; padding: 10px; background: #ffe6e6; border: 1px solid red;">
            <strong>❌ ERREUR:</strong> <?php echo htmlspecialchars($error); ?>
        </div>
        <?php endif; ?>

        <form id="loginForm" method="POST" action="">
            <div class="debug-section">
                <div class="debug-title">📝 FORMULAIRE</div>
                <input type="text" name="email_tel" placeholder="Adresse mail ou numéro de téléphone*"
                    class="inputConnexionClient" value="<?php echo htmlspecialchars($email_tel); ?>" required>
                <div class="debug-info">
                    Valeur: <strong><?php echo htmlspecialchars($email_tel); ?></strong>
                </div>

                <input type="password" id="password_input" placeholder="Mot de passe*" class="inputConnexionClient"
                    required>
                <div class="debug-info">
                    Mot de passe clair: <span id="password_debug">[saisir pour voir]</span>
                </div>

                <!-- Champ caché pour le mot de passe chiffré -->
                <input type="hidden" name="password_chiffre" id="password_chiffre">
                <div class="debug-info">
                    Mot de passe chiffré: <span id="password_chiffre_debug">[vide]</span>
                </div>
            </div>

            <div>
                <a href="inscriptionClient.php">Pas encore client ? Inscrivez-vous ici</a>
                <a href="#">Mot de passe oublié ? Cliquez ici</a>
                <button type="submit" class="boutonConnexionClient">Se connecter - DEBUG</button>
            </div>
        </form>

        <div class="debug-section">
            <div class="debug-title">🔧 TEST DE CHIFFREMENT</div>
            <div class="debug-info">
                <input type="text" id="test_password" placeholder="Testez un mot de passe ici"
                    style="width: 100%; padding: 5px; margin: 5px 0;">
                <button onclick="testChiffrement()">Tester le chiffrement</button>
                <div id="test_result" style="margin-top: 10px;"></div>
            </div>
        </div>

        <div class="debug-section">
            <div class="debug-title">📊 BASE DE DONNÉES (premiers utilisateurs)</div>
            <div class="debug-info">
                <?php
                try {
                    $stmt = $pdo->query("SELECT idClient, email, pseudo, LENGTH(mdp) as mdp_length, LEFT(mdp, 10) as mdp_preview FROM _client LIMIT 5");
                    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($users as $user) {
                        echo "ID: {$user['idClient']} | Email: {$user['email']} | Pseudo: {$user['pseudo']} | MDP Length: {$user['mdp_length']} | Preview: {$user['mdp_preview']}...<br>";
                    }
                } catch (Exception $e) {
                    echo "Erreur BD: " . $e->getMessage();
                }
                ?>
            </div>
        </div>

        <p class="petitTexte">
            Alizon, en tant que responsable de traitement, traite les données recueillies à
            des fins de gestion de la relation client, gestion des commandes et des livraisons,
            personnalisation des services, prévention de la fraude, marketing et publicité ciblée.
            Pour en savoir plus, reportez-vous à la Politique de protection de vos données personnelles
        </p>
    </main>

    <?php include '../../views/frontoffice/partials/footerDeconnecte.php'; ?>

    <script src="../../controllers/Chiffrement.js"></script>

    <script>
    console.log("=== DÉBUT SCRIPT JS ===");
    console.log("Fonction vignere disponible:", typeof vignere !== 'undefined');
    console.log("Clé disponible:", typeof cle !== 'undefined');

    // Affichage en temps réel du mot de passe
    document.getElementById('password_input').addEventListener('input', function() {
        const passwordClair = this.value;
        document.getElementById('password_debug').textContent = passwordClair;

        if (typeof vignere !== 'undefined') {
            const passwordChiffre = vignere(passwordClair, cle, 1);
            document.getElementById('password_chiffre_debug').textContent = passwordChiffre;
            document.getElementById('password_chiffre').value = passwordChiffre;
            console.log("Chiffrement:", passwordClair, "->", passwordChiffre);
        }
    });

    // Gestion de la soumission du formulaire
    document.getElementById('loginForm').addEventListener('submit', function(e) {
        console.log("=== SUBMIT FORMULAIRE ===");
        e.preventDefault();

        const passwordClair = document.getElementById('password_input').value;
        console.log("Password clair:", passwordClair);

        if (typeof vignere === 'undefined') {
            console.error("ERREUR: fonction vignere non disponible");
            alert("Erreur: système de chiffrement non chargé");
            return;
        }

        const passwordChiffre = vignere(passwordClair, cle, 1);
        console.log("Password chiffré:", passwordChiffre);

        document.getElementById('password_chiffre').value = passwordChiffre;

        // Afficher les valeurs finales
        console.log("Valeurs finales - Email/Tel:", document.querySelector('[name="email_tel"]').value);
        console.log("Valeurs finales - MDP chiffré:", passwordChiffre);

        // Soumettre le formulaire
        console.log("Soumission du formulaire...");
        this.submit();
    });

    // Fonction de test de chiffrement
    function testChiffrement() {
        const testInput = document.getElementById('test_password').value;
        if (!testInput) {
            alert("Veuillez saisir un mot de passe à tester");
            return;
        }

        if (typeof vignere === 'undefined') {
            document.getElementById('test_result').innerHTML =
                '<span style="color: red">❌ Fonction vignere non disponible</span>';
            return;
        }

        const chiffre = vignere(testInput, cle, 1);
        const dechiffre = vignere(chiffre, cle, -1);

        document.getElementById('test_result').innerHTML =
            '<div class="password-display"><strong>Original:</strong> ' + testInput + '</div>' +
            '<div class="password-display"><strong>Chiffré:</strong> ' + chiffre + '</div>' +
            '<div class="password-display"><strong>Déchiffré:</strong> ' + dechiffre + '</div>' +
            '<div><strong>Test:</strong> ' + (testInput === dechiffre ? '✅ SUCCÈS' : '❌ ÉCHEC') + '</div>';

        console.log("Test chiffrement:", {
            original: testInput,
            chiffre: chiffre,
            dechiffre: dechiffre,
            succes: testInput === dechiffre
        });
    }

    // Test automatique au chargement
    window.addEventListener('load', function() {
        console.log("=== PAGE CHARGÉE ===");
        console.log("Chiffrement test:", vignere ? "✅ Disponible" : "❌ Indisponible");

        // Petit test automatique
        if (typeof vignere !== 'undefined') {
            const test = vignere('test123', cle, 1);
            console.log("Test auto chiffrement 'test123':", test);
        }
    });
    </script>
</body>

</html>