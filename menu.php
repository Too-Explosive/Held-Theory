<?php
	session_start();
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Held Theory</title>
	</head>
	<body>
		<button onclick="location.href = '/Websites/rules.html';" style="width:10em;">Rules</button><br>
		<button onclick="location.href = '/Websites/leaderboard.php';" style="width:10em">Leaderboard</button><br>
		<button onclick="location.href = '/Websites/waiting.php';" style="width:10em;">20 Point Game</button>
		<?php echo "<p>Your points: " . $_SESSION["points"] . "</p>"; ?>
	</body>
</html>