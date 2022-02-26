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




        <div class="container">

            <form action="traitement_ajouter_produit.php"  id="form-login" method="post" enctype="multipart/form-data">
                <div class="text-center">
                    <img src="../assets/img/logo.png" alt="logo micashop" title="MicaShop.com">
                </div>
                <div class="mb-3">
                    <label for="nom_produit" class="form-label">Nom du produit</label>
                    <input type="text" class="form-control" id="nom_produit" name="nom_produit" required>
                </div>

                <div class="mb-3">
                    <label for="description_produit" class="form-label">Description</label>
                    <textarea class="form-control" rows="5" id="description_produit" name="description_produit" required></textarea>
                </div>

                <div class="mb-3">
                    <label for="prix_produit" class="form-label">Prix du produit</label>
                    <input type="number" step="0.01" class="form-control" id="prix_produit" name="prix_produit" required>
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
                    <input type="file" class="form-control" id="image_produit" name="image_produit" required>
                </div>

                <div class="d-flex justify-content-around">
                    <button type="submit" name="btn-connexion" class="btn btn-warning">Ajouter</button>
                    <a href="produits.php" class="btn btn-success">Annuler</a>
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


