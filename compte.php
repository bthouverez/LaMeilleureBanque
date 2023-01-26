<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Le compte</title>
</head>
<body>
	<h1>Bonjour ...</h1>
	<h2>Votre compte courant</h2>

	<section>
		<ul>
			<li>Solde : 1520 €</li>
			<li>Découvert autorisé : 500 €</li>
		</ul>
	</section>

	<form method="post" action="compte.php">
		<h2>Ajout</h2>
		<input type="number" placeholder="Somme à ajouter">
		<button name="btnAjout">Ajouter</button>
	</form>

	<form method="post" action="compte.php">
		<h2>Retrait</h2>
		<input type="number" placeholder="Somme à retirer">
		<button name="btnRetrait">Retirer</button>
	</form>

	<a href="comptes.php">Retour</a>
</body>
</html>