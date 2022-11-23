<?php
include "vues/comptable/validerFrais/v_InsertionValiderFrais.php";
?>
<fieldset class="corpsForm">
        <?php
        if(is_array($userFicheFrais))
        {
                include "v_validerFraisUser.php";
        }
        else
        {
                echo "Pas de fiche de frais";
        }
        ?>
</fieldset>