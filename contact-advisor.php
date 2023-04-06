<?php
require_once('database.php');

session_start();
if(!isset($_SESSION['username'])) header('Location: index.php');

$advisor = getAdvisor($_SESSION['id']);
$info = null;

if(isset($_POST['btnAdvisor'])) {
	$info = "Votre message a bien été envoyé à votre conseiller.";
}
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Contact conseiller</title>
	<link rel="stylesheet" type="text/css" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;600&display=swap" rel="stylesheet">




</head>
<body>
    <div class="main-background">
        <div class="shape"></div>
        <div class="shape"></div>
        <br>
		<h1>Bonjour <?= $_SESSION['username'] ?></h1>

    	<?php if($info) { ?>
			<p class="info"><?= $info ?></p>
    	<?php } ?>

		<form method="post" action="contact-advisor.php" id="contact-form">

        <h3>Contacter <?= $advisor['name'] ?></h3>

        <br>

        <textarea col="15" name="message"></textarea>
        <button name="btnAdvisor">Envoyer le message</button>
    </form>

    </div>


	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>

	<script>
		setTimeout(function(){
		  $('.info').fadeOut();
		}, 3000);
	</script>

</body>
</html>