<?php
// notre fichier qui va contenir les fonctions que l'on utilise
    function saisie()
    {
        if(isset($_SESSION['Joueur1']) && isset($_SESSION['Joueur2'])) 
        // pour remettre le nom des joueurs
        {
            echo '<input type="text" name="Joueur1" id="Joueur1" 
            value='.$_SESSION['Joueur1'].'>';
            echo '<input type="text" name="Joueur2" id="Joueur2" 
            value='.$_SESSION['Joueur2'].'>';
        }
        else
        {
            echo '<input type="text" name="Joueur1" id="Joueur1" placeholder="Joueur 1 par defaut" value="">';
            echo '<input type="text" name="Joueur2" id="Joueur2" placeholder="Joueur 2 par defaut" value="">';
        }
    }

    function Rejouer()
    {
        $nom = null;
        if ($GLOBALS['JoueurC'] == 1) 
        {
            $nom = $GLOBALS['nom1'];
        } 
        else 
        {
            $nom = $GLOBALS['nom2'];
        }

        echo "<center><label>C'est au tour de : </label><strong>$nom</strong><br><br></center>";

        echo "<center><form method='POST' action='jeu.php'>";
        for($i=count($_SESSION['tableau'])-1; $i>=0; $i--)
        {
            echo "<table>";
            for($j=0; $j<count($_SESSION['tableau'][0]); $j++)
            {
                $act=$_SESSION['tableau'][$i][$j];
                $jw=$j+1;
                echo "<button name='case' type='submit' ' value='$jw'></center><img src='img/$act.png'></center></button>";
            }
            echo '</table>';
        }
        echo '</form></center>';
    }


    function initGame() 
    {
        $rangees = isset($_POST['largeur']) ? intval($_POST['largeur']) : 7;
        $colonnes = isset($_POST['hauteur']) ? intval($_POST['hauteur']) : 6;

        if ($rangees < 4 || $colonnes < 4) {
            $rangees = 7;
            $colonnes = 6;
        }

        $GLOBALS['tableau'] = array();
        for ($i = 0; $i < $colonnes; $i++) 
        {
            for ($j = 0; $j < $rangees; $j++) 
            {
                $GLOBALS['tableau'][$i][$j] = $GLOBALS['Jetonvide'];
            }
        }

        $_SESSION['tableau'] = $GLOBALS['tableau'];
    }


    function youWin()
    {
        $vainqueur = null;// pas de vainqueur
        $ligne = count($_SESSION['tableau']);
        $colonne = count($_SESSION['tableau'][0]);
        
        // on test en horizontal
        for($i=0; $i<$ligne; $i++)
        {
            for($j=0; $j<$colonne-3; $j++)
            {
                $Lejeton = $_SESSION['tableau'][$i][$j];
                if($Lejeton != $GLOBALS['Jetonvide'] && 
                   $Lejeton == $_SESSION['tableau'][$i][$j+1] && 
                   $Lejeton == $_SESSION['tableau'][$i][$j+2] && 
                   $Lejeton == $_SESSION['tableau'][$i][$j+3])
                {
                    $vainqueur = $Lejeton;
                    break 2;
                }
            }
        }
        
        // on test en vertical
        if(!$vainqueur)
        {
            for($i=0; $i<$ligne-3; $i++)
            {
                for($j=0; $j<$colonne; $j++)
                {
                    $Lejeton = $_SESSION['tableau'][$i][$j];
                    if($Lejeton != $GLOBALS['Jetonvide'] && 
                       $Lejeton == $_SESSION['tableau'][$i+1][$j] && 
                       $Lejeton == $_SESSION['tableau'][$i+2][$j] && 
                       $Lejeton == $_SESSION['tableau'][$i+3][$j])
                    {
                        $vainqueur = $Lejeton;
                        break 2; 
                    }
                }
            }
        }
        
        // on test en diagonale vers la droite
        if(!$vainqueur)
        {
            for($i=0; $i<$ligne-3; $i++)
            {
                for($j=0; $j<$colonne-3; $j++)
                {
                    $Lejeton = $_SESSION['tableau'][$i][$j];
                    if($Lejeton != $GLOBALS['Jetonvide'] && 
                       $Lejeton == $_SESSION['tableau'][$i+1][$j+1] && 
                       $Lejeton == $_SESSION['tableau'][$i+2][$j+2] && 
                       $Lejeton == $_SESSION['tableau'][$i+3][$j+3])
                    {
                        $vainqueur = $Lejeton;
                        break 2;
                    }
                }
            }
        }
        
        // on test l'autre diagonale vers la gauche
        if(!$vainqueur)
        {
            for($i=3; $i<$ligne; $i++)
            {
                for($j=0; $j<$colonne-3; $j++)
                {
                    $Lejeton = $_SESSION['tableau'][$i][$j];
                    if($Lejeton != $GLOBALS['Jetonvide'] && 
                       $Lejeton == $_SESSION['tableau'][$i-1][$j+1] && 
                       $Lejeton == $_SESSION['tableau'][$i-2][$j+2] && 
                       $Lejeton == $_SESSION['tableau'][$i-3][$j+3])
                    {
                        $vainqueur = $Lejeton;
                        break 2;
                    }
                }
            }
        }  
        return $vainqueur;
    }




?>