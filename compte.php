<?php
require_once('database.php');

session_start();
if(!isset($_SESSION['username'])) header('Location: index.php');

$error = null;
$info = null;
$account = getAccount($_GET['id']);


if(isset($_POST['btnAjout'])) {
	if(isset($_POST['amount']) AND $_POST['amount'] != '') {
		addToAccount($account['id'], $_POST['amount']);
		$info = "Vous avez ajouté ".$_POST['amount']." € à votre compte";
	}
}


if(isset($_POST['btnRetrait'])) {
	if(isset($_POST['amount']) AND $_POST['amount'] != '') {
		if($_POST['amount'] < $account['money']+$account['overdraft']) {
			subToAccount($account['id'], $_POST['amount']);
		$info = "Vous avez ajouté ".$_POST['amount']." € de votre compte";
		} else {
			$error = 'Découvert max dépassé';
		}
	}
}

if(isset($_POST['btnVirement'])) {
	if(isset($_POST['account']) AND $_POST['account'] != '') {
		if(isset($_POST['amount']) AND $_POST['amount'] != '') {
			if($_POST['account'] != $account['id']) {
				if($_POST['amount'] < $account['money']+$account['overdraft']) {
					makeTransfer($account['id'], $_POST['account'], $_POST['amount']);

				$info = "Vous avez envoyé ".$_POST['amount']." € au compte numéro ".$_POST['account'];
				} else {
					$error = 'Découvert max dépassé';
				}
			} else {
				$error = 'Impossible de transférer sur son propre compte';
			}

		}
	}
}

$account = getAccount($_GET['id']);
$transfers = getAllTransfers($_GET['id']);
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

    	<?php if($info) { ?>
			<p class="info"><?= $info ?></p>
    	<?php } ?>
		
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
		<br><br>
		<section>
			<h2>Effectuer un virement</h2>
			<form method="post" action="compte?id=<?= $account['id'] ?>" class="form">
				<input type="number" placeholder="ID du compte à créditer" name="account">
				<input type="number" placeholder="Somme à transférer" name="amount">
				<button name="btnVirement">Envoyer</button>
				
			</form>
		</section>
		<section>
			<h2>Historique des virements</h2>
			<table class="table">
				<tr>
					<th>ID</th>
					<th>Date</th>
					<!-- <th>Compte départ</th> -->
					<!-- <th>Compte destination</th> -->
					<th>Somme</th>
			<?php foreach($transfers as $transfer) { ?>

				<tr>
					<td><?= $transfer['id'] ?></td>
					<td><?= date_format(date_create($transfer['date']), 'j M y à h\hi') ?></td>
					<!-- <td>< ?= $transfer['account_from'] ?></td> -->
					<!-- <td>< ?= $transfer['account_to'] ?></td> -->
					<td style="color: <?= $transfer['account_to'] == $_GET['id'] ? 'green' : 'red' ?>">
						<?= $transfer['account_to'] == $_GET['id'] ? '+' : '-' ?><?= $transfer['amount'].' €' ?>
					</td>
				</tr>
			<?php } ?>
			</table>
		</section>

		<a href="comptes.php">Retour</a>
	</div>
</body>
</html>