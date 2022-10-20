<?php

include "./vues/element/v_sommaire.php";

switch($_GET["action"])
{
    case 'listRemboursement' : {
        $lesFraisForfaits = $pdo->getFraisForfait();
        include "./vues/utilisateur/v_remboursement.php";
        break;
    }
}
?>