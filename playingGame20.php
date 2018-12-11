<?php
	session_start();
	$html = "";
	if ($_GET["chat"] != "")
	{
		$file = fopen("chat" . $_SESSION["gameid"] . ".txt", 'a');
		fwrite($file, $_GET["chat"] . "<br>");
		fclose($file);
	}
	if (file_exists('chat' . $_SESSION["gameid"] . ".txt"))
	{
		$html = file_get_contents("chat" . $_SESSION["gameid"] . ".txt");
	}
	$link = mysqli_connect("35.238.173.9", "root", "chUdR5Tr", "microecon");
	$result = mysqli_query($link, "SELECT Player2 FROM games WHERE ID =" . $_SESSION["gameid"]);
	$beh = mysqli_fetch_array($result);
	$arr = array("Player2" => $beh["Player2"]);
	if ($beh["Player2"] = $_SESSION["user"])
	{
		$result = mysqli_query($link, "SELECT Player1 FROM games WHERE ID =" . $_SESSION["gameid"]);
		$beh = mysqli_fetch_array($result);
		$arr = array("Player2" => $beh["Player1"]);
	}
	$result1 = mysqli_query($link, "SELECT Result FROM games WHERE Player1=\"" . $arr["Player2"] . "\"");
	$steal = 0;
	$splits = 0;
	$rows = [];
	while ($row = mysqli_fetch_array($result1))
	{
		$rows[] = $row;
	}
	foreach ($rows as $eh)
	{
		if ($eh["Result"] == 1 or $eh["Result"] == 2)
		{
			$splits = $splits + 1;
		}
		else
		{
			$steal = $steal + 1;
		}
	}
	$rows = [];
	$result1 = mysqli_query($link, "SELECT Result FROM games WHERE Player2=\"" . $arr["Player2"] . "\"");
	while ($row = mysqli_fetch_array($result1))
	{
		$rows[] = $row;
	}
	foreach ($rows as $eh)
	{
		if ($eh["Result"] == 1 or $eh["Result"] == 3)
		{
			$splits = $splits + 1;
		}
		else
		{
			$steal = $steal + 1;
		}
	}
	$result = mysqli_query($link, "SELECT * FROM games WHERE ID=" . $_SESSION["gameid"]);
	$r = $result->fetch_row();
	$_SESSION["player1"] = false;
	if ($r[0] == $_SESSION["user"])
	{
		$_SESSION["player1"] = true;
	}
	$result = mysqli_query($link, "SELECT * FROM players WHERE user=\"" . $_SESSION["user"] . "\"");
	$r = $result->fetch_row();
?>
<!DOCTYPE html>
<html>
	<head>
		<title>20 Points!</title>
		<script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.3.1.min.js"></script>
	</head>
	<body>
		<p id="stole"></p>
		<p id="split"></p>
		<div style="position:absolute;top:50%;left:50%;">
			<input id="stl" type="checkbox" style="width:5em;">STEAL</input><br>
			<input id="spl" type="checkbox" style="width:5em;">SPLIT</input><br>
			<button id="subchoice" style="width:11em;">Submit</button><br><br>
		</div>
		<p id="chat" style="text-align:left;margin-bottom:25px;padding:10px;background:#fff;height:30em;width:20em;border:1em solid #ACD8F0;overflow:auto;">
			<?php
				echo $html;
			?>
		</p>
		<input id="fek" type="text"/>
		<button type="submit" id="submit">Submit Message</button><br>
		<button style="width:11em;" id="chk">Check Opponent History</button>
	</body>
	<script>
		$("#submit").click(function(){
			window.location.href = "/Websites/playingGame20.php?chat=" + document.getElementById("fek").value + "&msg=seven&choice=" + choice;
		});
		function updateChat()
		{
			window.location.href = "/Websites/playingGame20.php?chat=&msg=" + document.getElementById("fek").value + "&choice=" + choice;
		}
		var interval = setInterval(updateChat, 3500);
		var playerChecked = false;
		if (<?php echo json_encode($_GET["msg"]) ?> != "seven")
		{
			document.getElementById("fek").value = <?php echo json_encode($_GET["msg"]) ?>;
		}
		var choice = <?php echo json_encode($_GET["choice"]) ?>;
		if (choice != "nun")
		{
			if (choice == "steal")
			{
				document.getElementById("stl").checked = true;
			}
			else
			{
				document.getElementById("spl").checked = true;
			}
		}
		var player1 = <?php echo json_encode($_SESSION["player1"]) ?>;
		$("#chk").click(function(){
			if (<?php echo $r[2] ?> >= 5)
			{
				document.getElementById("stole").innerHTML = "Games stole: " + "<?php echo $steal ?>";
				document.getElementById("split").innerHTML = "Games split: " + "<?php echo $splits ?>";
				playerChecked = true;
			}
			else
			{
				document.getElementById("stole").innerHTML = "Not enough points.";
			}
		});
		$("#stl").click(function(){
			choice = "steal";
			document.getElementById("spl").checked = false;
			document.getElementById("stl").checked = true;
		});
		$("#spl").click(function(){
			choice = "split";
			document.getElementById("stl").checked = false;
			document.getElementById("spl").checked = true;
		});
		$("#subchoice").click(function(){
			var eh;
			if (player1 && playerChecked)
			{
				eh = "Player1Checked=1&choice=" + choice;
			}
			else if (player1)
			{
				eh = "Player1Checked=0&choice=" + choice;
			}
			else if (playerChecked)
			{
				eh = "Player2Checked=1&choice=" + choice;
			}
			else
			{
				eh = "Player2Checked=0&choice=" + choice;
			}
			window.location.href = "/Websites/Result20.php?" + eh;
		});
	</script>
</html>
