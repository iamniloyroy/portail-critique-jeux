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
navbar($mysqli,'index');

if (isset($_GET['page'])) {
    $page = $_GET['page'];
} else {
    $page = 0;
}

if (isset($_GET['categories'])) {
    $categories = $_GET['categories'];
} else {
    $categories = array();
}

if (isset($_GET['supports'])) {
    $supports = $_GET['supports'];
} else {
    $supports = array();
}

if (isset($_GET['query'])) {
    $query = $_GET['query'];
} else {
    $query = '';
}

if (isset($_GET['trie'])) {
    $trie = $_GET['trie'];
} else {
    $trie = '';
}

$articles = getArticles($mysqli,$page,$query,$trie,$categories,$supports);
$nbArticles = getNbArticles($mysqli,$page,$query,$trie,$categories,$supports);

afficherAcceuil($mysqli,$articles,$nbArticles);
footer();

echo '</body>';

?>