<legend>Fiche de frais du mois <?= substr_replace($_POST["date"], "-", 4, 0) ?></legend>
<p>Etat : <?= $userFicheFrais["libelle"] ?> depuis le <?= $userFicheFrais["dateModif"] ?></p>
<p>Montant validé : <?= $userFicheFrais["montantValide"] ?></p>

<form action="index.php?uc=validerFrais&action=validerLigneFraisForfait" method="post">
    <?php require "./vues/component/userFraisForfait.php"; ?>
    <input type="submit" value="Valider">
</form>

<form action="index.php?uc=validerFrais&action=validerFraisHorsForfait" method="post">
    <?php require "./vues/component/userFraisHorsForfait.php"; ?>
    <input type="submit" value="Valider la fiche">
</form>


</div>