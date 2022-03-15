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
//Connexion a PDO MySQL
try {
    $db = new PDO("mysql:host=localhost;dbname=ecommerce;charset=UTF8", "root", "");
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Vous etes connectez a PDO MySQL";
}catch (PDOException $exception){
    echo "erreur " .$exception->getMessage();
}

//requete de selection de tous les utilisateurs
$sql = "SELECT * FROM `utilisateurs`";
//On parcours les utilisateurs et on les stock dans une variable
$utilisateurs = $db->query($sql);

?>

<div class="container">
    <table class="table table-striped">
        <thead>
        <tr>
            <th scope="col">#ID</th>
            <th scope="col">Email</th>
            <th scope="col">Mot de passe</th>
            <th scope="col">EDITER</th>
            <th scope="col">SUPPRIMER</th>
        </tr>
        </thead>
        <tbody>
        <?php
        //On recup notre tableau d'utilisateur et on parcours en bouclant sur un alias
            foreach ($utilisateurs as $utilisateur){
                ?>
                <tr>
                    <!--ici alis['intitulé de la colonne phpMyAdmin table utilisateurs']-->
                    <th scope="row"><?= $utilisateur['id_users'] ?></th>
                    <td><?= $utilisateur['email'] ?></td>
                    <td><?= $utilisateur['password'] ?></td>
                    <td>
                        <a href="" class="btn btn-success">EDITER</a>
                    </td>
                    <td>
                        <a href="suppimer_utilisateur.php?id_utilisateur=<?= $utilisateur['id_users'] ?>" class="btn btn-success">SUPPRIMER</a>
                    </td>
                </tr>
        <?php
            }

        ?>


        </tbody>
    </table>
</div>
<?php
}else{
    header("Location: ../index.php");
}
?>
</body>
</html>
