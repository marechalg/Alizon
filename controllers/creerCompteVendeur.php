<?php
    require_once "pdo.php";

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nom_contact = $_POST['nom_contact'] ?? '';
    $prenom_contact = $_POST['prenom_contact'] ?? '';
    $email = $_POST['email'] ?? '';
    $num_tel = $_POST['num_tel'] ?? '';
    $nom_utilisateur = $_POST['nom_utilisateur'] ?? '';
    $mdp = $_POST['mdp'] ?? '';
    $date_naissance = $_POST['date_naissance'] ?? '';
    $confimer_mdp = $_POST['confimer_mdp'] ?? ''; 
    $num_siren = $_POST['num_siren'] ?? '';
    $adresse_entreprise = $_POST['adresse_entreprise'] ?? '';
    $raison_sociale = $_POST['raison_sociale'] ?? '';

    $sql = "INSERT INTO _vendeur 
        (nom, prenom, email, tel, utilisateur, mdp, dateNaissance, confirmMdp, siren, adresse, sociale)
        VALUES (:nom, :prenom, :email, :tel, :utilisateur, :mdp, :dateNaissance, :confirmMdp, :siren, :adresse, :sociale)";

    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        ':nom' => $nom_contact,
        ':prenom' => $prenom_contact,
        ':email' => $email,
        ':tel' => $num_tel,
        ':utilisateur' => $nom_utilisateur,
        ':mdp' => $mdp,
        ':dateNaissance' => $date_naissance,
        ':confirmMdp' => $confimer_mdp,
        ':siren' => $num_siren,
        ':adresse' => $adresse_entreprise,
        ':sociale' => $raison_sociale,
    ]);
    }


    session_start();  
    $id_session = session_id();
    $_SESSION['id_session'] = $id_session;
    header('Location: ../views/backoffice/accueil.php');
    exit();
?>