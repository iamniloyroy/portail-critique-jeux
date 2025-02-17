<?php

session_start();

require_once 'includes/config-bdd.php';
require_once 'php/functions_DB.php';
require_once 'php/functions_query.php';
require_once 'php/functions_structure.php';

require_once 'static/header.php';
require_once 'static/nav.php';
require_once 'static/footer.php';

head();

echo '<body>';

$mysqli = connectionDB();

if (isset($_GET['login'])) {
    if (loginExist($mysqli,$_GET['login'])) {
        $user_id = $_GET['login'];
        navbar($mysqli,'profil');
        $profil = getProfile($mysqli,$user_id);
        afficherProfil($mysqli,$profil);
        closeDB($mysqli);
    } else {
        closeDB($mysqli);
        header('Location: index.php');
    }
} else {
    closeDB($mysqli);
    header('Location: index.php');
}


echo '</body>';

?>