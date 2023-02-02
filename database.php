<?php


function connectDB() {
	$bdd = null;
	try {
		$bdd = new PDO('mysql:host=localhost;dbname=mabanque;charset=utf8', 
			'bthouverez', 
			'321654'
		);	
	} catch(Exception $e) {
		die('Erreur connexion BDD : '.$e->getMessage());
	}

	return $bdd;
}

function connectUser($username, $password) {
	$bdd = connectDB();
	$sql = 'SELECT * FROM Users WHERE username = ?';
	$query = $bdd->prepare($sql);
	$query->execute(array($username));
	$data = $query->fetch();
	if($data) {
		if($data['password'] == $password) {
			$_SESSION['username'] = $data['username'];
			$_SESSION['id'] = $data['id'];
			return true;
		} else {
			return 'Mot de passe éronné';
		}
	} else {
		return 'Utilisateur inconnu';
	}
}

function getAccounts($id) {
	$bdd = connectDB();
	$sql = 'SELECT * FROM Accounts WHERE user_id = ?';
	$query = $bdd->prepare($sql);
	$query->execute(array($id));
	$data = $query->fetchAll();
	
	return $data;
}

function getAccount($id) {
	$bdd = connectDB();
	$sql = 'SELECT * FROM Accounts WHERE id = ?';
	$query = $bdd->prepare($sql);
	$query->execute(array($id));
	$data = $query->fetch();
	
	return $data;
}

function addToAccount($id, $amount) {
	$bdd = connectDB();
	$sql = 'SELECT * FROM Accounts WHERE id = ?';
	$query = $bdd->prepare($sql);
	$query->execute(array($id));
	$data = $query->fetch();
	$money = $data['money'] + $amount;
	$sql = 'UPDATE Accounts SET money = ? WHERE id = ?';
	$query = $bdd->prepare($sql);
	$query->execute(array($money, $id));
}

function subToAccount($id, $amount) {
	$bdd = connectDB();
	$sql = 'SELECT * FROM Accounts WHERE id = ?';
	$query = $bdd->prepare($sql);
	$query->execute(array($id));
	$data = $query->fetch();
	$money = $data['money'] - $amount;
	$sql = 'UPDATE Accounts SET money = ? WHERE id = ?';
	$query = $bdd->prepare($sql);
	$query->execute(array($money, $id));
}

