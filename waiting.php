<?php
	session_start();
	$link = mysqli_connect("35.238.173.9", "root", "chUdR5Tr", "microecon");
	$result = mysqli_query($link, "SELECT * FROM games WHERE ID=" . $_SESSION["gameid"] . " AND Player2 IS NOT NULL");
	if ($result->num_rows == 0)
	{
		Sleep(2);
		header("Location: /Websites/waiting.php");
	}
	else
	{
		header("Location: /Websites/playingGame20.php?chat=&choice=nun&msg=seven&time=15&check=false");
	}
?>
