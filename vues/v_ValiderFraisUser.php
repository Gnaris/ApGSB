<legend>Fiche de frais du mois <?= substr_replace($_SESSION["dateValiderFrais"], "-", 4, 0) ?></legend>
<p>Etat : <?= $userFicheFrais["libelle"] ?> depuis le <?= $userFicheFrais["dateModif"] ?></p>
<p>Montant validé : <?= $userFicheFrais["montantValide"] ?></p>
<form action="index.php?uc=validerFrais&action=validerLigneFraisForfait" method="post">
   <table class="listeLegere">
    <caption>Eléments forfaitisés</caption>
    <tbody>
        <tr>
            <?php
            foreach($userLigneFraisForfait as $ulff)
            {
                echo '<th>' . $ulff["libelle"] . '</th>';
            }
            ?>
        </tr>
        <tr>
            <?php
                foreach($userLigneFraisForfait as $ulff)
                {
                    echo '<th><input type="text" name="'. $ulff["id"] .'" value="' . $ulff["quantite"] . '"></th>';
                }
            ?>
        </tr>
    </tbody>
    </table> 
    <input type="submit" value="Valider">
</form>

<pre>
    <?php
    var_dump($userLigneFraisHorsForfait);
    ?>
</pre>


    <div>
        <caption>Descriptif des éléments hors forfait - <input type="text" value="<?= $userFicheFrais["nbJustificatifs"] ?>"> justificatifs reçu</caption>
    </div>
    <table class="listeLegere">
        <tbody>
            <tr>
                <th>Date</th>
                <th>Libellé</th>
                <th>Montant</th>
                <th colspan="2">Action</th>
            </tr>
            <tr>
                <?php
                foreach($userLigneFraisHorsForfait as $user)
                {
                    echo '<form method="post">';
                    echo '<input type="hidden" name="id" value="'. $user["id"] .'">';
                    echo '<th>'. $user["date"] . '</th>';
                    echo '<th>'. $user["libelle"] . '</th>';
                    echo '<th>'. $user["montant"] . '</th>';
                    echo '<th><input type="submit" value="Supprimer" formaction="index.php?uc=validerFrais&action=supprimerLigneFraisHorsForfait"></th>';
                    echo '<th><input type="submit" value="Reporter" formaction="index.php?uc=validerFrais&action=reporterLigneFraisHorsForfait"></th>';
                    echo '</form>';
                }
                ?>
            </tr>
        </tbody>
    </table>
</div>