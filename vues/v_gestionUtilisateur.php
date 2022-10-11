<?php
include "vues/v_InsertionValiderFrais.php";
?>
<fieldset class="corpsForm">
        <?php
        if(is_array($userFicheFrais))
        {
                include "v_ValiderFraisUser.php";
        }
        else
        {
                echo "Pas de fiche de frais";
        }
        ?>
</fieldset>