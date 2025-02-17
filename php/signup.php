<?php
session_start();
require_once '../includes/config-bdd.php';
require_once 'functions_DB.php';
require_once 'functions_query.php';

$mysqli = connectionDB();
if (isset($_POST['login'])){
$login = mysqli_real_escape_string($mysqli, $_POST['login']);
$mot_de_passe = mysqli_real_escape_string($mysqli, $_POST['mdp']);
$nom = mysqli_real_escape_string($mysqli, $_POST['nom']);
$prenom = mysqli_real_escape_string($mysqli, $_POST['prenom']);
$adresse_mail = mysqli_real_escape_string($mysqli, $_POST['email']);
$date_naissance = mysqli_real_escape_string($mysqli, $_POST['date_naissance']);

$date_naissance = date('Y-m-d', strtotime($date_naissance));

$date_derniere_connexion = date('Y-m-d H:i:s');
$date_creation = date('Y-m-d H:i:s');

if (checkLogin($mysqli,$login)){
    signup($mysqli,$login,$mot_de_passe,$nom,$prenom,$date_naissance,$adresse_mail);
    $_SESSION['login'] = $login;
    $_SESSION['role'] = 'utilisateur';
    header('Location: ../index.php');
} else {
    header('Location: ../inscription.php?erreur=1');
}
} else {
    header('Location: ../index.php');
}

closeDB($mysqli);
?>