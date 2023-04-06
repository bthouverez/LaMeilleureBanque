<?php
require_once('database.php');

session_start();
if(!isset($_SESSION['username'])) header('Location: index.php');

$accounts = getAccounts($_SESSION['id']);
$advisor = getAdvisor($_SESSION['id']);
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
        <div class="shape"></div>
        <div class="shape"></div>
        <br>
		<h1>Bonjour <?= $_SESSION['username'] ?></h1>
		<?php if($advisor) { ?>
			<a href="contact-advisor.php">
				<div id="advisor">
					Prenez rendez-vous avec votre conseiller : <?= $advisor['name'] ?>
				</div>
			</a>
			<br>

		<?php } ?>
		<br>
		<h2>Vos comptes bancaires</h2>

		<section id="accounts">
			<?php foreach($accounts as $account) { ?>
			<a href="compte.php?id=<?= $account['id'] ?>">
				<div>
					<p>Compte : <?= $account['label'] ?></p>
					<ul>
						<li>Solde : <?= $account['money'] ?> €</li>
						<li>Découvert autorisé : <?= $account['overdraft'] ?> €</li>
					</ul>
				</div>
			</a>
			<?php } ?>
		</section>
    </div>
    <a href="index.php?deco"><button class="btnDeco">Déconnexion</button></a>

</body>
</html>