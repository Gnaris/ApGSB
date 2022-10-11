<?php
$LesUtilisateurs = $pdo->getAllUtilisateur();
switch($_REQUEST["action"])
{
    case "saisirUtilisateur" :
    {  
        $_SESSION["userValiderFrais"] = "";
        $_SESSION["dateValiderFrais"] = "";
        include "vues/v_insertionValiderFrais.php";
        break;
    }
    case "gestionUtilisateur" :
    {
        saveUserValiderFrais();
        $userFicheFrais = $pdo->getFicheFraisUtilisateur();
        $userLigneFraisForfait = $pdo->getLigneFraisForfaitUtilisateur();
        $userLigneFraisHorsForfait = $pdo->getLigneFraisHorsForfait();
        include "vues/v_gestionUtilisateur.php";
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
    case "supprimerLigneFraisHorsForfait" : {
        header("Location: index.php?uc=validerFrais&action=gestionUtilisateur");
        break;
    }
    case "reporterLigneFraisHorsForfait" : {
        header("Location: index.php?uc=validerFrais&action=gestionUtilisateur");
        break;
    }
    case "validerLigneFraisHorsForfait" : 
    {
        header("Location: index.php?uc=validerFrais&action=gestionUtilisateur");
        echo "Valider";
    }
}
?>
