<?php
	session_start();
	$link = mysqli_connect("35.238.173.9", "root", "chUdR5Tr", "microecon");
	$dumb = false;
	if ($_GET["choice"] == "fail" or $_GET["choice"] == "nun")
	{
		$newp = $_SESSION["points"] - 50;
		$rt = mysqli_query($link, "UPDATE players SET Points = " . strval($newp) . " WHERE User=\"" . $_SESSION["user"] . "\"");
		if (!$rt)
		{
			echo "fek <br>";
			echo "UPDATE players SET Points = " . strval($newp) . "WHERE User=\"" . $_SESSION["user"] . "\"";
		}
		$dumb = true;
		$_GET["choice"] = rand() % 2 == 0 ? "split" : "steal";
	}
	if ($_SESSION["player1"])
	{
		if ($_GET["Player1Checked"] == 1)
		{
			mysqli_query($link, "UPDATE games SET Player1Checked = 1 WHERE ID = " . $_SESSION["gameid"]);
			mysqli_query($link, "UPDATE players SET Points = " . strval($_SESSION["points"] - 100) . " WHERE User=\"" . $_SESSION["user"] . "\"");
		}
		if ($_GET["choice"] == "steal")
		{
			mysqli_query($link, "UPDATE games SET Player1Choice = 1 WHERE ID = " . $_SESSION["gameid"]);
		}
		else
		{
			mysqli_query($link, "UPDATE games SET Player1Choice = 0 WHERE ID = " . $_SESSION["gameid"]);
		}
	}
	else
	{
		if ($_GET["Player2Checked"] == 1)
		{
			mysqli_query($link, "UPDATE games SET Player2Checked = 1 WHERE ID = " . $_SESSION["gameid"]);
			mysqli_query($link, "UPDATE players SET Points = " . strval($_SESSION["points"] - 75) . " WHERE User=\"" . $_SESSION["user"] . "\"");
		}
		if ($_GET["choice"] == "steal")
		{
			mysqli_query($link, "UPDATE games SET Player2Choice = 1 WHERE ID = " . $_SESSION["gameid"]);
		}
		else
		{
			mysqli_query($link, "UPDATE games SET Player2Choice = 0 WHERE ID = " . $_SESSION["gameid"]);
		}
	}
	Sleep(3);
	if ($dumb)
	{
		header("Location: /Websites/end.php?dumb=true");
	}
	else
	{
		header("Location: /Websites/end.php?dumb=false");
	}
?>
