<?php

session_start();
require_once '../includes/config-bdd.php';
require_once 'functions_DB.php';
require_once 'functions_query.php';

$mysqli = connectionDB();
if (isset($_POST['id_article'])){
    $mysqli = connectionDB();
    $id_article = $_POST['id_article'];
    
    deleteSupport($mysqli,$id_article);
    deleteCategorie($mysqli,$id_article);
    deleteImage($mysqli,$id_article);
    supprimerAvis($mysqli,$id_article);
    deleteArticle($mysqli,$id_article);
    
    closeDB($mysqli);
    header('Location: ../index.php');
    } else {
    header('Location: ../article.php?id='.$id_article);
    }

?>