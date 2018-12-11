<?php
	session_start();
	ini_set("max_execution_time", 30);
	$link = mysqli_connect("35.238.173.9", "root", "chUdR5Tr", "microecon");
	$query = "SELECT User, Points FROM players WHERE User=\"" . $_POST["username"] . "\" AND Hash=\"" . hash("sha256", $_POST["password"]) . "\"";
	$result = mysqli_query($link, $query);
	if ($result->num_rows == 1)
	{
		$arr = mysqli_fetch_array($result);
		$_SESSION["points"] = $arr["Points"];
		$_SESSION["user"] = $arr["User"];
		header("Location: /Websites/menu.php");
	}
	else
	{
		header("Location: /Websites/WrongLogin.html");
	}
?>
