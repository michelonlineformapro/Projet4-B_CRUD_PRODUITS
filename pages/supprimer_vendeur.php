<?php
//Demarrer la session php
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
//Connexion a la base de donnée ecommerce via PDO
//Les variable de phpmyadmin
$user = "root";
$pass = "";
//test d'erreur
try {
    /*
     * PHP Data Objects est une extension définissant l'interface pour accéder à une base de données avec PHP. Elle est orientée objet, la classe s’appelant PDO.
     */
    //Instance de la classe PDO (Php Data Object)
    $dbh = new PDO('mysql:host=localhost;dbname=ecommerce;charset=UTF8', $user, $pass);
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
?>
<!--phpstorm multiple select same word Alt + j-->
<div class="container">
    <?php
        $sql = "SELECT * FROM vendeurs WHERE id_vendeur = ?";
        $request = $dbh->prepare($sql);
        $id_vendeur = $_GET['id_vendeur'];
        $request->bindParam(1, $id_vendeur);
        $request->execute();
        $vendeur = $request->fetch();
    ?>
    <div class="text-center" id="vendeur">
        <img src="<?= $vendeur['avatar_vendeur'] ?>" alt="" title="">
        <h3 class="text-danger"><?= $vendeur['nom_vendeur'] ?> <?= $vendeur['prenom_vendeur'] ?></h3>
        <h4 class="text-info"><?= $vendeur['email_vendeur'] ?></h4>
        <form method="post">
            <button type="submit" name="btn-delete" class="btn btn-outline-warning">Suppression du vendeur et du produit</button>
            <a href="vendeurs.php" class="btn btn-outline-info" style="color: darkred">Retour</a>
        </form>

    </div>
</div>
<?php
//Supprimer un vendeur NE PAS OUBLIER sur la table parent
//structure --> vue relationelle -> ON DELETE ET UPDATE CASCADE
if(isset($_POST['btn-delete'])){
    echo "bonjour";
    $sql = "DELETE FROM `vendeurs` WHERE id_vendeur = ?";
    $delete = $dbh->prepare($sql);
    $id = $_GET['id_vendeur'];
    $delete->bindParam(1, $id);
    $delete->execute();
    if($delete){
        echo "<div class='text-center'>
        <p class='alert alert-success'>Le vendeur a bien été supprimer !</p>
        <a href='vendeurs.php' class='btn btn-success'>Retour</a>
    </div>";
        ?>
        <style>
            #vendeur{
                display: none;
            }
        </style>
        <?php
    }else{
        echo "<div class='text-center'>
        <p class='alert alert-danger'>Erreur lors de la supression du vendeur</p>
        <a href='vendeurs.php' class='btn btn-success'>Retour</a>
    </div>";
    }
}



}else{
    header("Location: ../index.php");
}
?>
</body>
</html>
