<div>
    <?= $input ? '<caption>Descriptif des éléments hors forfait - <input type="text" name="justificatif" value="' . $userFicheFrais["nbJustificatifs"] . '"> justificatifs reçu</caption>' : '<caption>Descriptif des éléments hors forfait - ' . $userFicheFrais["nbJustificatifs"] .' justificatifs reçu</caption>' ?>
</div>
<table class="listeLegere">
    <tbody>
        <tr>
            <th>Date</th>
            <th>Libellé</th>
            <th>Montant</th>
            <?= $input ? '<th colspan="2">Action</th>' : '' ?>
        </tr>
            <?php
            foreach ($userFraisHorsForfait as $fraisHorsForfait) {
                if($input)
                {
                    $statut = $fraisHorsForfait["statut"] === 0 ? "REFUSÉ : " : "";
                    echo '<tr><th>' . $fraisHorsForfait["date"] . '</th>';
                    echo '<th>' . $statut . " " . $fraisHorsForfait["libelle"] . '</th>';
                    echo '<th>' . $fraisHorsForfait["montant"] . '</th>';
                    echo '<th><button><a href="index.php?uc=validerFrais&action=supprimerFraisHorsForfait&id=' . $fraisHorsForfait["id"] . '">Supprimer</a></button></th>';
                    echo '<th><button><a href="index.php?uc=validerFrais&action=reporterFraisHorsForfait&id=' . $fraisHorsForfait["id"] . '&mois=' . $fraisHorsForfait["mois"] . '">Reporter</a></button></th></tr>';
                }
                else
                {
                    echo '<tr><th>' . $fraisHorsForfait["date"] . '</th>';
                    echo '<th>' . $fraisHorsForfait["libelle"] . '</th>';
                    echo '<th>' . $fraisHorsForfait["montant"] . '</th>';
                }
            }
            ?>
        </tr>
    </tbody>
</table>