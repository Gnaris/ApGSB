<table class="listeLegere">
    <caption>Eléments forfaitisés</caption>
    <tbody>
        <tr>
            <?php
                foreach($userFraisForfait as $ulff)
                {
                     echo '<th>' . $ulff["libelle"] . '</th>';
                }
            ?>
        </tr>
        <tr>
            <?php
                foreach($userFraisForfait as $ulff)
                {
                    echo '<th><input type="text" name="'. $ulff["idfrais"] .'" value="' . $ulff["quantite"] . '"></th>';
                }
            ?>
        </tr>
    </tbody>
</table>