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
    $sql = "SELECT * FROM produits WHERE id_produit = ?";

    $id_produit = $_GET['id_produit'];
    //Grace a PDO on accède à la methode query()
    //Requète préparée
    $request = $dbh->prepare($sql);
    //Lié les paramètres
    $request->bindParam(1, $id_produit);

    //Execution de la requète
    $request->execute();
    //Retourne un objet de resultats
    $details = $request->fetch(PDO::FETCH_ASSOC);

}

?>
    <form method="post" id="details">
        <p class="text-center text-danger">SUPPRIMER LE PRODUIT</p>
        <p class="text-center text-danger"><?= $details['nom_produit'] ?></p>
        <p class="text-center text-danger"><?= $details['description_produit'] ?></p>
        <p class="text-center text-danger">
           <img src="<?= $details['image_produit'] ?>" class="img-thumbnail" alt="" title="" width="200"/>
        </p>
        <div class="d-flex justify-content-center">

            <button type="submit" name="btn-supprimer" class="btn btn-danger">Confimer</button>
            <a href="produits.php?page=1" class="btn btn-success">Annuler</a>
        </div>

    </form>
<?php

if(isset($_POST['btn-supprimer'])){
    //Requète SQL de selection des produits
    $sql = "DELETE FROM `produits` WHERE id_produit =  ?";
    //Creer une requète préparée pour lutter contre les injection SQL
    $delete = $dbh->prepare($sql);
    //Recup de id du produit
    $idProduit = $_GET['id_produit'];
    //Lié les paramètres du bouton a la requète SQL
    $delete->bindParam(1, $idProduit);
    $delete->execute();
    if($delete){
        echo "<p class='container alert alert-success'>Votre produit a bien été supprimer !</p>";
        echo "<div class='container'><a href='produits.php?page=1' class='mt-3 btn btn-success'>RETOUR</a></div>";
        ?>
            <style>
                #details{
                    display: none;
                }
            </style>
        <?php
    }else{
        echo "<p class='alert alert-danger'>Erreur lors de la supression du produit !</p>";
    }
   
}






}else{
    echo "<a href='' class='btn btn-warning'>S'inscrire</a>";
}
?>
</body>
</html>

