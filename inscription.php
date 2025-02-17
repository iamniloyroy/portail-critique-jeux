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
navbar($mysqli,'inscription');
closeDB($mysqli);

$myArray = array();


afficherInscription();


echo '</body>';

?>