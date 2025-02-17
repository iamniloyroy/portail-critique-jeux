<?php

function getArticles($mysqli, $page, $query, $trie, $categories, $supports)
{
    $nbArticleParPage = 5;
    $offset = $page * $nbArticleParPage;
    $filtreSQL = "1=1";
    
    if (!empty($categories)) {
        $categoryList = implode(",", $categories);
        $filtreSQL .= " AND categorieXarticle.id_categorie IN ($categoryList)";
    }
    
    if (!empty($supports)) {
        $supportList = implode(",", $supports);
        $filtreSQL .= " AND supportXarticle.id_support IN ($supportList)";
    }
    
    if ($query != "") {
        $filtreSQL .= " AND (article.titre LIKE '%$query%' OR article.contenu LIKE '%$query%' OR article.nom_jeu LIKE '%$query%' OR article.synopsis_jeu LIKE '%$query%')";
    }
    
    if ($trie=="") {
        $trie = "DESC";
    }
    
    $sql = "
    SELECT DISTINCT(article.id_article)
    FROM article
    INNER JOIN categorieXarticle ON categorieXarticle.id_article = article.id_article
    INNER JOIN supportXarticle ON supportXarticle.id_article = article.id_article
    WHERE $filtreSQL
    ORDER BY article.date_creation $trie
    LIMIT $nbArticleParPage OFFSET $offset";

    $articles = readDB($mysqli, $sql);

    return $articles;
}



function getNbArticles($mysqli, $page, $query, $trie, $categories, $supports)
{
    $filtreSQL = "1=1";
    
    if (!empty($categories)) {
        $categoryList = implode(",", $categories);
        $filtreSQL .= " AND categorieXarticle.id_categorie IN ($categoryList)";
    }
    
    if (!empty($supports)) {
        $supportList = implode(",", $supports);
        $filtreSQL .= " AND supportXarticle.id_support IN ($supportList)";
    }
    
    if (!empty($query)) {
        $filtreSQL .= " AND (article.titre LIKE '%$query%' OR article.contenu LIKE '%$query%' OR article.nom_jeu LIKE '%$query%' OR article.synopsis_jeu LIKE '%$query%')";
    }
    
    $sql = "
    SELECT COUNT(DISTINCT article.id_article) as nb
    FROM article
    INNER JOIN categorieXarticle ON categorieXarticle.id_article = article.id_article
    INNER JOIN supportXarticle ON supportXarticle.id_article = article.id_article
    WHERE $filtreSQL";

    $result = readDB($mysqli, $sql);
    
    if ($result && count($result) > 0) {
        return $result[0]['nb'];
    } else {
        return 0;
    }
}


function getArticle($mysqli,$id_article)
{
    $sql = "SELECT * FROM article WHERE article.id_article=$id_article";
    $article = readDB($mysqli, $sql);
    
    return $article[0];
}

function getSupports($mysqli,$id_article)
{
    $sql = "SELECT * FROM support INNER JOIN supportXarticle ON supportXarticle.id_support=support.id_support INNER JOIN article ON article.id_article=supportXarticle.id_article WHERE supportXarticle.id_article=$id_article";
    $supports = readDB($mysqli, $sql);
    
    return $supports;
}

function getAllSupports($mysqli)
{
    $sql = "SELECT * FROM support";
    $supports = readDB($mysqli, $sql);
    
    return $supports;
}

function getCategories($mysqli,$id_article)
{
    $sql = "SELECT * FROM categorie INNER JOIN categorieXarticle ON categorieXarticle.id_categorie=categorie.id_categorie INNER JOIN article ON article.id_article=categorieXarticle.id_article WHERE categorieXarticle.id_article=$id_article";
    $categories = readDB($mysqli, $sql);
    
    return $categories;
}

function getAllCategories($mysqli)
{
    $sql = "SELECT * FROM categorie";
    $categories = readDB($mysqli, $sql);
    
    return $categories;
}

function getImages($mysqli,$id_article)
{
    $sql = "SELECT * FROM image WHERE image.id_article=$id_article";
    $images = readDB($mysqli, $sql);
    
    return $images;
}

function getAvis($mysqli,$id_article)
{
    $sql = "SELECT * FROM avis WHERE avis.id_article=$id_article";
    $avis = readDB($mysqli, $sql);
    
    return $avis;
}

function getAvisMoyenne($mysqli,$id_article)
{
    $sql = "SELECT AVG(note) as moyenne FROM avis WHERE avis.id_article=$id_article";
    $avisMoyenne = readDB($mysqli, $sql);
    
    return $avisMoyenne[0];
}

function getProfile($mysqli,$login)
{
    $sql = "SELECT * FROM utilisateur WHERE utilisateur.login='$login'";
    $profile = readDB($mysqli, $sql);
    
    return $profile[0];
}

function getJaquette($mysqli,$id_article)
{
    $sql = "SELECT jaquette_jeu FROM article WHERE article.id_article=$id_article";
    $jaquette = readDB($mysqli, $sql);
    
    return $jaquette[0]['jaquette_jeu'];
}

function getProfilePic($mysqli,$login)
{
    $sql = "SELECT photo_profil FROM utilisateur WHERE utilisateur.login='$login'";
    $profilePic = readDB($mysqli, $sql);
    
    return $profilePic[0]['photo_profil'];
}

function login($mysqli,$login,$password)
{
    $sql = "SELECT * FROM utilisateur WHERE utilisateur.login='$login' AND utilisateur.mot_de_passe='$password'";
    $profile = readDB($mysqli, $sql);
    
    if (!empty($profile)) {
        $sql = "UPDATE utilisateur SET utilisateur.date_derniere_connexion=NOW() WHERE utilisateur.login='$login'";
        writeDB($mysqli, $sql);
    }
    
    return $profile;
}

function loginExist($mysqli,$login)
{
    $sql = "SELECT * FROM utilisateur WHERE utilisateur.login='$login'";
    $profile = readDB($mysqli, $sql);
    
    if (empty($profile)) {
        return false;
    } else {
        return true;
    }
}
function checkLogin($mysqli,$login)
{
    $sql = "SELECT * FROM utilisateur WHERE utilisateur.login='$login'";
    $profile = readDB($mysqli, $sql);
    
    if (empty($profile)) {
        return true;
    } else {
        return false;
    }
}

function signup($mysqli,$login,$mot_de_passe,$nom,$prenom,$date_naissance,$adresse_mail)
{
    $sql = "INSERT INTO utilisateur (login,mot_de_passe,nom,prenom,date_naissance,adresse_mail,photo_profil,date_derniere_connexion,date_creation,role) VALUES ('$login','$mot_de_passe','$nom','$prenom','$date_naissance','$adresse_mail','default.jpg',NOW(),NOW(),'utilisateur')";
    writeDB($mysqli, $sql);
}



function updateProfile($mysqli,$login,$mot_de_passe,$nom,$prenom,$date_naissance,$adresse_mail)
{
    $sql = "UPDATE utilisateur SET mot_de_passe='$mot_de_passe',nom='$nom',prenom='$prenom',date_naissance='$date_naissance',adresse_mail='$adresse_mail' WHERE login='$login'";
    writeDB($mysqli, $sql);
}

function updateProfilePic($mysqli,$login,$photo_profil)
{
    $sql = "UPDATE utilisateur SET photo_profil='$photo_profil' WHERE login='$login'";
    writeDB($mysqli, $sql);
}


function checkAdmin($mysqli,$login)
{
    $sql = "SELECT * FROM utilisateur WHERE utilisateur.login='$login' AND utilisateur.role='administrateur'";
    $profile = readDB($mysqli, $sql);
    
    if (empty($profile)) {
        return true;
    } else {
        return false;
    }
}

function postArticle($mysqli,$titre,$contenu,$note,$nom_jeu,$prix_jeu,$date_sortie_jeu,$synopsis_jeu,$jaquette_jeu,$sous_titre)
{
    $sql = "INSERT INTO article (titre,sous_titre,contenu,note,nom_jeu,prix_jeu,date_sortie_jeu,synopsis_jeu,jaquette_jeu,date_creation,date_modification) VALUES ('$titre','$sous_titre','$contenu',$note,'$nom_jeu',$prix_jeu,'$date_sortie_jeu','$synopsis_jeu','$jaquette_jeu',NOW(),NULL)";
    writeDB($mysqli, $sql);
    $idArticle = mysqli_insert_id($mysqli);
    return $idArticle;
}
function updateArticle($mysqli,$id_article,$titre,$contenu,$note,$nom_jeu,$prix_jeu,$date_sortie_jeu,$synopsis_jeu,$jaquette_jeu,$sous_titre)
{
    $sql = "UPDATE article SET titre='$titre',sous_titre='$sous_titre',contenu='$contenu',note='$note',nom_jeu='$nom_jeu',prix_jeu='$prix_jeu',date_sortie_jeu='$date_sortie_jeu',synopsis_jeu='$synopsis_jeu',jaquette_jeu='$jaquette_jeu',date_modification=NOW() WHERE id_article=$id_article";
    writeDB($mysqli, $sql);
}

function deleteArticle($mysqli,$id_article)
{
    $sql = "DELETE FROM article WHERE id_article=$id_article";
    writeDB($mysqli, $sql);
}


function postSupport($mysqli,$id_article,$id_support)
{
    $sql = "INSERT INTO supportXarticle (id_article,id_support) VALUES ($id_article,$id_support)";
    writeDB($mysqli, $sql);
}

function updateSupport($mysqli,$id_article,$id_support)
{
    $sql = "UPDATE supportXarticle SET id_support=$id_support WHERE id_article=$id_article";
    writeDB($mysqli, $sql);
}

function deleteSupport($mysqli,$id_article)
{
    $sql = "DELETE FROM supportXarticle WHERE id_article=$id_article";
    writeDB($mysqli, $sql);
}

function postCategorie($mysqli,$id_article,$id_categorie)
{
    $sql = "INSERT INTO categorieXarticle (id_article,id_categorie) VALUES ($id_article,$id_categorie)";
    writeDB($mysqli, $sql);
}

function updateCategorie($mysqli,$id_article,$id_categorie)
{
    $sql = "UPDATE categorieXarticle SET id_categorie=$id_categorie WHERE id_article=$id_article";
    writeDB($mysqli, $sql);
}

function deleteCategorie($mysqli,$id_article)
{
    $sql = "DELETE FROM categorieXarticle WHERE id_article=$id_article";
    writeDB($mysqli, $sql);
}

function postImage($mysqli,$id_article,$chemin)
{
    $sql = "INSERT INTO image (id_article,chemin) VALUES ($id_article,'$chemin')";
    writeDB($mysqli, $sql);
}

function updateImage($mysqli,$id_article,$chemin)
{
    $sql = "UPDATE image SET chemin='$chemin' WHERE id_article=$id_article";
    writeDB($mysqli, $sql);
}

function deleteImage($mysqli, $id_article){
    $sql = "DELETE FROM image WHERE id_article=$id_article";
    writeDB($mysqli,$sql);
}

function dejaAvis($mysqli,$id_article,$login)
{
    $sql = "SELECT * FROM avis WHERE avis.id_article=$id_article AND avis.login='$login'";
    $avis = readDB($mysqli, $sql);
    
    if (empty($avis)) {
        return false;
    } else {
        return true;
    }
}

function checkMonAvis($mysqli,$id_avis,$login)
{
    $sql = "SELECT * FROM avis WHERE avis.id_avis=$id_avis AND avis.login='$login'";
    $avis = readDB($mysqli, $sql);
    
    if (!empty($avis)) {
        return true;
    } else {
        return false;
    }
}
function postAvis($mysqli,$id_article,$login,$titre,$texte,$note)
{
    $sql = "INSERT INTO avis (id_article,login,titre,texte,note,date_creation) VALUES ($id_article,'$login','$titre','$texte',$note,NOW())";
    writeDB($mysqli, $sql);
}

function updateAvis($mysqli,$id_avis,$titre,$texte,$note)
{
    $sql = "UPDATE avis SET titre='$titre',texte='$texte',note=$note,date_modification=NOW() WHERE id_avis=$id_avis";
    writeDB($mysqli, $sql);
}

function deleteAvis($mysqli,$id_avis,$login)
{
    $sql = "DELETE FROM avis WHERE id_avis=$id_avis AND login='$login'";
    writeDB($mysqli, $sql);
}

function supprimerAvis($mysqli,$id_article){
    $sql = "DELETE FROM avis WHERE id_article=$id_article";
    writeDB($mysqli,$sql);
}


?>