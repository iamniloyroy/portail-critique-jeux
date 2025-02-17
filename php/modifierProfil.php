<?php

session_start();
require_once '../includes/config-bdd.php';
require_once 'functions_DB.php';
require_once 'functions_query.php';

$mysqli = connectionDB();
if (isset($_POST['login'])){
    $mysqli = connectionDB();
    $login = $_POST['login'];
    $mot_de_passe = $_POST['pwd'];
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $date_naissance = $_POST['date_naissance'];
    $adresse_mail = $_POST['email'];
    
    
    $date_naissance = date('Y-m-d', strtotime($date_naissance));
    
    updateProfile($mysqli,$login,$mot_de_passe,$nom,$prenom,$date_naissance,$adresse_mail);
    
    
    closeDB($mysqli);
    header('Location: ../profil.php?login='.$login.'');
    } else {
    header('Location: ../signup.php');
    }

?>