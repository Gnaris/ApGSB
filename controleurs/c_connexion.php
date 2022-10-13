<?php
if(!isset($_REQUEST['action']))
{
	$_REQUEST['action'] = 'notConnected';
}

switch($_REQUEST['action']){
	case 'notConnected':{
		include("vues/auth/v_connexion.php");
		break;
	}
	case 'valideConnexion':{
		$login = $_REQUEST['login'];
		$mdp = $_REQUEST['mdp'];
		$visiteur = $pdo->getInfoUtilisateur($login,$mdp);
		if(!is_array($visiteur)){
			ajouterErreur("Login ou mot de passe incorrect");
			include("vues/element/v_erreurs.php");
			include("vues/auth/v_connexion.php");
		}
		else{
			connecter($visiteur['id'],$visiteur['nom'],$visiteur['prenom'], $visiteur['role']);
			include("vues/element/v_sommaire.php");
		}
		break;
	}
	default :{
		include("vues/auth/v_connexion.php");
		break;
	}
}
?>