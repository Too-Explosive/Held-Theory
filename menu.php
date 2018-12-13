<?php
	session_start();
	$link = mysqli_connect("35.238.173.9", "root", "chUdR5Tr", "microecon");
	$result = mysqli_query($link, "SELECT * FROM players WHERE User = \"" . $_SESSION["user"] . "\"");
	$row = mysqli_fetch_array($result);
	$_SESSION["points"] = $row["Points"];
	?>
<!DOCTYPE html>
<html>
	<head>
		<title>Held Theory</title>
	</head>
	<body>
		<button onclick="location.href = '/Websites/rules.html';" style="width:10em;">Rules</button><br>
		<button onclick="location.href = '/Websites/leaderboard.php';" style="width:10em">Leaderboard</button><br>
		<button onclick="location.href = '/Websites/game20.php';" style="width:10em;">100 Point Game</button>
		<button onclick="location.href = '/Websites/game250.php';" style="width:10em;">250 Point Game</button>
		<button onclick="location.href = '/Websites/game500.php';" style="width:10em;">500 Point Game</button>
		<?php echo "<p>Your points: " . $_SESSION["points"] . "</p>"; ?>
	</body>
</html>
