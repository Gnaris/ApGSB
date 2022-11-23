<?php
include "./vues/element/v_sommaire.php";
$LesUtilisateurs = $pdo->getAllUtilisateur();
switch($_REQUEST["action"])
{
    case "saisirUtilisateur" :
    {  
        $_SESSION["userValiderFrais"] = "";
        $_SESSION["dateValiderFrais"] = "";
        include "vues/comptable/validerFrais/v_insertionValiderFrais.php";
        break;
    }

    case "gestionUtilisateur" :
    {
        $input = true;
        if(isset($_POST["user"]) && isset($_POST["date"]))
        {
            $_SESSION["userValiderFrais"] = $_POST["user"];
            $_SESSION["dateValiderFrais"] = $_POST["date"];
        }
        if(isset($_SESSION["userValiderFrais"]) && isset($_SESSION["dateValiderFrais"]))
        {
            $_POST["user"] = $_SESSION["userValiderFrais"];
            $_POST["date"] = $_SESSION["dateValiderFrais"];
        }
        $userFicheFrais = $pdo->getFicheFraisUtilisateur($_POST["user"], $_POST["date"]);
        $userFraisForfait = $pdo->getLesFraisForfait($_POST["user"], $_POST["date"]);
        $userFraisHorsForfait = $pdo->getLesFraisHorsForfait($_POST["user"], $_POST["date"]);
        include "vues/comptable/validerFrais/v_gestionUtilisateur.php";
        break;
    }

    case "validerLigneFraisForfait" :
    {
        foreach($_POST as $idFraisForfait => $quantite)
        {
             $pdo->setQuantiteLFF($quantite, $idFraisForfait);
        }
        header("Location: index.php?uc=validerFrais&action=gestionUtilisateur");
        break;
    }
    case "supprimerFraisHorsForfait" : {
        $pdo->deleteFraisHorsForfaitComptable($_GET["id"]);
        header("Location: index.php?uc=validerFrais&action=gestionUtilisateur");
        break;
    }
    case "reporterFraisHorsForfait" : {
        $pdo->reportFraisHorsForfait($_GET["id"], $_GET["mois"]);
        header("Location: index.php?uc=validerFrais&action=gestionUtilisateur");
        break;
    }
    case "validerFraisHorsForfait" : 
    {
        $pdo->validerFicheFrais($_SESSION["userValiderFrais"], $_SESSION["dateValiderFrais"], $_POST["justificatif"]);
        header("Location: index.php?uc=validerFrais&action=gestionUtilisateur");
        echo "Valider";
    }
}
?>
