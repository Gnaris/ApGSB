<h1>Montant des remboursements forfaitaires</h1>

<table>
        <tr>
            <th></th>
            <th>montant remboursé</th>
        </tr>
        <?php
        foreach($lesFraisForfaits as $fraisForfait)
        {
            echo '<tr><th>' . $fraisForfait["libelle"] . '</th><th>' . $fraisForfait["montant"] . '</th></tr>';
        }
        ?>
</table>