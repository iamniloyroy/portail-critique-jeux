<?php

session_start();
require_once '../includes/config-bdd.php';
require_once 'functions_DB.php';
require_once 'functions_query.php';

if (isset($_FILES['avatar'])){
    $mysqli = connectionDB();
    $id_user = $_SESSION['login'];
    if ($_FILES['avatar']['name']!="")
    { 
        move_uploaded_file($_FILES['avatar']['tmp_name'], '../images/uploads/user/' . basename($_FILES['avatar']['name']));
        $old_avatar = getProfilePic($mysqli, $id_user);
        if (file_exists($old_avatar)) {
            unlink($old_avatar);
        }
        $photo_profil = basename($_FILES['avatar']['name']);
    }
    updateProfilePic($mysqli, $id_user, $photo_profil);
    closeDB($mysqli);
    header('Location: ../profil.php?login='.$id_user);
}

?>