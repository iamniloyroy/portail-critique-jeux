<?php

session_start();
require_once '../includes/config-bdd.php';
require_once 'functions_DB.php';
require_once 'functions_query.php';

$mysqli = connectionDB();
if (isset($_POST['id_avis'])){
    $titre = $_POST['titre'];
    $texte = $_POST['contenu'];
    $note = $_POST['note'];
    $id_avis = $_POST['id_avis'];
    $id_article = $_POST['id_article'];
    updateAvis($mysqli,$id_avis,$titre,$texte,$note);
    closeDB($mysqli);
    header('Location: ../article.php?id='.$id_article);
} else {
    header('Location: ../index.php');
}

?>