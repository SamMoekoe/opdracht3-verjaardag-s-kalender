<?php

	$servername = "localhost";
	$database = "kalender";
	$username = "root";
	$password = "";

	try{
		$conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}
	catch(PDOException $e){
		echo "Connection failed: " . $e->getMessage();
	}

	try {
		$stmt = $conn->prepare("SELECT * FROM verjaardagen ORDER BY `date` desc");

		$stmt->execute();

		$result = $stmt->fetchall();
	}
	catch(PDOException $e){
		echo "Connection failed: " . $e->getMessage();
	}
		$conn = null;
		?>

	<html lang="en">
	<head>
		<meta charset="UTF-8">
		<link rel="shortcut icon" type="image/x-icon" href="assets/icon/42446.png">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Kalender</title>
		<link rel="stylesheet" href="data/css/style.css">
    	<link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    </head>
    <body>
    	<div id="page">
    		<h1 id="title">Verjaardags Kalender</h1>
    		<nav>
    			<a href="">hoofd pagina</a>
    			<a href="data/add.php">voeg toe</a>
    		</nav>
    		<?php foreach($result as $birthday) {?>
    			<div class="card">
    				<h1><?= $birthday["name"]; ?></h1>
    				<h2><?= $birthday["date"]; ?></h2>
    				<a href="data/edit.php?id=<?= $birthday["id"]; ?>">bewerk</a>
    				<a href="data/delete.php?id=<? $birthday["id"]; ?>">verwijder</a>
    			</div>
    		<?php } ?>
    	</div>
    </body>
    </html>