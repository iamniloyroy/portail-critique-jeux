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
navbar($mysqli,'article');

if (isset($_GET['id'])) {
    $article_id = $_GET['id'];
} else {
    closeDB($mysqli);
    header('Location: index.php');
}

$article = getArticle($mysqli,$article_id);
$aviss = getAvis($mysqli,$article_id);
afficherArticle($mysqli,$article,$aviss);

footer();

echo '</body>';


?>