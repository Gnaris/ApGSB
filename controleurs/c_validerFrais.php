<?php
include "./vues/v_sommaire.php";
?>
<div id="contenu">
    <h2>Validation des fiches de frais</h2>
    <form action="">
        <fieldset class="corpsForm">
            <legend>Visiteur et mois à séléctionner</legend>
            <div>
                <div>
                    <label for="select-visiteur">Visiteur :</label>
                    <select name="visiteur" id="select-visiteur">
                        <?php
                        foreach ($pdo->getAllUtilisateur() as $user) {
                            echo '<option value="' . $user["id"] . '">' . $user["prenom"] . ' ' . $user["nom"] . '</option>';
                        }
                        ?>
                    </select>
                </div>
                <div>
                    <label for="select-date">Mois :</label>
                    <select name="visiteur" id="select-date">
                        <?php
                            
                        ?>
                    </select>
                </div>
            </div>
        </fieldset>
    </form>
</div>