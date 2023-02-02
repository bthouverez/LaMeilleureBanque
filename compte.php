<?php
require_once('database.php');

session_start();
if(!isset($_SESSION['username'])) header('Location: index.php');

$error = null;
$account = getAccount($_GET['id']);


if(isset($_POST['btnAjout'])) {
	if(isset($_POST['amount']) AND $_POST['amount'] != '') {
		addToAccount($account['id'], $_POST['amount']);
	}
}


if(isset($_POST['btnRetrait'])) {
	if(isset($_POST['amount']) AND $_POST['amount'] != '') {
		if($_POST['amount'] < $account['money']+$account['overdraft']) {
			subToAccount($account['id'], $_POST['amount']);
		} else {
			$error = 'Découvert max dépassé';
		}
	}
}

$account = getAccount($_GET['id']);

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Les comptes</title>
	<link rel="stylesheet" type="text/css" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;600&display=swap" rel="stylesheet">
</head>
<body>
	<div class="main-background">
	    <br>
		<h1>Bonjour <?= $_SESSION['username'] ?></h1>
		<h2>Votre compte numéro <?= $account['id'] ?></h2>

		
		<?php if($error) { ?>
			<p class="error"><?= $error ?></p>
		<?php } ?>

		<section id="account-info">
			<ul>
				<li>Solde : <?= $account['money'] ?> €</li>
				<li>Découvert autorisé : <?= $account['overdraft'] ?> €</li>
			</ul>
		</section>

		<section id="forms">
			<form method="post" action="compte.php?id=<?= $account['id'] ?>" class="form">
				<h2>Ajout</h2>
				<input type="number" placeholder="Somme à ajouter" name="amount">
				<button name="btnAjout">Ajouter</button>
			</form>

			<form method="post" action="compte.php?id=<?= $account['id'] ?>" class="form">
				<h2>Retrait</h2>
				<input type="number" placeholder="Somme à retirer" name="amount">
				<button name="btnRetrait">Retirer</button>
			</form>
		</section>

		<a href="comptes.php">Retour</a>
	</div>
</body>
</html>