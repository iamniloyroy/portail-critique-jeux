<?php

session_start();
require_once '../includes/config-bdd.php';
require_once 'functions_DB.php';
require_once 'functions_query.php';

if (isset($_POST['titre']) && isset($_SESSION['login'])){
    $mysqli = connectionDB();
    $titre = mysqli_real_escape_string($mysqli, $_POST['titre']);
    $texte = mysqli_real_escape_string($mysqli, $_POST['contenu']);
    $note = mysqli_real_escape_string($mysqli, $_POST['note']);
    $id_article = $_POST['id'];
    $login = $_SESSION['login'];
    postAvis($mysqli,$id_article,$login,$titre,$texte,$note);
    closeDB($mysqli);
    header('Location: ../article.php?id='.$id_article);
} else {
    header('Location: ../index.php');
}


?>