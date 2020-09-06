<?php
	require 'data/included/dbh.inc.php';
?>

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Kalender</title>
</head>
<body>
	<?php
		if (!$_POST['tyear'])
			$year = date('Y');
		else
			$year = $_POST['tyear'];

		echo "<form method=\"post\" action=\"" . $_SERVER['PHP_SELF'] . "\">";
		echo "<B>Kalender " . $year . "</B> ";
		echo "<select name=\"tyear\">";

		for ($i = date('Y')-10; $i < date('Y')+10; $i++)
		{
			if ($i == year)
				echo "<option value=\"" . $i . "\" selected>" . $i . "</option>";
			else
				echo "<option value=\"" . $i . "\">" . $i . "</option>";
		}
		echo "</select> ";
		echo "<input type=\"submit\" name=\"submit\" value=\"check\">";
		echo "</form><p>";

		if ($_POST['jnaam'])
		{
			$gebdatum = $gebdd . "-" . $gebmm . "-" . $gebyy;

			$sql = "INSERT INTO " . $table . " (id, datum, naam) VALUES ('', '" . $gebdatum . "', '" . $_POST['jnaam'] . "')";
        	$res = mysql_query($sql);

        	if ($res)
        	{
        		echo "<b>" . $_POST['jnaam'] . "</b> toegevoegd.<p>";
        	}
        	else
        	{
        		echo "<B>" . $_POST['jnaam'] . "</b> niet toegevoegd.<p>";
        	}
		}
		elseif ($_GET['id'])
		{
			$sql = "DELETE FROM " . $table . " WHERE id = '" . $_GET['id'] . "'";
			$res = mysql_query($sql);

			if ($res)
			{
				echo "<B>Verjaardag verwijderd.</b><p>";
			}
			else
			{
				echo "<b>Verjaardag kon niet verwijderd worden.</b><p>";
			}
		}

		echo "<table border=1 cellspacing=0 cellpadding=5><tr><td>";
		echo "<form method=\"post\" action=\"" . $_SERVER['PHP_SELF'] . "\">";
		echo "<b>Verjaardag toevoegen</b><br>";
		echo "Naam: <input type=\"text\" name=\"jnaam\"><br>";
		echo "<select name=\"gebdd\">";
		for ($dd = 1; $dd <= 31; $dd++)
		{
			if ($dd < 10)
				$sd = "0" . $dd;
			else
				$sd = $dd;
			echo "<option value=\"" . $sd . "</option>";
		}
		echo "</select> ";
		echo "<select name=\"gebmm\">";