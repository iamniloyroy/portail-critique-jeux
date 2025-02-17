<?php

session_start();

if (isset($_SESSION['login']) && isset($_SESSION['role'])) {
    session_destroy();
    header('Location: ../index.php');
} else {
    header('Location: ../index.php');
}

?>