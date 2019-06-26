<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE-edge,chrome=1">
	<title>Battlebots Information Center - Modify Match</title>
	<link rel="stylesheet" type="text/css" href="bbic.css">
	<link rel="favicon" href="bbic.ico">
</head>

<body>
	<?php
		/*
			This is a PHP file used as part of a project connecting a website to a remote database. 
			The project was based on "Battlebots," a robot combat competition TV show that aired from 1999 to 2018.
			I recorded all known matches from the 10 seasons available at that time, as well as all competing robots and their builders.
			The file checks for connection to the database, and pulls certain fields as variables. 
			The pulled fields are then inserted and echoed into a webpage that is used to catalog the record of the certain robot based on all matches recorded it has participated in.
		*/
	
		$server = "localhost";
		$user = "bbinform_root";
		$pw = "battlebots123";
		$db = "bbinform_battlebots";
		
		$connect = mysqli_connect($server, $user, $pw, $db);
		
		if (!connect) {
			die ("ERROR: Cannot connect to database $db (".mysqli_connect_errno() . ", ".mysqli_connect_error().")");
		}
		
		$ID = $_GET["matchID"];
		$Round = $_GET["matchRound"];
		$TournamentName = $_GET["tournamentName"];
		$Winner = $_GET["matchWinner"];
		$WinType = $_GET["matchWinType"];
		$Time = $_GET["matchTime"];
		$Score = $_GET["matchScore"];
		
		if ($WinType == "KO") {
			$Score = null; // Matches that end in a KO have no judges' score. 
		} else if ($WinType == "JD") {
			$Time = "3:00"; // Matches that go to the judges must last the full 3 minutes.
		}
		
		$userQuery = "INSERT INTO match (matchID, matchRound, tournamentName, matchWinner, matchWinType, matchTime, matchScore) VALUES ('$ID', '$Round', '$TournamentName', '$Winner', '$WinType', '$Time', '$Score')";
		
		$result = mysqli_query($connect, $userQuery);
		
		if (!result) {
			die ("Unable to run query ($userQuery) from $db: " . mysqli_error($connect));
		} else {
			echo("<h2>Add Match</h2>");
			echo("<p>The following match was successfully added to the database:</p>");
			echo("<table border='0'>
					<tr><td>Match ID</td><td>$ID</td></tr>
					<tr><td>Round</td><td>$Round</td></tr>
					<tr><td>Tournament</td><td>$TournamentName</td></tr>
					<tr><td>Winner</td><td>$Winner</td></tr>
					<tr><td>Win Type</td><td>$WinType</td></tr>
					<tr><td>Time</td><td>$Time</td></tr>
					<tr><td>Score</td><td>$Score</td></tr>
					</table>");
		}
		
		mysqli_close($connect);
	?>
</body>

