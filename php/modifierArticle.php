<?php

session_start();
require_once '../includes/config-bdd.php';
require_once 'functions_DB.php';
require_once 'functions_query.php';

$mysqli = connectionDB();
if (isset($_POST['id_article'])) {
    $mysqli = connectionDB();
    $id_article = mysqli_real_escape_string($mysqli, $_POST['id_article']);
    $titre = mysqli_real_escape_string($mysqli, $_POST['titre']);
    $sous_titre = mysqli_real_escape_string($mysqli, $_POST['sous_titre']);
    $contenu = mysqli_real_escape_string($mysqli, $_POST['contenu']);
    $note = mysqli_real_escape_string($mysqli, $_POST['note']);
    $nom_jeu = mysqli_real_escape_string($mysqli, $_POST['nom_jeu']);
    $prix_jeu = mysqli_real_escape_string($mysqli, $_POST['prix_jeu']);
    $date_sortie_jeu = mysqli_real_escape_string($mysqli, $_POST['date_sortie_jeu']);
    $synopsis_jeu = mysqli_real_escape_string($mysqli, $_POST['synopsis_jeu']);

    // Pour la jaquette du jeu
    if (isset($_FILES['jaquette_jeu'])) {
        if ($_FILES['jaquette_jeu']['name'] != "") {
            move_uploaded_file($_FILES['jaquette_jeu']['tmp_name'], '../images/uploads/posts/' . basename($_FILES['jaquette_jeu']['name']));
            $old_jaquette = getJaquette($mysqli, $id_article);
            if ($old_jaquette && file_exists($old_jaquette) && $old_jaquette != 'default.jpg') {
                unlink($old_jaquette);
            }
            $jaquette_jeu = basename($_FILES['jaquette_jeu']['name']);
        } else {
            $jaquette_jeu = getJaquette($mysqli, $id_article);
        }
    } else {
        $jaquette_jeu = getJaquette($mysqli, $id_article);
    }

    updateArticle($mysqli, $id_article, $titre, $contenu, $note, $nom_jeu, $prix_jeu, $date_sortie_jeu, $synopsis_jeu, $jaquette_jeu, $sous_titre);


    closeDB($mysqli);
    header('Location: ../article.php?id=' . $id_article );
} else {
    header('Location: ../signup.php');
}

?>