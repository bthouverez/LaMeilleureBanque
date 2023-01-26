<?php

if(isset($_POST['btnConnect'])) {
	header('Location: comptes.php');
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>MaBanque</title>
</head>
<body>
<h1>Bienvenue sur ma banque</h1>

<form method="post" action="index.php">
	<input type="text" placeholder="Identifiant">
	<input type="password" placeholder="Mot de passe">
	<button name="btnConnect">Se connecter</button>
</form>
</body>
</html>