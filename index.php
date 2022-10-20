<?php
session_start();
spl_autoload_register(function ($class_name) {
    include 'entity/' . $class_name . '.php';
});
require_once("include/fct.inc.php");
require_once("include/class.pdogsb.inc.php");
require "./vues/element/v_entete.php";                                                                                                                                                               	
		
$pdo = PdoGsb::getPdoGsb();

if (!isset($_REQUEST['uc']) || !estConnecte()) {
	$_REQUEST['uc'] = 'connexion';
}

switch ($_REQUEST['uc']) {
	case 'connexion': {
			include("controleurs/c_connexion.php");
			break;
		}
	case 'saisieFrais': {
			include("controleurs/c_saisieFrais.php");
			break;
		}
	case 'etatFrais': {
			include("controleurs/c_etatFrais.php");
			break;
		}
	case 'remboursementForfaitaires' : {
			include ("controleurs/c_remboursement.php");
			break;
	}
	case 'validerFrais' : {
		if($_SESSION["role"] === "C")
		{
			include("controleurs/c_validerFrais.php");
		}
		else
		{
			include("controleurs/c_connexion.php");
		}
		break;
	}
}
		?>

</body>
</html>