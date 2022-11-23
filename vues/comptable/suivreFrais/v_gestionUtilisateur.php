<?php
include "v_insertionSuivreFrais.php";
?>

<fieldset>
    <legend>Fiche de frais du mois <?= substr_replace($userFicheFrais["dateModif"], "-", 4, 0) ?></legend>
    <form action="index.php?uc=suivreFrais&action=rembourserFicheFrais" method="post">
        <p>Etat : <?= $userFicheFrais["libelle"] ?> depuis le <?= $userFicheFrais["dateModif"] ?></p>
        <p>Montant validé : <?= $userFicheFrais["montantValide"] ?></p>

        <?php require "./vues/component/userFraisForfait.php"; ?>
        <?php require "./vues/component/userFraisHorsForfait.php"; ?>
        <input type="submit" value="Valider le remboursement">
    </form>
</fieldset>