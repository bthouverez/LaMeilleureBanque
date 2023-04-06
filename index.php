<?php
require_once('database.php');
session_start();

$error = null;

if(isset($_GET['deco'])) {
	session_destroy();
}


if(isset($_SESSION['username'])) {
	header('Location: comptes.php');
}

if(isset($_POST['btnConnect'])) {
	if(isset($_POST['username']) AND $_POST['username'] != '') {
		if(isset($_POST['password']) AND $_POST['password'] != '') {
			$con = connectUser($_POST['username'], $_POST['password']);
			if($con === true) {
				header('Location: comptes.php');
			} else {
				$error = $con;	
			}
		} else {
			$error = 'Il faut saisir un mot de passe';
		}
	} else {
		$error = 'Il faut saisir un nom d\'utilisateur';
	}
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>MaBanque</title>
	<link rel="stylesheet" type="text/css" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;600&display=swap" rel="stylesheet">
</head>
<body>
    <div class="background">
        <div class="shape"></div>
        <div class="shape"></div>
    </div>
    <form method="post" action="index.php" id="connect-form">
    	
    	<?php if($error) { ?>
			<p class="error"><?= $error ?></p>
    	<?php } ?>

        <h3>Connexion MaBanque</h3>

        <br>
        <input type="text" placeholder="Nom d'utilisateur" id="username" name="username">
        <input type="password" placeholder="Mot de passe" id="password" name="password">

        <button name="btnConnect">Se connecter</button>
    </form>
</body>
</html>