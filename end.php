<?php
	session_start();
	$link = mysqli_connect("35.238.173.9", "root", "chUdR5Tr", "microecon");
	$result = mysqli_query($link, "SELECT * FROM games WHERE ID = " . $_SESSION["gameid"]);
	$beh = mysqli_fetch_array($result);
	echo "Your choice: ";
	if ($_SESSION["player1"])
	{
		echo ($beh["Player1Choice"] ? "steal" : "split") . "<br>Opposing choice: " . ($beh["Player2Choice"] ? "steal" : "split");
	}
	else
	{
		echo ($beh["Player2Choice"] ? "steal" : "split") . "<br>Opposing choice: " . ($beh["Player1Choice"] ? "steal" : "split");
	}
	if ($_GET["dumb"] == "true")
	{
		echo "<br>Because you did not choose at all you lose five points.";
	}
	if ($beh["Player1Choice"] == 1 and $beh["Player2Choice"] == 1)
	{
		echo "<br>You gained zero points!";
	}
	else if ($beh["Player1Choice"] == 0 and $beh["Player2Choice"] == 0)
	{
		mysqli_query($link, "UPDATE players SET Points = " . strval((int)$_SESSION["points"] + (int)$beh["Value"] / 2) . " WHERE User=\"" . $_SESSION["user"] . "\"");
		echo "<br>You gained " . strval((int)$beh["Value"] / 2) . " points!";
	}
	else if ($beh["Player1Choice"] == 1 and $_SESSION["player1"])
	{
		mysqli_query($link, "UPDATE players SET Points = " . $beh["Value"] . " WHERE User=\"" . $_SESSION["user"] . "\"");
		echo "<br>You gained " . $beh["Value"] . " points!";
	}
	else if ($_SESSION["player1"])
	{
		echo "<br>You gained zero points!";
	}
	else if (!$_SESSION["player1"] and $beh["Player2Choice"] == 1)
	{
		mysqli_query($link, "UPDATE players SET Points = " . $beh["Value"] . " WHERE User=\"" . $_SESSION["user"] . "\"");
		echo "<br>You gained " . $beh["Value"] . " points!";
	}
	else
	{
		echo "<br>You gained zero points!";
	}
?>
<DOCTYPE html>
<html>
	<head>
		<title>Results!</title>
	</head>
	<body>
		<br>
		<button onclick="window.location.href='/Websites/menu.php';" style="width:5em;height:2em;">MENU</button>
	</body>
</html>
