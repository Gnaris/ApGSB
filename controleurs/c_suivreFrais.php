<?php
include "./vues/element/v_sommaire.php";
$lesUtilisateursValider = $pdo->getUtilisateurValider();
switch($_REQUEST["action"])
{
    case "saisirUtilisateur" : 
    {
        include "vues/comptable/suivreFrais/v_insertionSuivreFrais.php";
        break;
    }

    case "gestionUtilisateur" :
    {
        $input = false;
        $_SESSION["userSuivreFrais"] = explode("|", $_POST["user"])[0];
        $_SESSION["moisSuivreFrais"] = explode("|", $_POST["user"])[1];
        $_SESSION["dateSuivreFrais"] = explode("|", $_POST["user"])[2];
        $userFicheFrais = $pdo->getFicheFraisUtilisateur($_SESSION["userSuivreFrais"], $_SESSION["moisSuivreFrais"]);
        $userFraisForfait = $pdo->getLesFraisForfait($_SESSION["userSuivreFrais"], $_SESSION["moisSuivreFrais"]);
        $userFraisHorsForfait = $pdo->getLesFraisHorsForfait($_SESSION["userSuivreFrais"], $_SESSION["moisSuivreFrais"]);
        include "vues/comptable/suivreFrais/v_gestionUtilisateur.php";
        break;
    }

    case "rembourserFicheFrais" :
    {
        $pdo->validerRemboursementFicheFrais($_SESSION["userSuivreFrais"], $_SESSION["moisSuivreFrais"], $_SESSION["dateSuivreFrais"]);
        header("Location: index.php?uc=suivreFrais&action=saisirUtilisateur");
        break;
    }
}


?>