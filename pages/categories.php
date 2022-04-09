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

        <div class="mb-4">
            <button onclick="showHideForm()" class="btn btn-outline-success">Ajouter une categorie</button>
        </div>

        <form method="post" action="traitement_ajouter_categorie.php" enctype="multipart/form-data" id="formulaire-vendeur">
            <div class="mb-4">
                <label for="type_categorie">Type de catégorie</label>
                <input class="form-control" type="text" id="type_categorie" name="type_categorie" placeholder="Jardin" required>
            </div>

            <div class="mb-4">
                <button class="btn btn-outline-info">Ajouter la categorie</button>
            </div>
        </form>
    </div>

    <div class="container table-responsive">
        <table class="table table-warning table-striped table-sm">
            <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Catégorie</th>
                <th scope="col">Editer</th>

            </tr>
            </thead>
            <tbody>

            <?php
            $sql = "SELECT * FROM categories";
            $categories = $dbh->query($sql);
            foreach ($categories as $categorie){
                ?>
                <tr class="align-middle">
                    <th scope="row"><?= $categorie['id_categorie'] ?></th>
                    <td>
                        <?= $categorie['type_categorie'] ?>
                    </td>
                    <td>
                        <a class="btn btn-outline-info" href="editer_categorie.php?id_categorie=<?= $categorie['id_categorie'] ?>">Editer</a>
                    </td>
                </tr>
                <?php
            }
            ?>



            </tbody>
        </table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="../assets/js/app.js" type="text/javascript"></script>

    </body>
    </html>

    <?php
}else{
    header('Location: ../index.php');
}

