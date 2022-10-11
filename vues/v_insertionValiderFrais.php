<?php
include "./vues/v_sommaire.php";
?>
<div id="contenu">
    <h2>Validation des fiches de frais</h2>
    <form action="index.php?uc=validerFrais&action=gestionUtilisateur" method="post">
        <fieldset class="corpsForm">
            <legend>Visiteur et mois à séléctionner</legend>
            <div>
                <div>
                    <label for="select-visiteur">Visiteur :</label>
                    <select name="user" id="select-visiteur">
                        <?php
                            foreach ($LesUtilisateurs as $user) {
                                echo '<option value="'.$user["id"]. '" ' . userSelected($user["id"]) . '>' . $user["nom"] . ' ' . $user["prenom"] . ' </option>';
                            }
                        ?>
                    </select>
                </div>
                <div>
                    <label for="select-date">Mois :</label>
                    <select name="date" id="select-date">
                        <?php
                            $dateTime = new DateTime();
                            for ($i = 1; $i <= 6; $i++) {
                                echo '<option value="' . $dateTime->format('Ym') . '" ' . dateSelected($dateTime->format('Ym')) . '>' . Translate::getMonth($dateTime->format('F')) . " " . $dateTime->format("Y") . '</option>';
                                $dateTime->modify('-1 month');
                            }
                        ?>
                    </select>
                </div>
            </div>
            <input type="submit">
        </fieldset>
    </form>
    