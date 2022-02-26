<?php
    //Demarrer la session php
    session_start();
?>
<!doctype html>
<html lang="fr">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->

    <link href="assets/css/bootstrap.css" rel="stylesheet"/>
    <link href="assets/css/styles.css" rel="stylesheet"/>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cabin:ital,wght@0,400;0,500;0,600;0,700;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet">

    <title>PHP CRUD CONNEXION</title>
</head>
<body>

<div class="container-fluid">
    <form id="form-login" method="post">
        <div class="text-center">
            <img src="assets/img/logo.png" alt="logo micashop" title="MicaShop.com">
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" required>

        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Mot de passe</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <a href="">mot de passe oublier ?</a>
        <br />
        <button type="submit" name="btn-connexion" class="mt-3 btn btn-warning">Connexion</button>
    </form>
</div>

<?php
    //La fonction de connexion
    function connexion(){
        //faille xss = ON HYDRATE LES DONNÉES = Sanitize
        //trim — Supprime les espaces (ou d'autres caractères) en début et fin de chaîne
        //htmlspecialchars — Convertit les caractères spéciaux en entités HTML :: Cette fonction retourne une chaîne de caractères avec ces modifications
        $emailUtilisateur = trim(htmlspecialchars($_POST['email']));
        $passwordUtilisateur = trim(htmlspecialchars($_POST['password']));

        if(isset($emailUtilisateur) && !empty($emailUtilisateur) && isset($passwordUtilisateur) && !empty($emailUtilisateur)){

            $email = "admin@admin.fr";
            $password = "azerty";

            //Les matchs de connexion
            if($emailUtilisateur === $email && $passwordUtilisateur === $password){
                $_SESSION["email"] = $emailUtilisateur;
                header("Location: pages/produits.php");
            }else{
                echo "<div class='mt-3 container'>
                    <p class='alert alert-danger p-3'>Erreur de connexion: merci de verifié votre email et mot de passe</p>
            </div>";
            }


        }else{
            echo "<div class='mt-3 container'>
                    <p class='alert alert-danger p-3'>Erreur de connexion: merci de remplir tous les champs</p>
            </div>";
        }

        var_dump($emailUtilisateur);
        var_dump($passwordUtilisateur);
    }


    //Le clic sur le bouton connexion
    if(isset($_POST['btn-connexion'])){
        connexion();
    }
?>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>


</body>
</html>