<?php
//Demarrer la session php
session_start();
if(isset($_SESSION["email"])){

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
        $sql = "SELECT * FROM produits INNER JOIN categories ON produits.categories_id = categories.id_categorie WHERE id_produit = ?";

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




        <div class="container">

            <!--On passe ID pour le traitement-->

            <form action="traitement_editer_produit.php?id_produit=<?= $details['id_produit'] ?>"  id="form-update" method="post" enctype="multipart/form-data">
                <h3 class="text-info">EDITER LE PRODUIT</h3>
                <div class="text-center img-logo">
                    <img src="../assets/img/logo.png" alt="logo micashop" title="MicaShop.com">
                </div>
                <div class="mb-3">
                    <label for="nom_produit" class="form-label">Nom du produit</label>
                    <input type="text" class="form-control" id="nom_produit" name="nom_produit" value="<?= $details['nom_produit'] ?>" required>
                </div>

                <div class="mb-3">
                    <label for="description_produit" class="form-label">Description</label>
                    <textarea class="form-control" rows="5" id="description_produit" name="description_produit" value="<?= $details['description_produit'] ?>" required>
                        <?= $details['description_produit'] ?>
                    </textarea>
                </div>

                <div class="mb-3">
                    <label for="prix_produit" class="form-label">Prix du produit</label>
                    <input type="number" step="0.01" class="form-control" id="prix_produit" name="prix_produit" value="<?= $details['prix_produit'] ?>" required>
                </div>

                <div class="mb-3">
                    <label for="stock_produit" class="form-label">Disponible</label>
                    <select class="form-control" name="stock_produit" id="stock_produit" required>
                        <option value="0">OUI</option>
                        <option value="1">NON</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="date_depot" class="form-label">Date de dépot du produit</label>
                    <input type="date" class="form-control" id="date_depot" name="date_depot" required>
                </div>

                <div class="mb-3">
                    <label for="image_produit" class="form-label">Image du produit</label>
                    <input type="file" class="form-control" id="image_produit" name="image_produit" required value="<?= $details['image_produit'] ?>">
                </div>

                <div class="mb-3">
                        Catégories :
                        <select name="categories" class="form-control">

                            <?php
                            $sql = "SELECT * FROM categories";
                            $categories = $dbh->query($sql);

                            foreach ($categories as $categorie) {
                                ?>
                                <option class="text-success" value="<?= $categorie['id_categorie'] ?>"><?= $categorie['type_categorie'] ?></option>
                                <?php
                            }
                            ?>
                        </select>
                </div>

                <div class="mb-3">
                    Vendeurs :
                    <select name="vendeurs" class="form-control">

                        <?php
                        $sql = "SELECT * FROM vendeurs";
                        $vendeurs = $dbh->query($sql);

                        foreach ($vendeurs as $vendeur) {
                            ?>
                            <option class="text-success" value="<?= $vendeur['id_vendeur'] ?>"><?= $vendeur['nom_vendeur'] ?> <?= $vendeur['prenom_vendeur'] ?></option>
                            <?php
                        }
                        ?>
                    </select>
                </div>


                <div class="d-flex justify-content-around">
                    <button type="submit" name="btn-connexion" class="btn btn-warning">Mettre a jour</button>
                    <a href="produits.php?page=1" class="btn btn-success">Annuler</a>
                </div>
            </form>

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
}



