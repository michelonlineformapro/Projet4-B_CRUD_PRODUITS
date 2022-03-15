<?php
session_start();
if(isset($_SESSION['email'])){
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
//Connexion a PDO
try {
    $db = new PDO("mysql:host=localhost;dbname=ecommerce;charset=UTF8", "root", "");
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Vous etes connectez a PDO MySQL";
}catch (PDOException $exception){
    echo "erreur " .$exception->getMessage();
}

//Requète SQL

$sql = "DELETE FROM `utilisateurs` WHERE id_users = ?";

//Stock et Recup de id dans l'url avec la super globale GET
$id = $_GET['id_utilisateur'];
//Requète préparée pour lutter contre les injection SQL
$delete = $db->prepare($sql);
//On lie le paramètre de la requète SQL (le ?) a l'id resup dans URL
$delete->bindParam(1, $id);
//On execute la requète et retourne un tableau associatif
$delete->execute();
//Si ca marche
if($delete == true){
    ?>
        <div class="container">
    <?php
    //message de succès + bouton de retour
    echo "<p class='alert alert-success'>L'utilisateur a bien été supprimer</p>";
    echo "<a href='administrateurs.php' class='btn btn-warning'>Retour</a>";
    ?>
        </div>
    <?php
    //Sinon une erreur
}else{
    echo "<div class='container'><p class='alert alert-danger'>Erreur lors de la supression de utilisateur</p></div>";
    var_dump($delete);
}

}else{
    header("Location: ../index.php");
}

?>
</body>
</html>
