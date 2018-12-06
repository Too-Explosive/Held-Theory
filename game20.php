<?php
	session_start();
	$link = mysqli_connect("35.238.173.9", "root", "chUdR5Tr", "microecon");
	$result = mysqli_query($link, "SELECT * FROM games WHERE Player1 IS NOT NULL AND Value=20 AND Player2 IS NULL");
	if ($result->num_rows == 0)
	{
		mysqli_query($link, "INSERT INTO games(Value, Player1) VALUES (20, " . $_SESSION["user"] . ")");
		/*$result = mysqli_query($link, "SELECT * FROM games WHERE Player1=\"" . $_SESSION["user"] . "\"");
		while($result->num_rows == 0)
		{
			$result = mysqli_query($link, "SELECT * FROM games WHERE Player1=\"" . $_SESSION["user"] . "\"");
		}
		header("Location: /Websites/playingGame20.php");*/
	}
	else
	{
		$row = $result->fetch_row();
		mysqli_query($link, "UPDATE games SET Player2=\"" . $_SESSION["user"] . "\" WHERE Player1=\"" . $row[3] . "\"");
		header("Location: /Websites/playingGame20.php");
	}
	echo "INSERT INTO games(Value, Player1) VALUES (20, \"" . $_SESSION["user"] . "\")";
?>