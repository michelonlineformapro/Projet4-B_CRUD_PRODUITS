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
        <div class="text-center" id="img-form-login">
            <img src="assets/img/logo.png" alt="logo micashop" title="MicaShop.com">
        </div>
        <div class="text-center">
            <h3 class="mt-3 text-info">CONNEXION</h3>
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

        $utilisateur_phpadmin = "root";
        $mot_passe_phpadmin = "";
        $dbname = "ecommerce";
        $hote = "localhost";


        try {

            //Var de connexion
            $db = new PDO("mysql:host=".$hote.";dbname=".$dbname.";charset=UTF8", $utilisateur_phpadmin, $mot_passe_phpadmin);
            //debug de la connexion a MySQL
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            echo "Connexion A MySQL via la classe PDO";

            //bloc erreur
        }catch (PDOException $exception){
            echo "Erreur de connexion a PDO MySQL " . $exception->getMessage();
            var_dump($db);
            die();
        }



        //Existence des champs et non vide
        if(isset($_POST['email']) && !empty($_POST['email']) && isset($_POST['password']) && !empty($_POST['password'])){
            //faille xss = ON DESINFECTE LES DONNÉES = Sanitize
            //trim — Supprime les espaces (ou d'autres caractères) en début et fin de chaîne
            //htmlspecialchars — Convertit les caractères spéciaux en entités HTML :: Cette fonction retourne une chaîne de caractères avec ces modifications
            $emailUtilisateur = trim(htmlspecialchars($_POST['email']));
            $passwordUtilisateur = trim(htmlspecialchars($_POST['password']));

            //Requete avec le prediquats AND = &&
            $sql = "SELECT * FROM utilisateurs WHERE email = ? AND password = ?";

            //requète préparée pour lutter contre les inection SQL
            $connexion = $db->prepare($sql);

            //Lie les paramètre du formulaire a  la requète SQL
            $connexion->bindParam(1, $emailUtilisateur);
            $connexion->bindParam(2, $passwordUtilisateur);

            //Execute la requète et retourne un tableau associatif
            $connexion->execute();

            //Si on a au moins 1 utilisateur dans table (index du tableau commence par 0)
            if($connexion->rowCount() >= 0){
                //On stock dans une variable le dernier resultat
                //PDOStatement::fetch — Récupère la ligne suivante d'un jeu de résultats PDO
                $ligne = $connexion->fetch();
                //Si on a un resultat = return true
                if($ligne){
                    //On recup les email et password de la table utilisateurs
                    $email = $ligne['email'];
                    $password = $ligne['password'];

                    //Condition de connexion
                    //Si entrée utilisateur = valeurs dans la table pour email et mot de passe
                    if($emailUtilisateur === $email && $passwordUtilisateur === $password){
                        //On stock la connexion dans une variable de session et on redirige ves la page d'accueil
                        $_SESSION['email'] = $emailUtilisateur;
                        header("Location: pages/produits.php?page=1");
                    }else{
                        //Erreur de mail et mot de passe
                        echo "<div class='mt-3 container'>
                    <p class='alert alert-danger p-3'>Erreur de connexion: merci de verifié votre email et mot de passe</p>
                    </div>";
                    }
                }else{
                    //pas d'utilisateur dans la table
                    echo "<div class='mt-3 container'>
                    <p class='alert alert-danger p-3'>Erreur de connexion: Aucun utilisateur dans votre table</p>
                    </div>";
                }

            }else{
                //Idem
                echo "Votre table est vide";
            }


        }else{
            //Certains champs sont vide
            echo "Merci de remplir tous les champs";
        }


        //Debug
        var_dump($emailUtilisateur);
        var_dump($passwordUtilisateur);
    }


    //Le clic sur le bouton on appel la fonction de  connexion
    if(isset($_POST['btn-connexion'])){
        connexion();
    }
?>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>


</body>
</html>