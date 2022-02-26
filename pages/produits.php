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
        <div class="container-fluid">
            <span class="mt-3 d-flex justify-content-around">
                <h3 class="mt-3 text-warning">BIENVENUE <?= $_SESSION['email'] ?></h3>
                <form method="post">
                    <button id="btn-deconnexion" name="btn-deconnexion" class="btn btn-danger">DECONNEXION</button>
                </form>
            </span>


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
                $sql = "SELECT * FROM produits";
                //Grace a PDO on accède à la methode query()
                //PDO::query() prépare et exécute une requête SQL en un seul appel de fonction, retournant la requête en tant qu'objet PDOStatement. (etat des sonnées)
                //PDOStatement = Représente une requête préparée et, une fois exécutée, le jeu de résultats associé.
                $statement = $dbh->query($sql);
            }

            ?>

            <div class="container">
                <div class="text-center">
                    <a href="ajouter_produit.php" class="mt-3 btn btn-outline-secondary">Ajouter un produit</a>
                </div>

                <h4 class="mt-3 text-warning">Vos produits</h4>

                <div class="row">
                    <!--Pour chaque col on affiche une ligne de la table produits de la BDD ecommerce-->
                    <?php
                        foreach ($statement as $produit){
                            $date_depot = new DateTime($produit['date_depot']);
                            ?>
                            <div class="col-sm-12 col-lg-4 mt-5">
                                <div class="card">
                                    <div class="text-center">
                                        <h4 class="card-title text-info"><?= $produit['nom_produit'] ?></h4>
                                        <img src="<?= $produit['image_produit'] ?>" class="card-img-top img-fluid" alt="<?= $produit['nom_produit'] ?>" title="<?= $produit['nom_produit'] ?>">
                                    </div>


                                    <div class="card-body">

                                        <p class="card-text"><?= $produit['description_produit'] ?></p>
                                        <p class="card-text text-success fw-bold">PRIX : <?= $produit['prix_produit'] ?> €</p>
                                        <p class="card-text">DISPONIBLE :
                                            <?php
                                            //var_dump($produit['stock_produit']);
                                            if($produit['stock_produit'] == true){
                                                echo "OUI";
                                            }else{
                                                echo "NON";
                                            }
                                            ?>
                                        </p>

                                        <em class="card-text">Date de depot : <?= $date_depot->format('d-m-Y') ?></em>
                                        <br />
                                        <div class="container-fluid d-flex justify-content-center">

                                                <a href="produit_details.php?id_produit=<?= $produit['id_produit'] ?>" class="mt-2 btn btn-success">Détails</a>
                                                <a href="editer_produit.php?id_produit=<?= $produit['id_produit'] ?>" class="mt-2 btn btn-warning">Editer</a>
                                                <a href="supprimer_produit.php?id_produit=<?= $produit['id_produit'] ?>" class="mt-2 btn btn-danger">Supprimer</a>

                                        </div>

                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                    ?>

                </div>
            </div>
        </div>
    </body>
    </html>


    <?php
    //Deconnexion et destruction de la session $_SESSION['email']
    function deconnexion(){
        var_dump("hello");
        echo "elloo";
        session_unset();
        session_destroy();
        header('Location: ../index.php');
    }

    //Click sur le bouton de deconnexion
    if(isset($_POST['btn-deconnexion'])){
        deconnexion();
    }

}else{
    echo "<a href='' class='btn btn-warning'>S'inscrire</a>";
    header('Location: ../index.php');
}

