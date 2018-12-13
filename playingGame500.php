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
	$result1 = mysqli_query($link, "SELECT Player1Choice FROM games WHERE Player1=\"" . $arr["Player2"] . "\"");
	$steal = 0;
	$splits = 0;
	$rows = [];
	if (!$result1)
	{
		printf("Error: %s\n", mysqli_error($link));
	}
	while ($row = mysqli_fetch_array($result1))
	{
		$rows[] = $row;
	}
	foreach ($rows as $eh)
	{
		if ($eh["Player1Choice"] == 1)
		{
			$splits = $splits + 1;
		}
		else
		{
			$steal = $steal + 1;
		}
	}
	$rows = [];
	$result1 = mysqli_query($link, "SELECT Player2Choice FROM games WHERE Player2=\"" . $arr["Player2"] . "\"");
	while ($row = mysqli_fetch_array($result1))
	{
		$rows[] = $row;
	}
	foreach ($rows as $eh)
	{
		if ($eh["Player2Choice"] == 1)
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
		<title>500 Points!</title>
		<script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.3.1.min.js"></script>
	</head>
	<body>
		<p id="stole"></p>
		<p id="split"></p>
		<div style="position:absolute;top:50%;left:50%;">
			<h1 id="time"></h1><br>
			<input id="stl" type="checkbox" style="width:5em;">STEAL</input><br>
			<input id="spl" type="checkbox" style="width:5em;">SPLIT</input><br>
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
		var time = <?php echo (int)$_GET["time"] ?>;
		document.getElementById("time").innerHTML = time;
		var tick = setInterval(alot, 1000);
		var inteh = setInterval(updateChat, 3500);
		function alot()
		{
			if (time <= 0)
			{
				clearInterval(tick);
				clearInterval(inteh);
				var eh;
				if (choice != "steal" || choice != "split")
				{
					choice = "fail";
				}
				if (document.getElementById("stl").checked)
				{
					choice = "steal";
				}
				if (document.getElementById("spl").checked)
				{
					choice = "split";
				}
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
			}
			else
			{
				time = time - 1;
				document.getElementById("time").innerHTML = time;
			}
		}
		$("#submit").click(function(){
			window.location.href = "/Websites/playingGame20.php?chat=" + document.getElementById("fek").value + "&msg=seven&choice=" + choice + "&time=" + time;
		});
		function updateChat()
		{
			if (time <= 0)
			{
				alot();
			}
			else
			{
				var thing;
				if (playerChecked)
				{
					thing = "&check=true";
				}
				else
				{
					thing = "&check=false";
				}
				window.location.href = "/Websites/playingGame20.php?chat=&msg=" + document.getElementById("fek").value + "&choice=" + choice + "&time=" + time + thing;
			}
		}
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
			if (<?php echo $r[2] ?> >= 75)
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
		if (<?php echo json_encode($_GET["check"]) ?> == "true")
		{
			document.getElementById("stole").innerHTML = "Games stole: " + "<?php echo $steal ?>";
			document.getElementById("split").innerHTML = "Games split: " + "<?php echo $splits ?>";
		}
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
	</script>
</html>