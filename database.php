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
	$sql = 'SELECT * FROM accounts WHERE id = ?';
	$query = $bdd->prepare($sql);
	$query->execute(array($id));
	$data = $query->fetch();
	$money = $data['money'] + $amount;
	$sql = 'UPDATE accounts SET money = ? WHERE id = ?';
	$query = $bdd->prepare($sql);
	$query->execute(array($money, $id));
}

function subToAccount($id, $amount) {
	$bdd = connectDB();
	$sql = 'SELECT * FROM accounts WHERE id = ?';
	$query = $bdd->prepare($sql);
	$query->execute(array($id));
	$data = $query->fetch();
	$money = $data['money'] - $amount;
	$sql = 'UPDATE accounts SET money = ? WHERE id = ?';
	$query = $bdd->prepare($sql);
	$query->execute(array($money, $id));
}

function makeTransfer($from, $to, $amount) {
	subToAccount($from, $amount);
	addToAccount($to, $amount);
	$bdd = connectDB();
	$sql = 'INSERT INTO transfers VALUES (NULL, ?, ?, ?, NOW())';
	$query = $bdd->prepare($sql);
	$query->execute(array($from, $to, $amount));
}

function getTransfersFrom($account) {
	$bdd = connectDB();
	$sql = 'SELECT * FROM transfers WHERE account_from = ?';
	$query = $bdd->prepare($sql);
	$query->execute(array($account));
	$data = $query->fetchAll();
	return $data;
}

function getTransfersTo($account) {
	$bdd = connectDB();
	$sql = 'SELECT * FROM transfers WHERE account_to = ?';
	$query = $bdd->prepare($sql);
	$query->execute(array($account));
	$data = $query->fetchAll();
	return $data;
}

function getAllTransfers($account) {
	$bdd = connectDB();
	$sql = 'SELECT * FROM transfers WHERE account_to = ? OR account_from = ? ORDER BY date DESC';
	$query = $bdd->prepare($sql);
	$query->execute(array($account, $account));
	$data = $query->fetchAll();
	return $data;
}

function getAdvisor($user_id) {
	$bdd = connectDB();
	$sql = 'SELECT * FROM Advisor WHERE user_id = ?';
	$query = $bdd->prepare($sql);
	$query->execute(array($user_id));
	$data = $query->fetch();
	return $data;
}
