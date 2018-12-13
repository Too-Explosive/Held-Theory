<?php
	$link = mysqli_connect("35.238.173.9", "root", "chUdR5Tr", "microecon");
	$result = mysqli_query($link, "SELECT MAX(Points) AS Points FROM players");
	if (!$result)
	{
		echo "The leaderboard is not available at this time.<br>";
	}
	else
	{
		$row = mysqli_fetch_array($result);
		$result = mysqli_query($link, "SELECT User FROM games WHERE Points = " . strval($row["Points"]));
		$tr = mysqli_fetch_array($result);
		echo $tr["User"] . " with " . strval($row["Points"]) . " points!";
	}
?>