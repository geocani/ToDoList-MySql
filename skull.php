    <!-- @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@ - Connection a la base de donnée - @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@ 
-->
    <?php

    try {
        $bdd = new PDO('mysql:host=localhost;dbname=geoffrey;charset=utf8', 'root', 'root');
    }
    catch(Exception $e) { 

    die('Erreur : '.$e->getMessage()); 
    }

    ?>

    <!-- @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@ - Ecriture dans la base de donnée - @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
-->
    <?php

      if(isset($_POST['submit']) AND !empty($_POST['ajout'])){

          $ajout = filter_var($_POST['ajout'], FILTER_SANITIZE_STRING); // Sanitisation post ajout tache.
          $action1 = $bdd->query('INSERT INTO todolist(tache, stat) VALUES("'.$ajout.'","true")');
      }

    ?>

    <!-- @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@ - Modifier la base de donnée - @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
-->
    <?php

      if (isset($_POST['archiver'])&& isset($_POST['ok'])){

        filter_var($_POST['archiver'], FILTER_SANITIZE_STRING);
        filter_var($_POST['ok'], FILTER_SANITIZE_STRING);
        
        for ($i = 0 ; $i < count($_POST['ok']); $i++){
            $bdd->query('UPDATE todolist SET stat = "false" WHERE tache= "'.$_POST['ok'][$i].'"');
        }
    }

    ?>

        <!-- @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@ - FIN - @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@ -->


<!DOCTYPE html>
<html lang="fr">

  <head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <meta http-equiv="X-UA-Compatible" content="ie=edge">
     <title>Becodeorg - Charleroi - To do list PHP JSON - Muyshond Daniel & Canivet Geoffrey</title>
     <link rel="stylesheet" href="css/style.css">
  </head>
  <body>

    <section class="page">
      <form class="archiver" action="skull.php" method="post">
        <h1>To do list</h1>
        <h2>ToDo</h2>

    <!-- @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@ - Affichage taches à faire - @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@ 
-->
            <?php

                $afficheTodo = $bdd->query("SELECT tache FROM todolist WHERE stat LIKE 't%'"); 
              
                while ($donnees = $afficheTodo->fetch()) { 

                echo '<label><input type="checkbox" name="ok[]" value="'.$donnees['tache'].'">'.$donnees['tache'].'</label><br/>';
                }

              ?> 
    <!-- @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@ - FIN - @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@ -->
        <br>
        <input class="bouton" type="submit" name="archiver" value="Archiver">
        <div class="archive">
        <h2>Archive</h2>

    <!-- @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@ - Affichage taches archivée - @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@ 
-->
            <?php
               $afficheArchive = $bdd->query("SELECT tache FROM todolist WHERE stat LIKE 'f%'"); 
              
               while ($donnees = $afficheArchive->fetch()) { 

               echo '<s><label><input type="checkbox" name="ok[]" value="'.$donnees['tache'].'">'.$donnees['tache'].'</label><br/></s>';
               }
            ?>
    <!-- @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@ - FIN  - @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@ -->
        </div>

      </form>
      <form class="ajouter" action="skull.php" method="POST">
        <h2>Ajouter une tâche</h2>
        <input type="text" name="ajout"><br>
        <span class="error"><?php echo $taskError; ?></span>
        <br><br>
        <input class="bouton" type="submit" name="submit" value="Ajouter">
        
        <input class="bouton" type="submit" name="supprimer" value="Effacer"><br>

      </form>
    </section>
    <footer>
      <h3> &copy; <a href="https://github.com/dmshd">Daniel</a> et <a href="https://github.com/geocani">Geoffrey</a> 2018 - 2019</h3>
    </footer>
  </body>
</html>
