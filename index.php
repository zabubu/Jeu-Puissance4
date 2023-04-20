<?php
    session_start();
    session_destroy();// on fait cela pour que les utilisateurs puissent revenir sur la page et rejouer a nouveau
    session_start();
    include "function.php";
    include 'index.css';
?>
<title>Puissance 4</title>
<center><div id="title">Jeu puissance 4</div></center>
<form method="POST" action="jeu.php">
    <label>
        <span> Entrez le nom du premier puis du second joueurs : </span>
    </label>
    <?php saisie(); ?>
    <br><br>
    <label>
        <span style="background-color: white;">Le joueur 1 choisit sa couleur : </span>
    </label>

    <input type="radio" name="couleur1" id="couleur1" value="Jaune" checked=true> 

    <label>
        <span style="background-color: white;">Jaune</span>
    </label>
    <input type="radio" name="couleur1" id="couleur1" value="Rouge">
    <label>
        <span style="background-color: white;">Rouge</span>
    </label>
    <br>

    <label>
        <span style="background-color: white;">Choisir la couleur de fond d'écran du jeu :
        </span>
    </label>
    <input type="color" name="bg_color" id="bg_color" value="#005fa3"><br><br>

    <label>
        <span style="background-color: white;">Choisir la hauteur et largeur du jeu:</span></label>
    <input type="number" name="hauteur" id="hauteur" placeholder="6 par defaut" value="">
    <input type="number" name="largeur" id="largeur" placeholder="7 par defaut" value="">
    <br><br>
    <button name="start" type="submit"> Jouer </button>
</form>
<div id="regles"><!-- C'est mieux si on indique les regles ! -->
    <h2>Règles du jeu :</h2>
    <ul>
        <li>Le jeu se joue à deux joueurs.</li>
        <li>le premier joueur choisit une couleur : Jaune ou Rouge.</li>
        <li>Les joueurs placent tour à tour un pion de leur couleur dans une colonne de leur choix.</li>
        <li>Le premier joueur à aligner 4 pions de sa couleur horizontalement, verticalement ou en diagonale remporte la partie.</li>
        <li>Bon Jeu !</li>
    </ul>
</div>
<br><br>
</body>