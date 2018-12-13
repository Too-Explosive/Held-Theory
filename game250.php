<?php
	session_start();
	$link = mysqli_connect("35.238.173.9", "root", "chUdR5Tr", "microecon");
	$result = mysqli_query($link, "SELECT * FROM games WHERE Player1 IS NOT NULL AND Value=250 AND Player2 IS NULL");
	if ($result->num_rows == 0)
	{
		mysqli_query($link, "INSERT INTO games(Value, Player1) VALUES(250, \"" . $_SESSION["user"] . "\")");
		$result = mysqli_query($link, "SELECT * FROM games WHERE Player1=\"" . $_SESSION["user"] . "\" AND Player2 IS NULL");
		$row = $result->fetch_row();
		$_SESSION["gameid"] = $row[5];
		header("Location: /Websites/waiting250.php");
	}
	else
	{
		$row = $result->fetch_row();
		$_SESSION["gameid"] = $row[5];
		mysqli_query($link, "UPDATE games SET Player2=\"" . $_SESSION["user"] . "\" WHERE ID=" . $row[5]);
		header("Location: /Websites/playingGame250.php?chat=&choice=nun&msg=seven&time=15&check=shit");
	}
?>