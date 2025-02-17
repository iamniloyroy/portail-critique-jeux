<?php

session_start();
require_once '../includes/config-bdd.php';
require_once 'functions_DB.php';
require_once 'functions_query.php';

if (isset($_POST['titre'])) {
    $mysqli = connectionDB();
    $titre = mysqli_real_escape_string($mysqli, $_POST['titre']);
    $sous_titre = mysqli_real_escape_string($mysqli, $_POST['soustitre']);
    $contenu = mysqli_real_escape_string($mysqli, $_POST['contenu']);
    $note = mysqli_real_escape_string($mysqli, $_POST['note']);
    $nom_jeu = mysqli_real_escape_string($mysqli, $_POST['nom_jeu']);
    $prix_jeu = mysqli_real_escape_string($mysqli, $_POST['prix_jeu']);
    $date_sortie_jeu = mysqli_real_escape_string($mysqli, $_POST['date_sortie_jeu']);
    $synopsis_jeu = mysqli_real_escape_string($mysqli, $_POST['synopsis_jeu']);

    // Pour la jaquette du jeu
    if (isset($_FILES['jaquette_jeu']) && $_FILES['jaquette_jeu']['error'] == 0) {
        move_uploaded_file($_FILES['jaquette_jeu']['tmp_name'], '../images/uploads/posts/' . basename($_FILES['jaquette_jeu']['name']));
        $jaquette_jeu = basename($_FILES['jaquette_jeu']['name']);
    } else {
        $jaquette_jeu = 'default.jpg';
    }

    $idArticle = postArticle($mysqli, $titre, $contenu, $note, $nom_jeu, $prix_jeu, $date_sortie_jeu, $synopsis_jeu, $jaquette_jeu, $sous_titre);
    if (isset($_POST['supports'])) {

        $id_supports = $_POST['supports'];
        foreach ($id_supports as $id_support) {
            postSupport($mysqli, $idArticle, $id_support);
        }
    }
    if (isset($_POST['categories'])) {
        $id_categories = $_POST['categories'];
        foreach ($id_categories as $id_categorie) {
            postCategorie($mysqli, $idArticle, $id_categorie);
        }
    }
    if (isset($_FILES['images'])) {
        $i = 0;
        foreach ($_FILES['images']['tmp_name'] as $i => $image) {
            if ($_FILES['images']['error'][$i] == UPLOAD_ERR_OK && $_FILES['images']['name'][$i] != '') {
                move_uploaded_file($image, '../images/uploads/jeux/' . basename($_FILES['images']['name'][$i]));
                $image =  basename($_FILES['images']['name'][$i]);
                postImage($mysqli, $idArticle, $image);
            }
        }
    }

    closeDB($mysqli);
    header('Location: ../index.php');
} else {
    header('Location: ../index.php');
}
?>