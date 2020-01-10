<?php
session_start();
?>
<!DOCTYPE html>
<html lang="pl-PL">
	<head>
		<title>Zakamarki Kryptografii</title>
		<meta charset="UTF-8">
		<link rel="stylesheet" type="text/css" href="style.css">
	</head>
	<body>
		<form action="/zk/login_account.php" method="post">
			<input type="text" name="name" placeholder="Imię">
			<input type="password" name="passwd" placeholder="Hasło">
			<input type="submit" value="Zaloguj">
		</form>
		<p><a href="register.php">Rejestracja</a></p>
	</body>
</html>