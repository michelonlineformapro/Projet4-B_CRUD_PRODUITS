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
try {
    $db = new PDO("mysql:host=localhost;dbname=ecommerce;charset=UTF8", "root", "");
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //echo "Vous etes connectez a PDO MySQL";
}catch (PDOException $exception){
    echo "erreur " .$exception->getMessage();
}

?>

<div class="container">
    <form method="post" id="form-register">
        <div class="text-center" id="logo-bg">
            <img src="../assets/img/logo.png" alt="logo micashop" title="MicaShop.com">
        </div>
        <h4 class="text-center text-info">AJOUTER UN ADMINISTRATEUR</h4>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" required>

        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Mot de passe</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>

        <div class="mb-3">
            <label for="password_repeat" class="form-label">Répeter le mot de passe</label>
            <input type="password" class="form-control" id="password_repeat" name="password_repeat" required>
        </div>

        <input type="hidden" value="ADMIN" name="role">

        <button type="submit" name="btn-ajouter-admin" class="mt-3 btn btn-info">AJOUTER</button>
    </form>
</div>

<?php

//Debug des champs du formulaire form = method post + attrubut name=""
/*
var_dump($_POST['email']);
var_dump($_POST['password']);
var_dump($_POST['password_repeat']);
*/




//Si les champ du formulaire existe et ne sont pas vide
if(isset($_POST['email']) && !empty($_POST['email']) && isset($_POST['password']) && !empty($_POST['password'])){
    //Desinfecter les champs
//lutter contre faille XSS = sanitize datas
//trim = retire les espaces en debut et fin de chaine de caractères
//htmlspecialchar = transforme les caractère speciaux (ex: <script>) en chaine de caractère
    $emailAdmin = trim(htmlspecialchars($_POST['email']));
    $passwordAdmin = trim(htmlspecialchars($_POST['password']));
    $password_repeat_admin = trim(htmlspecialchars($_POST['password_repeat']));
    //Verification du password repeat === a password
    if($passwordAdmin === $password_repeat_admin){
        //Ecire la requète sql = insere les valeur du formulaire dans la table utilisateurs
        $sql = "INSERT INTO `utilisateurs`(`email`, `password`) VALUES (?,?)";
        //lutter contre injection SQL = var = connexion->methode prepare de la classe PDO
        $insertUser = $db->prepare($sql);
        //Lié les elements du formulaire a ma requète SQL ?,? = champ du formulaire rempli par utilisateur

        $insertUser->bindParam(1, $emailAdmin);
        $insertUser->bindParam(2, $passwordAdmin);

        //Executer la requète et retouner un tableau associatif
        $insertUser->execute(array(
            $emailAdmin,
            $passwordAdmin
        ));

        //Si la requète marche
        if($insertUser == true){
            //On affiche un message de succès + un bouton pour se connecter et on cache le formulaire
            ?>
            <div class="container">
                <?php
            echo "<p class='alert alert-success p-3 mt-3'>Vous etes inscrits</p>";
            echo "<a class='btn btn-success mt-3' href='../index.php'>Se connecter</a>";
            ?>
            </div>
            <!-- Du javascript
                <script>
                    alert("Vous etes connectez");
                    let form = document.getElementById("form-register");
                    form.style.display = "none";
                </script>
                -->
            <style>
                #form-register{
                    display: none;
                }
            </style>
            <?php
        }else{
            //Sinon on affiche une erreur
            echo "<div class='container'>
                <p class='alert alert-danger'>Merci de remplir tous les champs !</p></div>";
        }

        //Erreur si le 2 mot de passe ne sont pas identique
    }else{
        echo "<div class='container'>
            <p class='alert alert-danger'>Les 2 mots de passe ne sont pas identiques</p></div>";
    }
}

?>


</body>

</html>
