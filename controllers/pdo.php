<?php
include '../../config/config.php';
$dsn = "$driver:host=$server;port=$port;dbname=$dbname";
try {
    $pdo = new PDO($dsn, $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Erreur !: " . $e->getMessage();
}
?>


