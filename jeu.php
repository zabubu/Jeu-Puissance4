<head>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.6/dist/sweetalert2.min.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.6/dist/sweetalert2.min.js"></script>
</head>
<?php
    define('HOST', 'localhost');
    define('USER', 'root');
    define('PWD',  '');

    include 'function.php';
    include 'jeu.css';
    // on inclue les fonctions et le css correspondant
    // on affiche un joli titre =)
    echo '<center><div id="title">Jeu puissance 4</div></center>';

    if(isset($_POST['bg_color'])) 
    {
        $bg_color = $_POST['bg_color'];
        echo '<body style="background-color: '.$bg_color.'; background-size: cover;">';
    }
    else 
    {
        echo '<body style="background-size: cover;">';
    }


    session_start();
    // on va utiliser htmlentities pour eviter de lire du code par exemple dans les champs //noms

    $Jetonvide = htmlentities("Vide", ENT_QUOTES);// ent_quote c'est pour les guillemets
    // (merci la documentation )

    if (isset($_SESSION['JoueurC']) && !empty($_SESSION['JoueurC'])) 
    // On récupère le joueur courant
    {
        $JoueurC = $_SESSION['JoueurC'];
    }
    else 
    {
        $JoueurC = 1;
    } // le joueur dont c'est son tour

    $nom1 = isset($_POST['Joueur1']) && !empty($_POST['Joueur1']) ? htmlentities($_POST['Joueur1'], ENT_QUOTES) : (isset($_SESSION['Joueur1']) && !empty($_SESSION['Joueur1']) ? $_SESSION['Joueur1'] : htmlentities("Joueur1", ENT_QUOTES));

    $_SESSION['Joueur1'] = $nom1;

    $nom2 = isset($_POST['Joueur2']) && !empty($_POST['Joueur2']) ? htmlentities($_POST['Joueur2'], ENT_QUOTES) : (isset($_SESSION['Joueur2']) && !empty($_SESSION['Joueur2']) ? $_SESSION['Joueur2'] : htmlentities("Joueur2", ENT_QUOTES));

    $_SESSION['Joueur2'] = $nom2;

    if(isset($_POST['couleur1']) && !empty($_POST['couleur1']))
    {
        if($_POST['couleur1']=="Jaune")
        {
            $_SESSION['couleur1'] = $couleur1 = htmlentities("Jaune", ENT_QUOTES);
            $_SESSION['couleur2'] = $couleur2 = htmlentities("Rouge", ENT_QUOTES);
        }
        else
        {
            $_SESSION['couleur2'] = $couleur2 = htmlentities("Jaune", ENT_QUOTES);
            $_SESSION['couleur1'] = $couleur1 = htmlentities("Rouge", ENT_QUOTES);
        }
    }

    else
    {
        $couleur1 = $_SESSION['couleur1'];
        $couleur2 = $_SESSION['couleur2'];
    }

    if (isset($_SESSION['tableau']) && !empty($_SESSION['tableau'])) // On récupère le tableau
        $tableau = $_SESSION['tableau'];

    else 
    {
        initGame(); 
    }

    if(isset($_POST["case"]) && !empty($_POST["case"]))
     {
        $horizontal = $_POST["case"] - 1;
        $vertical = count($GLOBALS['tableau']) - 1;
        while($vertical >= 0 && $GLOBALS['tableau'][$vertical][$horizontal] == $GLOBALS['Jetonvide']) 
        {
            $vertical-=1;
        }
        
        if($vertical != count($GLOBALS['tableau'])-1) 
        {
            $GLOBALS['JoueurC'] = $GLOBALS['JoueurC'] == 1 ? 2 : 1;
            $_SESSION['tableau'][$vertical + 1][$horizontal] = $GLOBALS['JoueurC'] == 1 ? $GLOBALS['couleur1'] : $GLOBALS['couleur2'];
        }
    }

    $_SESSION['JoueurC']=$GLOBALS['JoueurC'];

    if(youWin() !== null)
    {
        $joueur=$_SESSION['JoueurC']==1 ? $_SESSION['Joueur2'] : $_SESSION['Joueur1'];
        echo "<center><strong>$joueur a gagné ! </strong></center><br><br>";
        
        if($_SESSION['JoueurC']==1)
        {
            $_SESSION['Vainqueur']=$_SESSION['Joueur2'];
            // pour la base de donnée on va stocker le vainqeur.
        }
        else
        {
            $_SESSION['Vainqueur']=$_SESSION['Joueur1'];
            // pour la base de donnée on va stocker le vainqeur.
        }

        $message=$_SESSION['JoueurC']==1 ? $_SESSION['Joueur2'] : $_SESSION['Joueur1'];
        echo "<script>
            Swal.fire({
              icon: 'success',
              title: '$message a gagné !!!',
              showConfirmButton: false,
              timer: 1500
            });
          </script>";

        $link = mysqli_connect('localhost', 'root', 'root','DonneePuissance4');
        // root, root car j'utilise mamp .

        $req = "INSERT INTO partie (`Joueur1`, `Joueur2`, `Gagnant`) 
                VALUES ('{$_SESSION["Joueur1"]}', '{$_SESSION["Joueur2"]}', 
                    '{$_SESSION["Vainqueur"]}')";

        $res = mysqli_query($link, $req); 
        mysqli_close($link); 
        
    }  
    else
    {
        // on rejoue car personne n'a Win le jeu 
        Rejouer();
    }

?>



