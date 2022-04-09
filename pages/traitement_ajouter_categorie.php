
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
    $sql = "INSERT INTO `categories`(`id_categorie`, `type_categorie`) VALUES (?,?)";
    //Requète préparée = connexion + methode prepare + requete sql
    //Les requètes préparée lutte contre les injections SQL
    //PDO::prepare — Prépare une requête à l'exécution et retourne un objet
    $insert = $dbh->prepare($sql);
    //Bindé les paramètre
    //Liés les paramètre du formulaire a la table phpmyadmin
    //PDOStatement::bindParam — Lie un paramètre à un nom de variable spécifique
    $insert->bindParam(1, $_POST['id_categorie']);
    $insert->bindParam(2, $_POST['categorie']);


    //executer la requète préparée
    //PDOStatement::execute — Exécute une requête préparée
    //Elle execute la reqète passé dans un tableau de valeur
    $insert->execute(array(
        $_POST['id_categorie'],
        $_POST['type_categorie'],
    ));

    if($insert){
        echo "<p class='container alert alert-success'>Votre catégorie a été ajouté avec succès !</p>";
        echo "<div class='text-center'><a href='categories.php' class='container btn btn-success'>Voir les vendeurs</a></div>";
    }else{
        echo "<p class='alert alert-danger'>Erreur lors de l'ajout de la catégorie</p>";
    }
}
}else{
    header("Location: ../index.php");
}
?>


