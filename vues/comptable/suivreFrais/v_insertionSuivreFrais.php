<div id="contenu">
    <h2>Validation des fiches de frais</h2>
    <form action="index.php?uc=suivreFrais&action=gestionUtilisateur" method="post">
        <fieldset class="corpsForm">
            <legend>Visiteur et mois à séléctionner</legend>
            <div>
                <div>
                    <label for="select-visiteur">Visiteur :</label>
                    <select name="user" id="select-visiteur">
                        <?php
                            foreach ($lesUtilisateursValider as $user) {
                                echo '<option value="' . $user["idVisiteur"] . '|' . $user["mois"] . '|' . $user["dateModif"] . '"> ' . dateAnglaisVersFrancais($user["dateModif"]) . '  ' . $user["nom"] . ' ' . $user["prenom"] . ' </option>';
                            }
                        ?>
                    </select>
                </div>
            </div>
            <input type="submit">
        </fieldset>
    </form>
    