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
if (isset($_SESSION['login'])) {
  $mysqli = connectionDB();
  if ($_SESSION['role'] == 'administrateur') {
    navbar($mysqli, 'edit_article');
    if (isset($_GET['id'])) {
      $article_id = $_GET['id'];
      afficherEditArticle($mysqli, $article_id);
    } else {
      afficherEditArticle($mysqli, null);
    }
  } else {
    closeDB($mysqli);
    header('Location: index.php');
  }
} else {
  header('Location: index.php');
}

footer();
echo '</body>';

?>