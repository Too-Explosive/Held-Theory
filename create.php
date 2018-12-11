<?php
	session_start();
	$link = mysqli_connect("35.238.173.9", "root", "chUdR5Tr", "microecon");
	$query = "SELECT User FROM players WHERE User=\"" . $_POST["username"] . "\"";
	$result = mysqli_query($link, $query);
	if ($result->num_rows == 0)
	{
		$query = "INSERT INTO players(User, Hash, Points) VALUES ( \"" . $_POST["username"] . "\",\"" . hash("sha256", $_POST["password"]) . "\",20)";
		mysqli_query($link, $query);
		$_SESSION["points"] = 20;
		$_SESSION["user"] = $_POST["username"];
		header("Location: /Websites/menu.php");
	}
	else
	{
		header("Location: /Websites/usertaken.html");
	}
?>
