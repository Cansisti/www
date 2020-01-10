<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {

	$name = $_POST["name"];
	$passwd = $_POST["passwd"];

	if(!empty($name) and !empty($passwd)) {
		$file = fopen("accounts.txt", "r");

		while(!feof($file)) {
			$line = fgets($file);
			if($line == $name." ".$passwd) {
				$_SESSION["name"] = $name;
				$location = "index.php";
				echo '<META HTTP-EQUIV="Refresh" Content="0; URL='.$location.'">';
				return;
			}
		}
		fclose($file);
	}
	$location = "login.php";
	echo '<META HTTP-EQUIV="Refresh" Content="0; URL='.$location.'">';
}
?>