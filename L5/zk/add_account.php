<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {

	$name = $_POST["name"];
	$passwd = $_POST["passwd"];

	if(!empty($name) and !empty($passwd)) {
		$file = fopen("accounts.txt", "a");
		fwrite($file, $name." ".$passwd."\n");
		fclose($file);
	}
	else {
		$file = fopen("accounts.txt", "w");
		fwrite($file, "test\n");
		fclose($file);
	}

	$location = "index.php";
	echo '<META HTTP-EQUIV="Refresh" Content="0; URL='.$location.'">';
}
?>
