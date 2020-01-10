<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {

	if(!isset($_SESSION["name"])) {
		$location = "login.php";
		echo '<META HTTP-EQUIV="Refresh" Content="0; URL='.$location.'">';
		return;
	}

	$comment = $_POST["comment"];

	if(!empty($comment)) {
		$file = fopen("comments.html", "a");
		fwrite($file, "<p><b>".$_SESSION["name"]."</b>: ".$comment."</p>\n");
		fclose($file);
	}

	$location = "index.php";
	echo '<META HTTP-EQUIV="Refresh" Content="0; URL='.$location.'">';
}
?>