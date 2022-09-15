    <!-- Division pour le sommaire -->
    <div id="menuGauche">
       <div id="infosUtil">
       </div>
       <ul id="menuList">
          <li>
             <?= $_SESSION["role"] === "C" ? "Comptable" : "Visiteur" ?><br>
             <?= $_SESSION['prenom'] . "  " . $_SESSION['nom']  ?>
          </li>
          <?php
            echo $_SESSION["role"] === "C" ?
               '
            <li class="smenu">
              <a href="index.php?uc=validerFrais&action=saisirFrais">Valider fiche de frais</a>
           </li>
           <li class="smenu">
              <a href="index.php?uc=etatFrais&action=selectionnerMois">Suivre paiement fiche de frais</a>
           </li>
            '
               :
               '
            <li class="smenu">
              <a href="index.php?uc=gererFrais&action=saisirFrais">Saisie fiche de frais</a>
           </li>
           <li class="smenu">
              <a href="index.php?uc=etatFrais&action=selectionnerMois">Mes fiches de frais</a>
           </li>
            ';
            ?>

          <li class="smenu">
             <a href="index.php?uc=connexion&action=deconnexion" title="Se déconnecter">Déconnexion</a>
          </li>
       </ul>

    </div>