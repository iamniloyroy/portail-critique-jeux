<?php

require_once 'functions_DB.php';
require_once 'functions_query.php';

function afficherAcceuil($mysqli, $articles, $nbArticles)
{
    echo '<main id="index">';
    foreach ($articles as $article) {
        $article = getArticle($mysqli, $article['id_article']);
        echo '<div class="article">';
        echo '<a href="article.php?id=' . $article['id_article'] . '">';
        echo '<div class="jeu">';
        echo '<img class="jaquette" src="images/uploads/posts/' . $article['jaquette_jeu'] . '"/>';
        echo '<div class="description">';
        echo '<h1>' . $article['titre'] . '</h1>';
        echo '<div class="catégories">';
        $categories = getCategories($mysqli, $article['id_article']);
        foreach ($categories as $categorie) {
            echo '<p>' . $categorie['categorie'] . '</p>';
        }
        echo '</div>';
        $supports = getSupports($mysqli, $article['id_article']);
        echo '<div class="supports">';
        foreach ($supports as $support) {
            echo '<p>' . $support['support'] . '</p>';
        }
        echo '</div>';
        echo '<p><b>Prix : </b>' . $article['prix_jeu'] . '€</p>';
        echo '<p><b>Date de sortie : </b>' . $article['date_sortie_jeu'] . '</p>';
        echo '<p class="synopsis">' . $article['synopsis_jeu'] . '</p>';
        echo '</div>';
        echo '</div>';
        echo '</a>';
        echo '</div>';
        echo '';
    }

    echo '<div class="pagination">';
    $nbArticlesParPage = 5;
    $queryParams = $_GET;

    if (isset($_GET['page'])) {
        if ($_GET['page'] > 0) {
            $queryParams['page'] = $_GET['page'] - 1;
            $newQueryString = http_build_query($queryParams);
            $dernierURL = "index.php?" . $newQueryString;
            echo '<a href="' . $dernierURL . '"><button>Page précédente</button></a>';
        }
    }
    $queryParams = $_GET;
    $nbPages = ceil($nbArticles / $nbArticlesParPage);
    if (isset($_GET['page'])) {
        $page = $_GET['page'];
        if ($page < ($nbPages - 1)) {
            $queryParams['page'] = $page + 1;
            $newQueryString = http_build_query($queryParams);
            $prochainURL = "index.php?" . $newQueryString;
            echo '<a href="' . $prochainURL . '"><button>Page suivante</button></a>';
        }
    } else {
        if ((1 < ($nbPages))) {
            $queryParams['page'] = 1;
            $newQueryString = http_build_query($queryParams);
            $prochainURL = "index.php?" . $newQueryString;
            echo '<a href="' . $prochainURL . '"><button>Page suivante</button></a>';
        }
    }

    echo '</div>';
    echo '</main>';
}




function afficherArticle($mysqli, $article, $aviss)
{
    echo '<main id="article">';
    echo '<div class="jeu">';
    echo '<img class="jaquette" src="images/uploads/posts/' . $article['jaquette_jeu'] . '"/>';
    echo '<div class="description">';
    echo '<h1>' . $article['titre'] . '</h1>';
    echo '<h3><i>' . $article['sous_titre'] . '</i></h3>';
    echo '<div class="catégories">';
    $categories = getCategories($mysqli, $article['id_article']);
    foreach ($categories as $categorie) {
        echo '<p>' . $categorie['categorie'] . '</p>';
    }
    echo '</div>';

    echo '<div class="supports">';
    $supports = getSupports($mysqli, $article['id_article']);
    foreach ($supports as $support) {
        echo '<p>' . $support['support'] . '</p>';
    }
    echo '</div>';

    echo '<p>' . $article['contenu'] . '</p>';

    echo '<p><b>Prix : </b>' . $article['prix_jeu'] . '€</p>';
    echo '<p><b>Date de sortie : </b>' . $article['date_sortie_jeu'] . '</p>';
    echo '<p><b>Synopsis : </b></p>';
    echo '<p class="synopsis">' . $article['synopsis_jeu'] . '</p>';

    echo '<p><b>Aritcle Publié : </b>' . $article['date_creation'] . '</p>';
    if ($article['date_modification'] != null) {
        echo '<p><b>Dernière modification de l\'article : </b>' . $article['date_modification'] . '</p>';
    }
    echo '<div class="notes">';
    echo '<label for="note_critique"><b>Note critique</b></label>';
    echo '<p class="note_critique">' . $article['note'] . '</p>';
    echo '<!--moyenne des avis-->';
    if (count($aviss) > 0) {
        echo '<label for="note_utilisateur"><b>Note utilisateur</b></label>';
        echo '<p class="note_utilisateur" style="
    ';
        if ((getAvisMoyenne($mysqli, $article['id_article'])['moyenne']) >= 10) {
            echo 'padding: 10px 6px';
        } else {
            echo '';
        }
        echo '">' . number_format(floatval(getAvisMoyenne($mysqli, $article['id_article'])['moyenne']), 1) . '</p>';
    }
    echo '</div>';

    if (isset($_SESSION['login'])) {
        if ($_SESSION['role'] == 'administrateur') {
            echo "<div>";
            echo '<form action="edit_article.php" method="get">';
            echo '<input type="hidden" name="id" value="' . $article['id_article'] . '">';
            echo '<button type="submit" class="modifierArticle">Modifier Article</button>';
            echo '</form>';
            echo '<form action="php/supprimerArticle.php" method="post">';
            echo '<input type="hidden" name="id_article" value="' . $article['id_article'] . '">';
            echo '<button type="submit">Supprimer Article</button>';
            echo '</form>';
            echo '</div>';
        }
    }
    echo '</div>';
    echo '</div>';
    echo '<hr>';

    echo '<div class="illustrations">';
    $images = getImages($mysqli, $article['id_article']);
    foreach ($images as $image) {
        echo '<img src="images/uploads/jeux/' . $image['chemin'] . '"/>';
    }
    echo '</div>';
    
    echo '<hr>';
    echo '';
    echo '';
    echo '';
    if (isset($_SESSION['login'])) {
        if (!dejaAvis($mysqli, $article['id_article'], $_SESSION['login'])) {
            echo '<form action="php/publierAvis.php" method="post">';
            echo '<!-- identifiant du membre -->';
            echo '<input type="hidden" name="id" value="' . $article['id_article'] . '">';
            echo '';
            echo '<label for="titre"><b>Titre</b></label>';
            echo '<input type="text" placeholder="Titre" name="titre" required>';
            echo '';
            echo '<label for="contenu"><b>Contenu</b></label>';
            echo '<textarea placeholder="Contenu" name="contenu" required></textarea>';
            echo '<label for="note"><b>Note</b></label>';
            echo '<input type="number" placeholder="Note" name="note" required>';
            echo '';
            echo '<button type="submit">Publier l\'avis</button>';
            echo '</form>';
        }
    }
    foreach ($aviss as $avis) {
        echo '<div class="avis">';
        echo '<div class="avis_utilisateur">';
        echo '<!-- lien vers le profil de l\'utilisateur -->';
        echo '<a href="profil.php?login=' . $avis['login'] . '">';
        echo '<img src="images/uploads/user/' . getProfilePic($mysqli, $avis['login']) . '"/>';
        echo '<h2>' . $avis['login'] . '</h2>';
        echo '</a>';
        echo '<p><b>Posté le : </b>' . $avis['date_creation'] . '</p>';
        if ($avis['date_modification'] != null) {
            echo '<p><b>Dernière modification : </b>' . $avis['date_modification'] . '</p>';
        }
        echo '</div>';
        echo '<div class="avis_entete">';
        echo '<h2>' . $avis['titre'] . '</h2>';
        echo '<p class="note_utilisateur">' . $avis['note'] . '</p>';
        echo '</div>';
        echo '<p class="avis_contenu">' . $avis['texte'] . '</p>';
        echo '<!-- afficher seulement si l\'utilisateur est le propriétaire du message';
        echo 'ou est admin -->';
        if (isset($_SESSION['login'])) {
            if (checkMonAvis($mysqli, $avis['id_avis'], ($_SESSION['login']))) {




                echo '<div class="avis_options">';

                echo '<button type="button" onclick="var form = document.getElementById(\'modifierAvis\'); form.style.display = (form.style.display === \'none\') ? \'inline\' : \'none\';">Modifier</button>';

                echo '<form class="bouton_supprimer" action="php/supprimerAvis.php" method="post">';
                echo '<input type="hidden" name="id_avis" value="' . $avis['id_avis'] . '">';
                echo '<input type="hidden" name="id_article" value="' . $avis['id_article'] . '">';
                echo '<button type="submit">Supprimer</button>';
                echo '</form>';
                echo '</div>';
            }
        }
        
        echo '</div>';
        if (isset($_SESSION['login'])) {
            if (checkMonAvis($mysqli, $avis['id_avis'], ($_SESSION['login']))) {

        echo '<form action="php/modifierAvis.php" method="post" id="modifierAvis" style="display:none">';
        echo '<!-- identifiant du membre -->';
        echo '<input type="hidden" name="id_article" value="' . $article['id_article'] . '">';
        echo '<input type="hidden" name="id_avis" value="' . $avis['id_avis'] . '">';
        echo '';
        echo '<label for="titre"><b>Titre</b></label>';
        echo '<input type="text" placeholder="Titre" name="titre" value="' . $avis['titre'] . '" required>';
        echo '';
        echo '<label for="contenu"><b>Contenu</b></label>';
        echo '<input type="text" placeholder="Contenu" name="contenu" value="' . $avis['texte'] . '" required>';
        echo '';
        echo '<label for="note"><b>Note</b></label>';
        echo '<input type="number" placeholder="Note" name="note" value="' . $avis['note'] . '" required>';
        echo '';
        echo '<a href="edit_avis"><button>Modifier</button></a>';
        echo '</form>';
    }
}

        echo '';
    }
    echo '';
    echo '</main>';
}



function afficherConnexion()
{
    echo '<main id="connexion">';
    echo '<form action="./php/login.php" method="post">';
    echo '<label for="identifiant"><b>Identifiant</b></label>';
    echo '<input type="text" placeholder="Identifiant" name="login" required>';
    echo '';
    echo '<label for="mdp"><b>Mot de passe</b></label>';
    echo '<input type="password" placeholder="Mot de passe" name="password" required>';
    echo '';
    echo '<button type="submit">Se connecter</button>';
    echo '</form>';
    echo '';
    if (isset($_GET['erreur'])) {
        echo '<span>Erreur de connexion</span>';
    }
    echo '</main>';
}


function afficherInscription()
{
    echo '<main id="inscription">';
    echo '<form action="php/signup.php" method="post">';
    echo '<label for="identifiant"><b>Identifiant</b></label>';
    echo '<input type="text" placeholder="Identifiant" name="login" required>';
    echo '';
    echo '<label for="mdp"><b>Mot de passe</b></label>';
    echo '<input type="password" placeholder="Mot de passe" name="mdp" required>';
    echo '';
    echo '<label for="nom"><b>Nom</b></label>';
    echo '<input type="text" placeholder="Nom" name="nom" required>';
    echo '';
    echo '<label for="prenom"><b>Prénom</b></label>';
    echo '<input type="text" placeholder="Prénom" name="prenom" required>';
    echo '';
    echo '<label for="email"><b>Adresse email</b></label>';
    echo '<input type="text" placeholder="Adresse email" name="email" required>';
    echo '';
    echo '<label for="date_naissance"><b>Date de naissance</b></label>';
    echo '<input type="date" name="date_naissance" max="2009-05-20" required>';
    echo '';
    echo '<button type="submit">Créer mon compte</button>';
    echo '</form>';
    echo '';
    if (isset($_GET['erreur'])) {
        echo '<span>L\'identifiant est déjà pris.</span>';
    }
    echo '</main>';
}

function afficherProfil($mysqli, $user)
{
    echo '<main id="profil">';
    echo '<div class="public">';
    echo '<a class="trigger"><img src="images/uploads/user/' . $user['photo_profil'] . '"></a>';
    
    if (isset($_SESSION['login'])) {
        if ($_SESSION['login'] == $user['login']) {
    echo '<form class="hidden_form" action="php/avatar.php" method="post" enctype="multipart/form-data">';
    echo '<label for="avatar"><b>Modifier Avatar</b></label>';
    echo '<input type="file" name="avatar" accept="image/*">';
    echo '<button type="submit">Modifier</button>';
    echo '</form>';
        }}
    echo '<div>';
    echo '<div>';
    echo '<h1>@' . $user['login'] . '</h1>';
    echo '<p class="role"><b>Rôle : </b>' . $user['role'] . '</p>';
    echo '<p><b>Membre depuis : </b>' . $user['date_creation'] . '</p>';
    echo '<p><b>Dernière connexion : </b>' . $user['date_derniere_connexion'] . '</p>';
    echo '</div>';
    echo '</div>';

    if (isset($_SESSION['login'])) {
        if ($_SESSION['login'] == $user['login']) {
            echo '<div class="prive">';
            echo '<p><b>Mot de passe : </b>' . $user['mot_de_passe'] . '</p>';
            echo '<p><b>Nom : </b>' . $user['nom'] . '</p>';
            echo '<p><b>Prénom : </b>' . $user['prenom'] . '</p>';
            echo '<p><b>Adresse email : </b>' . $user['adresse_mail'] . '</p>';
            echo '<a href="edit_profil.php"><button>Modifier le profil</button></a>';
            echo '</div>';
        }
    }


    // echo '<div class="avis">';
    // echo '<div class="avis_utilisateur">';
    // echo '<a href="article.html">';
    // echo '<h2>Nom du jeu</h2>';
    // echo '</a>';
    // echo '<p><b>Posté le : </b>200-01-01</p>';
    // echo '</div>';
    // echo '<div class="avis_entete">';
    // echo '<h2>Titre</h2>';
    // echo '<p class="note_utilisateur">20</p>';
    // echo '</div>';
    // echo '<p class="avis_contenu">lorem ipsum</p>';
    // echo '<div class="avis_options">';
    // echo '<a class="trigger"><button>Modifier</button></a>';
    // echo '<form class="bouton_supprimer" action="" method="post">';
    // echo '<input type="hidden" name="identifiant" value="Niloy95">';
    // echo '<input type="hidden" name="nom_du_jeu" value="jeu 1">';
    // echo '<button type="submit">Supprimer</button>';
    // echo '</form>';
    // echo '</div>';
    // echo '</div>';


    // if (isset($_SESSION['login'])) {
    //     if ($_SESSION['login'] == $user['login']) {
    //         echo '<form action="" method="post">';
    //         echo '<input type="hidden" name="identifiant" value="">';
    //         echo '<input type="hidden" name="nom_du_jeu" value="jeu 1">';
    //         echo '<label for="titre"><b>Titre</b></label>';
    //         echo '<input type="text" placeholder="Titre" name="titre" required>';
    //         echo '<label for="contenu"><b>Contenu</b></label>';
    //         echo '<input type="text" placeholder="Contenu" name="contenu" required>';
    //         echo '<label for="note"><b>Note</b></label>';
    //         echo '<input type="text" placeholder="Note" name="note" required>';
    //         echo '<button type="submit">Publier l\'avis</button>';
    //         echo '</form>';
    //     }
    // }

    echo '</main>';
}

function afficherModifierProfil($mysqli, $profil)
{
    echo '<main id="edit_profil">';
    echo '<form action="php/modifierProfil.php" method="post">';
    echo '<input type="hidden" value="' . $profil['login'] . '" name="login" required>';
    echo '<label for="mdp"><b>Mot de passe</b></label>';
    echo '<input type="password" value="' . $profil['mot_de_passe'] . '" placeholder="Mot de passe" name="pwd" required>';
    echo '';
    echo '<label for="nom"><b>Nom</b></label>';
    echo '<input type="text" value="' . $profil['nom'] . '" placeholder="Nom" name="nom" required>';
    echo '';
    echo '<label for="prenom"><b>Prénom</b></label>';
    echo '<input type="text" value="' . $profil['prenom'] . '" placeholder="Prénom" name="prenom" required>';
    echo '';
    echo '<label for="email"><b>Adresse email</b></label>';
    echo '<input type="text" value="' . $profil['adresse_mail'] . '" placeholder="Adresse email" name="email" required>';
    echo '';
    echo '<label for="date_naissance"><b>Date de naissance</b></label>';
    echo '<input type="date" value="' . $profil['date_naissance'] . '" name="date_naissance" max="2009-05-20" required>';
    echo '';
    echo '<button type="submit">Confirmer les modifications</button>';
    echo '</form>';
    echo '</main>';
}

function afficherEditArticle($mysqli, $id_article)
{
    if ($id_article == null) {

        echo '<main id="edit_article">';
        echo '<form action="php/publierArticle.php" method="post" enctype="multipart/form-data">';

        echo '<h1>Jeu :</h1>';

        echo '<label for="titre_du_jeu"><b>Titre du jeu</b></label>';
        echo '<input type="text" placeholder="Titre du jeu" name="nom_jeu" value="" required>';

        echo '<div class="catégories">';
        $categories = getAllCategories($mysqli);
        foreach ($categories as $category) {
            echo '<div>';
            echo '<input type="checkbox" name="categories[]" value="' . $category['id_categorie'] . '">';
            echo '<label for="categories[]">' . $category['categorie'] . '</label>';
            echo '</div>';
        }
        echo '</div>';

        echo '<div class="supports">';
        $supports = getAllSupports($mysqli);
        foreach ($supports as $support) {
            echo '<div>';
            echo '<input type="checkbox" name="supports[]" value="' . $support['id_support'] . '">';
            echo '<label for="supports[]">' . $support['support'] . '</label>';
            echo '</div>';
        }
        echo '</div>';

        echo '<label for="prix"><b>Prix</b></label>';
        echo '<input type="text" placeholder="Prix" name="prix_jeu" value="" required>';

        echo '<label for="date_sortie"><b>Date de sortie</b></label>';
        echo '<input type="date" placeholder="Date de sortie" name="date_sortie_jeu" required>';

        echo '<label for="synopsis"><b>Synopsis</b></label>';
        echo '<input type="text" placeholder="Synopsis" name="synopsis_jeu" required>';

        echo '<label for="jaquette"><b>Jaquette</b></label>';
        echo '<input type="file" name="jaquette_jeu" accept="image/*">';

        echo '<label for="img1"><b>Image</b></label>';
        echo '<input type="file" name="images[]" accept="image/*">';
        echo '<label for="img2"><b>Image 2</b></label>';
        echo '<input type="file" name="images[]" accept="image/*">';
        echo '<label for="img3"><b>Image 3</b></label>';
        echo '<input type="file" name="images[]" accept="image/*">';

        echo '<h1>Article :</h1>';

        echo '<label for="titre_article"><b>Titre de l\'article</b></label>';
        echo '<input type="text" placeholder="Titre de l\'article" name="titre" required>';

        echo '<label for="soustitre_article"><b>Sous-titre de l\'article</b></label>';
        echo '<input type="text" placeholder="Sous-titre de l\'article" name="soustitre" required>';

        echo '<label for="contenu"><b>Contenu de l\'article</b></label>';
        echo '<textarea placeholder="Contenu de l\'article" name="contenu" required></textarea>';

        echo '<label for="note"><b>Note</b></label>';
        echo '<input type="text" placeholder="Note" name="note" required>';

        echo '<button type="submit">Publier l\'article</button>';
        echo '</form>';
        echo '</main>';
    } else {
        $article = getArticle($mysqli, $id_article);
        echo '<main id="edit_article">';
        echo '<form action="php/modifierArticle.php" method="post" enctype="multipart/form-data">';

        echo '<h1>Jeu :</h1>';
        echo '<input type="hidden" name="id_article" value="' . $id_article . '">';
        echo '<label for="titre_du_jeu"><b>Titre du jeu</b></label>';
        echo '<input type="text" placeholder="Titre du jeu" name="nom_jeu" value="' . $article['nom_jeu'] . '" required>';

        echo '<div class="catégories">';
        $categories = getAllCategories($mysqli);
        foreach ($categories as $category) {
            echo '<div>';
            echo '<input type="checkbox" name="categories[]" value="' . $category['id_categorie'] . '"';
            $categoriesArticles = getCategories($mysqli, $id_article);
            $categoriesIds = [];
            foreach ($categoriesArticles as $categorieArticle) {
                array_push($categoriesIds, $categorieArticle['id_categorie']);
            }
            if (in_array($category['id_categorie'], $categoriesIds)) {
                echo ' checked';
            }
            echo '>';
            echo '<label for="categories[]">' . $category['categorie'] . '</label>';
            echo '</div>';
        }
        echo '</div>';
        echo '<div class="supports">';
        $supports = getAllSupports($mysqli);
        foreach ($supports as $support) {
            echo '<div>';
            echo '<input type="checkbox" name="supports[]" value="' . $support['id_support'] . '"';
            $supportsArticles = getSupports($mysqli, $id_article);
            $supportsIds = [];
            foreach ($supportsArticles as $supportArticle) {
                array_push($supportsIds, $supportArticle['id_support']);
            }
            if (in_array($support['id_support'], $supportsIds)) {
                echo ' checked';
            }
            echo '>';
            echo '<label for="supports[]">' . $support['support'] . '</label>';
            echo '</div>';
        }
        echo '</div>';

        echo '<label for="prix"><b>Prix</b></label>';
        echo '<input type="text" placeholder="Prix" name="prix_jeu" value="' . $article['prix_jeu'] . '" required>';

        echo '<label for="date_sortie"><b>Date de sortie</b></label>';
        echo '<input type="date" placeholder="Date de sortie" name="date_sortie_jeu" value="' . $article['date_sortie_jeu'] . '" required>';

        echo '<label for="synopsis"><b>Synopsis</b></label>';
        echo '<input type="text" placeholder="Synopsis" name="synopsis_jeu" value="' . $article['synopsis_jeu'] . '" required>';

        echo '<img class="jaquette" src="images/uploads/posts/' . $article['jaquette_jeu'] . '"/>';
        echo '<br>';
        echo '<label for="jaquette"><b>Modifier Jaquette</b></label>';
        echo '<input type="file" name="jaquette_jeu" accept="image/*">';

        echo '<h1>Article :</h1>';

        echo '<label for="titre article"><b>Titre de l\'article</b></label>';
        echo '<input type="text" placeholder="Titre de l\'article" name="titre" value="' . $article['titre'] . '" required>';
        echo '<label for="soustitre_article"><b>Sous-titre de l\'article</b></label>';
        echo '<input type="text" placeholder="Sous-titre de l\'article" name="sous_titre" value="' . $article['sous_titre'] . '" required>';

        echo '<label for="contenu"><b>Contenu de l\'article</b></label>';
        echo '<textarea placeholder="Contenu de l\'article" name="contenu" required>' . $article['contenu'] . '</textarea>';

        echo '<label for="note"><b>Note</b></label>';
        echo '<input type="text" placeholder="Note" name="note" value="' . $article['note'] . '" required>';

        echo '<button type="submit">Modifier l\'article</button>';
        echo '</form>';
        echo '</main>';
    }
}
?>