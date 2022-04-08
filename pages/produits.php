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
                    <div class="d-flex justify-content-center">
                        <button id="btn-deconnexion" name="btn-deconnexion" class="btn btn-danger">DECONNEXION</button>
                        <a href="inscription.php" class="mx-3 btn btn-info">Ajouter un administrateur</a>
                    </div>

                </form>
            </span>


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

        if($dbh){
            //ATTENTION A CHAQUE REDIRECTION VERS LA PAGE PRODUITS on ajoute ?page=1

            if(isset($_GET['page'])){
                $page = $_GET['page'];
            }else{
                $page = "page=1";
            }
            //nombre de produit a afficher = LIMIT SQL
            $limite = 3;
            //OFFSET on demarre sous entendu (page -1 recup l'index) * 3
            //var_dump($page - 1);
            $debut = ($page - 1) * $limite;

            //Requète SQL de selection des produits avec une limte et un point de depart = OFFSET
            $sql = "SELECT * FROM produits INNER JOIN categories ON produits.categories_id = categories.id_categorie INNER JOIN vendeurs ON produits.vendeur_id = vendeurs.id_vendeur LIMIT $limite OFFSET $debut";
            //Grace a PDO on accède à la methode query()
            //PDO::query() prépare et exécute une requête SQL en un seul appel de fonction, retournant la requête en tant qu'objet PDOStatement. (etat des sonnées)
            //PDOStatement = Représente une requête préparée et, une fois exécutée, le jeu de résultats associé.
            $statement = $dbh->query($sql);

            //compté les entrées = ic on compte les id clé primaire de la table produits
            $resultRow = $dbh->query("SELECT COUNT(id_produit) FROM produits");
            //On stock dans une variable le nombre de colonne
            //PDOStatement::fetchColumn — Retourne une colonne depuis la ligne suivante d'un jeu de résultats
            $total = $resultRow->fetchColumn();
            //ceil — Arrondit au nombre supérieur
            $nombrePage = ceil($total / $limite);

            ?>
            <div class="text-center">
                <img width="10%" src="../assets/img/logo.png" alt="Annonces.com" title="Annonce.com">
            </div>
            <div class="d-flex flex-row justify-content-center mt-5">
                <nav aria-label="Page navigation example">
                    <ul class="pagination">
                        <?php
                        if ($page > 1):
                            ?><li class="page-item"><a class="btn btn-warning" href="?page=<?php echo $page - 1; ?>">Page précédente</a></li><?php
                        endif;

                        /* On va effectuer une boucle autant de fois que l'on a de pages */
                        for ($i = 1; $i <= $nombrePage; $i++):
                            ?><li class="page-item"><a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a></li><?php
                        endfor;

                        /* Avec le nombre total de pages, on peut aussi masquer le lien
                         * vers la page suivante quand on est sur la dernière */
                        if ($page < $nombrePage):
                            ?><li class="page-item"><a class="btn btn-info" href="?page=<?php echo $page + 1; ?>">Page suivante</a></li><?php
                        endif;
                        ?>

                    </ul>
                </nav>
            </div>

            <?php
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
                                <p class="mt-3 text-danger">Catégorie : <?= $produit['type_categorie'] ?></p>
                                <p class="text-info">Vendeur :</p>
                                <div class="d-flex align-items-center">
                                    <img src="<?= $produit['avatar_vendeur'] ?>" alt="" title="" width="20%">
                                    <?= $produit['prenom_vendeur'] ?>
                                    <?= $produit['nom_vendeur'] ?>
                                </div>
                                <p class="mt-3 text-info">Email : </p>
                                <p class="text-warning"><?= $produit['email_vendeur'] ?></p>
                                
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

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

    header('Location: ../index.php');
}

