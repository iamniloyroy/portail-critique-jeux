<?php
session_start();
require_once '../includes/config-bdd.php';
require_once 'functions_DB.php';
require_once 'functions_query.php';

if (isset($_POST['login']) && isset($_POST['password'])) {
    $mysqli = connectionDB();
    $login = mysqli_real_escape_string($mysqli, $_POST['login']);
    $password = mysqli_real_escape_string($mysqli, $_POST['password']);
    $user = login($mysqli, $login, $password);
    if ($user) {
        $_SESSION['login'] = $login;
        $_SESSION['role'] = $user[0]['role'];
        closeDB($mysqli);
        header('Location: ../index.php');
    } else {
        header('Location: ../connexion.php?erreur=1');
    }
} else {
    header('Location: ../connexion.php');
}



?>