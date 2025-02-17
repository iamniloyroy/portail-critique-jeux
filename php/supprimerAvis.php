<?php

session_start();
require_once '../includes/config-bdd.php';
require_once 'functions_DB.php';
require_once 'functions_query.php';

$mysqli = connectionDB();
if (isset($_POST['id_avis'])){
    $mysqli = connectionDB();
    $login = $_SESSION['login'];
    $id_avis = $_POST['id_avis'];
    $id_article = $_POST['id_article'];
    
    deleteAvis($mysqli,$id_avis,$login);
    
    
    closeDB($mysqli);
    header('Location: ../article.php?id='.$id_article);
    } else {
    header('Location: ../signup.php');
    }

?>