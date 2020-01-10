<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {

	$comment = $_POST["comment"];

	if(!empty($comment)) {
		$file = fopen("comments.html", "a");
		fwrite($file, "<p><b>Anonim</b>: ".$comment."</p>\n");
		fclose($file);
	}

	$location = "index.php";
	echo '<META HTTP-EQUIV="Refresh" Content="0; URL='.$location.'">';
}
?>