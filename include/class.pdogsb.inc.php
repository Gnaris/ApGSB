<?php

class PdoGsb{   		
      	private static $serveur='mysql:host=localhost';
      	private static $bdd='dbname=appliFraisGSB';   		
      	private static $user='root' ;    		
      	private static $mdp='' ;	
		private static $monPdo;
		private static $monPdoGsb=null;
			
	private function __construct(){
    	PdoGsb::$monPdo = new PDO(PdoGsb::$serveur.';'.PdoGsb::$bdd, PdoGsb::$user, PdoGsb::$mdp); 
		PdoGsb::$monPdo->query("SET CHARACTER SET utf8");
	}
	public function _destruct(){
		PdoGsb::$monPdo = null;
	}

	public  static function getPdoGsb(){
		if(PdoGsb::$monPdoGsb==null){
			PdoGsb::$monPdoGsb= new PdoGsb();
		}

		return PdoGsb::$monPdoGsb;  
	}

	public function getInfoUtilisateur($login, $mdp){
		$req = "SELECT utilisateur.id AS id, 
		utilisateur.nom AS nom, 
		utilisateur.prenom AS prenom, 
		utilisateur.role AS role 
		FROM utilisateur
		WHERE utilisateur.login='$login' AND utilisateur.mdp=md5('$mdp')";

		return PdoGsb::$monPdo->query($req)->fetch();
	}

	public function getLesFraisHorsForfait($idVisiteur,$mois){
	    $req = "SELECT * FROM lignefraishorsforfait 
		WHERE lignefraishorsforfait.idvisiteur ='$idVisiteur' 
		AND lignefraishorsforfait.mois = '$mois' ";	
		$lesLignes = PdoGsb::$monPdo->query($req)->fetchAll();
		$nbLignes = count($lesLignes);
		for ($i=0; $i<$nbLignes; $i++){
			$date = $lesLignes[$i]['date'];
			$lesLignes[$i]['date'] =  dateAnglaisVersFrancais($date);
		}

		return $lesLignes; 
	}

	public function getNbjustificatifs($idVisiteur, $mois){
		$req = "SELECT fichefrais.nbjustificatifs AS nb 
		FROM fichefrais 
		WHERE fichefrais.idvisiteur ='$idVisiteur' 
		AND fichefrais.mois = '$mois'";

		return PdoGsb::$monPdo->query($req)->fetch()['nb'];
	}

	public function getLesFraisForfait($idVisiteur, $mois){
		$req = "SELECT fraisforfait.id AS idfrais, 
		fraisforfait.libelle AS libelle, 
		lignefraisforfait.quantite AS quantite 
		FROM lignefraisforfait INNER JOIN fraisforfait 
		ON fraisforfait.id = lignefraisforfait.idfraisforfait
		WHERE lignefraisforfait.idvisiteur ='$idVisiteur' AND lignefraisforfait.mois='$mois' 
		ORDER BY lignefraisforfait.idfraisforfait";	

		return PdoGsb::$monPdo->query($req)->fetchAll();
	}

	public function getLesIdFrais(){
		$req = "SELECT fraisforfait.id AS idfrais 
		FROM fraisforfait ORDER BY fraisforfait.id";

		return PdoGsb::$monPdo->query($req)->fetchAll();
	}

	public function majFraisForfait($idVisiteur, $mois, $lesFrais){
		$lesCles = array_keys($lesFrais);
		foreach($lesCles as $unIdFrais){
			$qte = $lesFrais[$unIdFrais];
			$req = "update lignefraisforfait set lignefraisforfait.quantite = $qte
			where lignefraisforfait.idvisiteur = '$idVisiteur' and lignefraisforfait.mois = '$mois'
			and lignefraisforfait.idfraisforfait = '$unIdFrais'";
			PdoGsb::$monPdo->exec($req);
		}
	}

	public function majNbJustificatifs($idVisiteur, $mois, $nbJustificatifs){
		$req = "update fichefrais set nbjustificatifs = $nbJustificatifs 
		where fichefrais.idvisiteur = '$idVisiteur' and fichefrais.mois = '$mois'";
		PdoGsb::$monPdo->exec($req);	
	}

	public function estPremierFraisMois($idVisiteur,$mois)
	{
		$ok = false;
		$req = "select count(*) as nblignesfrais from fichefrais 
		where fichefrais.mois = '$mois' and fichefrais.idvisiteur = '$idVisiteur'";
		$res = PdoGsb::$monPdo->query($req);
		$laLigne = $res->fetch();
		if($laLigne['nblignesfrais'] == 0){
			$ok = true;
		}
		return $ok;
	}

	public function dernierMoisSaisi($idVisiteur){
		$req = "select max(mois) as dernierMois from fichefrais where fichefrais.idvisiteur = '$idVisiteur'";
		$res = PdoGsb::$monPdo->query($req);
		$laLigne = $res->fetch();
		$dernierMois = $laLigne['dernierMois'];
		return $dernierMois;
	}
	
	public function creeNouvellesLignesFrais($idVisiteur,$mois){
		$dernierMois = $this->dernierMoisSaisi($idVisiteur);
		$laDerniereFiche = $this->getLesInfosFicheFrais($idVisiteur,$dernierMois);
		if($laDerniereFiche['idEtat']=='CR'){
				$this->majEtatFicheFrais($idVisiteur, $dernierMois,'CL');
				
		}
		$req = "insert into fichefrais(idvisiteur,mois,nbJustificatifs,montantValide,dateModif,idEtat) 
		values('$idVisiteur','$mois',0,0,now(),'CR')";
		PdoGsb::$monPdo->exec($req);
		$lesIdFrais = $this->getLesIdFrais();
		foreach($lesIdFrais as $uneLigneIdFrais){
			$unIdFrais = $uneLigneIdFrais['idfrais'];
			$req = "insert into lignefraisforfait(idvisiteur,mois,idFraisForfait,quantite) 
			values('$idVisiteur','$mois','$unIdFrais',0)";
			PdoGsb::$monPdo->exec($req);
		 }
	}

	public function creeNouveauFraisHorsForfait($idVisiteur,$mois,$libelle,$date,$montant){
		$dateFr = dateFrancaisVersAnglais($date);
		$req = "insert into lignefraishorsforfait 
		values('','$idVisiteur','$mois','$libelle','$dateFr','$montant')";
		PdoGsb::$monPdo->exec($req);
	}

	public function supprimerFraisHorsForfait($idFrais){
		$req = "delete from lignefraishorsforfait where lignefraishorsforfait.id =$idFrais ";
		PdoGsb::$monPdo->exec($req);
	}

	public function getLesMoisDisponibles($idVisiteur){
		$req = "select fichefrais.mois as mois from  fichefrais where fichefrais.idvisiteur ='$idVisiteur' 
		order by fichefrais.mois desc ";
		$res = PdoGsb::$monPdo->query($req);
		$lesMois =array();
		$laLigne = $res->fetch();
		while($laLigne != null)	{
			$mois = $laLigne['mois'];
			$numAnnee =substr( $mois,0,4);
			$numMois =substr( $mois,4,2);
			$lesMois["$mois"]=array(
		     "mois"=>"$mois",
		    "numAnnee"  => "$numAnnee",
			"numMois"  => "$numMois"
             );
			$laLigne = $res->fetch(); 		
		}
		return $lesMois;
	}

	public function getLesInfosFicheFrais($idVisiteur,$mois){
		$req = "select ficheFrais.idEtat as idEtat, ficheFrais.dateModif as dateModif, ficheFrais.nbJustificatifs as nbJustificatifs, 
			ficheFrais.montantValide as montantValide, etat.libelle as libEtat from  fichefrais inner join Etat on ficheFrais.idEtat = Etat.id 
			where fichefrais.idvisiteur ='$idVisiteur' and fichefrais.mois = '$mois'";
		$res = PdoGsb::$monPdo->query($req);
		$laLigne = $res->fetch();
		return $laLigne;
	}
 
	public function majEtatFicheFrais($idVisiteur,$mois,$etat){
		$req = "update ficheFrais set idEtat = '$etat', dateModif = now() 
		where fichefrais.idvisiteur ='$idVisiteur' and fichefrais.mois = '$mois'";
		PdoGsb::$monPdo->exec($req);
	}

	// ===============================================================================================

	public function getAllUtilisateur()
    {
        $request = "SELECT id, nom, prenom FROM utilisateur ORDER BY nom ASC";
        return PdoGsb::$monPdo->query($request)->fetchAll();
    }

	public function getFicheFraisUtilisateur()
	{
		$request = 'SELECT f.idVisiteur, f.mois, f.nbJustificatifs, f.montantValide, f.dateModif, e.libelle
		FROM fichefrais AS f 
		INNER JOIN etat AS e ON f.idEtat = e.id
		WHERE f.idVisiteur="' . $_SESSION["userValiderFrais"] . '" AND f.mois="' . $_SESSION["dateValiderFrais"] . '";';
		
		return PdoGsb::$monPdo->query($request)->fetch();
	}

	public function getLigneFraisForfaitUtilisateur()
	{
		$request = 'SELECT lff.quantite, ff.libelle, ff.id FROM lignefraisforfait AS lff
		INNER JOIN fraisforfait AS ff ON ff.id = lff.idFraisForfait
		WHERE lff.idVisiteur="' . $_SESSION["userValiderFrais"] . '" AND lff.mois="' . $_SESSION["dateValiderFrais"] . '";';

		return PdoGsb::$monPdo->query($request)->fetchAll();
	}

	public function setQuantiteLFF($quantite, $idFraisForfait)
	{
		$request = 'UPDATE lignefraisforfait 
		SET quantite = '. (int)$quantite . ' 
		WHERE idFraisForfait = "' . $idFraisForfait . '" AND idVisiteur = "' . $_SESSION["userValiderFrais"] . '";';
		PdoGsb::$monPdo->query($request);
	}

	public function getLigneFraisHorsForfait()
	{
		$request = 'SELECT id, libelle, date, montant FROM lignefraishorsforfait 
		WHERE idVisiteur = "' . $_SESSION["userValiderFrais"] . '" AND mois = "' . $_SESSION["dateValiderFrais"] . '";';
		return PdoGsb::$monPdo->query($request)->fetchAll();
	}
}
?>