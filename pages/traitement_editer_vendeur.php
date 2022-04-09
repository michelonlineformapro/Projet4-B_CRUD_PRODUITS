
<?php
session_start();
if(isset($_SESSION["email"])){
?>
<!doctype html>
<html lang="fr">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->

    <link href="../assets/css/bootstrap.css" rel="stylesheet"/>
    <link href="../assets/css/styles.css" rel="stylesheet"/>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cabin:ital,wght@0,400;0,500;0,600;0,700;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet">

    <title>PHP CRUD CONNEXION</title>
</head>
<body>
<header>
    <?php
    require_once "menu.php";
    ?>
</header>
<?php
/////////////NE PAS OUBLIER : <form enctype="multipart/form-data">//////////////////

//Upload de fichier
//Existance de ma superglobale $_FILES
//<input de type file + attribut name="">

if(isset($_FILES['avatar_vendeur'])){
    //Repertoire de destination
    $repertoireDestination = "../assets/img/";
    //La photo uploader
    //basename — Retourne le nom de la composante finale d'un chemin
    //dans tableau multi dimmension 1 = image 2 = son nom
    $photo_produit = $repertoireDestination . basename($_FILES['avatar_vendeur']['name']);
    //Recup de l'image uploader
    //On assigne l'image uploader au repertoire de destination + la photo + son nom
    $_POST['avatar_vendeur'] = $photo_produit;

    //Les conditions de resussite
    //move_uploaded_file — Déplace un fichier téléchargé
    //On assigne a la photo un nom temporaire random en cas d'echec d'upload
    if(move_uploaded_file($_FILES['avatar_vendeur']['tmp_name'], $photo_produit)){
        echo "<p class='container alert alert-success'>Le fichier est valide et téléchargé avec succès !</p>";
    }else{
        echo "<p class='container alert alert-danger'>Erreur lors du téléchargement de votre fichier !</p>";
    }
}else{
    echo "<p class='container alert alert-danger'>Le fichier est invalide seul les format .png, .jpg, .bmp, .svg, .webp sont autorisé !</p>";
}


//Connexion a la base de donnée ecommer via PDO
//Les variable de phpmyadmin
$user = "root";
$pass = "";
//test d'erreur
try {
    /*
     * PHP Data Objects est une extension définissant l'interface pour accéder à une base de données avec PHP. Elle est orientée objet, la classe s’appelant PDO.
     */
    //Instance de la classe PDO (Php Data Object)
    $dbh = new PDO('mysql:host=localhost;dbname=ecommerce', $user, $pass);
    //Debug de pdo
    /*
     * L'opérateur de résolution de portée (aussi appelé Paamayim Nekudotayim) ou, en termes plus simples,
     * le symbole "double deux-points" (::), fournit un moyen d'accéder aux membres static ou constant, ainsi qu'aux propriétés ou méthodes surchargées d'une classe.
     */
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "<p class='container alert alert-success text-center'>Vous êtes connectez a PDO MySQL</p>";

} catch (PDOException $e) {
    print "Erreur !: " . $e->getMessage() . "<br/>";
    die();
}

if($dbh){
    //Requète SQL de selection des produits
    $sql = "UPDATE `vendeurs` SET `nom_vendeur`= ?,`prenom_vendeur`= ?,`email_vendeur`= ?,`avatar_vendeur`= ? WHERE id_vendeur = ?";
    //Requète préparée = connexion + methode prepare + requete sql
    //Les requètes préparée lutte contre les injections SQL
    //PDO::prepare — Prépare une requête à l'exécution et retourne un objet
    $update = $dbh->prepare($sql);
    //executer la requète préparée
    //PDOStatement::execute — Exécute une requête préparée
    //Elle execute la reqète passé dans un tableau de valeur
    $update->execute(array(
        $_POST['nom_vendeur'],
        $_POST['prenom_vendeur'],
        $_POST['email_vendeur'],
        $_POST['avatar_vendeur'],
        $_GET['id_vendeur']
    ));

    if($update){
        echo "<p class='container alert alert-success'>Votre vendeur a été mis a jour avec succès !</p>";
        echo "<div class='text-center'><a href='vendeurs.php' class='container btn btn-success'>Voir les vendeur</a></div> ";
    }else{
        echo "<p class='alert alert-danger'>Erreur lors de la mise a jour du vendeur</p>";
    }
}
}else{
    header("Location: ../index.php");
}
?>


