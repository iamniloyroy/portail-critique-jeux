<?php
require_once 'includes/config-bdd.php';
require_once 'php/functions_DB.php';
require_once 'php/functions_query.php';
function navbar($mysqli, $currentPage)
{
    echo '<header>
    <nav>
        <a class="nav_logo" class="';
    if ($currentPage == 'index') {echo 'active';}
        echo '" href="index.php"><img class="logo" src="images/logo.png"/></a>
        <!-- si admin -->
        ';
    if (isset($_SESSION['role'])){
        if ($_SESSION['role'] == 'administrateur') {
        echo '<a class="nav_cell"  class="';
        if ($currentPage == 'index') {echo 'active';}
            echo '"  href="edit_article.php">Écrire un article</a>
        ';
        }
    }
    echo '
    </nav>

    <div class="search">
        <form action="index.php" method="get">
            <input type="text" placeholder="Rechercher un article..." name="query">
            <button class="search_button" type="submit"><img src="images/loupe.png"></button>
            
            <input type="checkbox" id="search_options_box" class="trigger_box" name="content-filter">
            <label for="search_options_box" class="nav_cell trigger_label">Recherche avancée</label>
            
            <div class="search_options">
                <div class="search-check">
                ';
                $categories = getAllCategories($mysqli);
                foreach ($categories as $categorie) {
                
                echo '<div><input type="checkbox" name="categories[]" value="' . $categorie['id_categorie'] . '">
                                <label for="categories[]">' . $categorie['categorie'] . '</label></div>';
            }
            echo '
                
                </div>
                <div class="search-check">
                
                ';
            $supports = getAllSupports($mysqli);
            foreach ($supports as $support) {
                echo '<div><input type="checkbox" name="supports[]" value="' . $support['id_support'] . '">
                                <label for="supports[]">' . $support['support'] . '</label></div>';
            }
            echo '
                
                </div>
                <div class="trieDiv">
                <label for="tri"><b>Trier par :</b></label>
                <select name="trie" class="trie">
                    <option value="DESC">Récente</option>
                    <option value="ASC">Ancienne</option>
                </select>
                </div>
                <button class="searchbar_button" type="submit">Rechercher</button>
            </div>
        </form>
    </div>

    ';
    if (isset($_SESSION['login'])) {
        echo '
        <div class="login">
            <a class="dropdown">@' . $_SESSION['login'] . ' <img src="images/bas.png"></a>
            <div class="dropdown_options">
                <a href="profil.php?login='.$_SESSION['login'].'">Mon profil</a>
                <a href="php/logout.php">Se déconnecter</a>
            </div>
        </div>
        ';
    } else {
        echo '
        <div class="login">
        <a class="dropdown">Connexion <img src="images/bas.png"></a>
        <div class="dropdown_options">
            <a href="connexion.php">Se connecter</a>
            <a href="inscription.php">Créer un compte</a>
        </div>
    </div>';
    }
    echo '</header>
    <div class="invisible-block"></div>
    ';
    

}

?>