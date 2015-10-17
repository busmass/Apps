<?php


//Database=as_eb778c54b5aa1fa;Data Source=us-cdbr-azure-central-a.cloudapp.net;User Id=b0a941f833069a;Password=41561c96


function coBdd(){
	$dbName= "as_eb778c54b5aa1fa";
	$userName = "b0a941f833069a";
	$passName = "41561c96";  
	$hostname = "us-cdbr-azure-central-a.cloudapp.net" ;
	try{
		//echo "<script>alert('Avant essai de connexion')</script>";
		$bdd = new PDO('mysql:host='.$hostname.';
		dbname='.$dbName.';', $userName, $passName);
		$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		return $bdd;

	}
	catch (Exception $e){
		//echo "<script>alert('Erreur de connexion')</script>";
		die('Erreur : '. $e->getMessage());
	}
}

function recupData($ligne, $path, $bdd){
	$stack=array();
	$requete = $bdd->query('SELECT * FROM bus WHERE id_ligne='.$ligne.' AND path='.$path.'');
	while ($donnees = $requete->fetch()){
		echo 'Bus num. : '.$donnees['id'].' Poids : '.$donnees['poids'].' <br>';
		viewArret($bdd,$donnees['id']);
	}
	
	
}

function viewChoiceLine($bdd){
	echo 'Choose your line :';
	$requete = $bdd->query('SELECT * FROM Ligne ');
	$stack = array( );




	while ($donnees = $requete->fetch()){
		array_push($stack, $donnees['num_ligne'].' '.$donnees['Chemin']);

	}

	// Définition du tableau de couleurs
/*
	$arrayCouleurs = array(

	'#ff9900' => 'orange',
	'#00ff00' => 'vert',
	'#ff0000' => 'rouge',
	'#ff00ff' => 'violet',
	'#0000ff' => 'bleu',
	'#000000' => 'noir',
	'#ffffff' => 'blanc',
	'#ffff00' => 'jaune'
	);
*/
	echo '<form method="post" action="emakina.php">';

	// Variable qui ajoutera l'attribut selected de la liste déroulante
	$selected = '';

	// Parcours du tableau
	echo '<select name="line" action="emakina.php">',"n";
	foreach($stack as $valeurHexadecimale => $lignePath)
	{

	// Affichage de la ligne
	echo "\t",'<option value="', $lignePath ,'"', $selected ,'>', $ligne ,'</option>',"\n";
	// Remise à zéro de $selected
	$selected='';
	}
	echo '</select>',"\n";
	echo '
            <input type="submit" value="Submit"/>
        </form> ';
}

function viewChoiceLine2($bdd){
	echo 'Choose your line :';
	$requete = $bdd->query('SELECT * FROM Ligne ');
	$stack = array();

	echo '<form method="post" action="emakina.php">';
	echo '<select name="line" action="emakina.php">',"n";
	while ($donnees = $requete->fetch()){
		  echo '<option value="'.$donnees['idLigne'].'">'.$donnees['num_ligne'].'</option>',"\n";
		//echo '<option value="'.$donnees['idLigne'].'>'.$donnees['idLigne'].' |  '.$donnees['depart'].' - '.$donnees['terminus'].'</option>',"\n";
		//echo '<option value="'.$donnees['idLigne'].'x">'.$donnees['idLigne'].' |  '.$donnees['terminus'].' - '.$donnees['depart'].'</option>',"\n";
	}
	echo '</select>';
	echo '
            <input type="submit" value="Submit"/>
        </form> ';
}

function viewChoicePath($bdd, $line){
	echo 'Choose your path :';
	$requete = $bdd->query('SELECT * FROM Ligne WHERE idLigne = '.$line.' ');
	$stack = array();

	echo '<form method="post" action="emakina.php?line='.$line.'">';
	echo '<select name="path" action="emakina.php?line='.$line.'">',"n";
	while ($donnees = $requete->fetch()){
		  echo '<option value=0>'.$donnees['depart'].' - '.$donnees['terminus'].'</option>',"\n";
		  echo '<option value=1>'.$donnees['terminus'].' - '.$donnees['depart'].'</option>',"\n";
	}
	echo '</select>';
	echo '
            <input type="submit" value="Submit"/>
        </form> ';
}

function viewConection(){
	echo" <form method='post' action='emakina.php'>
		  <label for='pseudo'>Pseudo* : </label>"; 
	echo "<label for='pass'>Mot de passe* : </label>
		  <input type='password' name='pass' id='pass' placeholder='&#9679;&#9679;&#9679;&#9679;&#9679;'' size='30' maxlength='15' required />
		  <br/>	";	
	echo "input type='submit' value='Login'/>
		 </form>";		
}

function conection($bdd,$pseudo, $pass){
	$requete = $bdd->query('SELECT * FROM Users WHERE pseudo = '.$pseudo.' ');
	if ($pass==$requete['pass']) {
		return true;
	}
	else{
		return false;
	}
}

function signUp($bdd,$pseudo, $pass){
	$requete = $bdd->query('SELECT * FROM Users ');
	while ($donnees = $requete->fetch()){
		if ($donnees['pseudo']==$pseudo) {
			return false;
		}
	}
	$pass=md5($pass);
	$requete=$bdd->prepare('INSERT INTO Users SET pseudo=?, pass=? ');
	$requete->execute(array($pseudo,$pass));
	return true;
	
}

function viewArret($bdd,$busId){
	$requete = $bdd->query('SELECT arret FROM bus WHERE id='.$busId.' ');
	$donnee = $requete->fetch();
	$arret=$donnee['arret'];
	echo 'Le bus est entre larret '.$arret.' et larret '.((int)$arret + 1).' <br>';
}

?>