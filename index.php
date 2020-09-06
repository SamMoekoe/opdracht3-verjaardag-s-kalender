<?php
	require 'data/included/dbh.inc.php'
?>

<head>
	<meta charset="UTF-8">
	<link rel="shortcut icon" type="image/x-icon" href="42446.png" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Kalender</title>
</head>
<body>
	<?php

	$table = "kalender";

    
    if (!$_POST['tyear'])
        $year = date('Y');
    else
        $year = $_POST['tyear'];
    
    echo "<form method=\"post\" action=\"" . $_SERVER['PHP_SELF'] . "\">";
    echo "<B>Kalender " . $year . "</B> ";
    echo "<select name=\"tyear\">";
    
    for ($i = date('Y')-10; $i < date('Y')+10; $i++)
    {
        if ($i == $year)
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
        $res = PDO_MySQL($sql);
        
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
        $res = PDO_MySQL($sql);
        
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
        
        echo "<option value=\"" . $sd . "\">" . $sd . "</option>";
    }
    echo "</select> ";
    echo "<select name=\"gebmm\">";
    echo "<option value=\"01\">Jan</option>";
    echo "<option value=\"02\">Feb</option>";
    echo "<option value=\"03\">Mar</option>";
    echo "<option value=\"04\">Apr</option>";
    echo "<option value=\"05\">Mei</option>";
    echo "<option value=\"06\">Jun</option>";
    echo "<option value=\"07\">Jul</option>";
    echo "<option value=\"08\">Aug</option>";
    echo "<option value=\"09\">Sep</option>";
    echo "<option value=\"10\">Okt</option>";
    echo "<option value=\"11\">Nov</option>";
    echo "<option value=\"12\">Dec</option>";
    echo "</select>";
    
    echo "<select name=\"gebyy\">";
    for ($yy = date('Y')-80; $yy <= date('Y'); $yy++)
    {
        if ($yy == date(Y))
            echo "<option value=\"" . $yy . "\" selected>" . $yy . "</option>";
        else
            echo "<option value=\"" . $yy . "\">" . $yy . "</option>";
    }
    echo "</select> ";
    
    echo "<input type=\"submit\" value=\"toevoegen\" name=\"submit\">";
    echo "</form></td></tr></table><p>";

        $sql = "SELECT id,datum,naam FROM " . $table;
    $res = PDO_MySQL($sql);
    
    $i = 1;
    while ($row = mysql_fetch_array($res))
    {
        $id[$i] = $row['id'];
        $birthday[$i] = $row['datum'];
        $name[$i] = $row['naam'];
        
        $i++;
    }
    unset($i);

    $months[1] = "Januari";
    $months[2] = "Februari";
    $months[3] = "Maart";
    $months[4] = "April";
    $months[5] = "Mei";
    $months[6] = "Juni";
    $months[7] = "Juli";
    $months[8] = "Augustus";
    $months[9] = "September";
    $months[10] = "Oktober";
    $months[11] = "November";
    $months[12] = "December";
    

    echo "<table border=\"1\" cellspacing=\"0\" cellpadding=\"5\">\n";
    echo "<tr>\n";
    echo "<th width=\"100\">Maand</th>\n";
    echo "<th width=\"100\">Naam</th>\n";
    echo "<th width=\"20\">Wordt</th>\n";
    echo "<th width=\"100\">Geb. datum</th>\n";
    echo "</tr>\n\n";
    

    for ($i = 1; $i <= count($months); $i++)
    {
        echo "<tr>\n";
        

        if (date('m') < 10)
            $thismonth = substr(date('m'), 1, 1);
        else
            $thismonth = date('m');
            
        if ($thismonth == $i)
            echo "<td bgcolor=\"#cccccc\"><b>" . $months[$i] . "</b>";
        else
            echo "<td><b>" . $months[$i] . "</b>";
            
        echo "</td>";
        

        for ($b = 1; $b <= count($birthday); $b++)
        {

            if (substr($birthday[$b], 3, 2) < 10)
                $setbirth = substr($birthday[$b], 4, 1);
            else
                $setbirth = substr($birthday[$b], 3, 2);
            
            if ($i == $setbirth)
            {
                $age = substr($birthday[$b], 6, 4);
                $age = $year - $age;
                

                if (!$birthdays)
                {
                    echo "<td>[ <font color=\"#ff0000\"><a href=\"" . $_SERVER['PHP_SELF'] . "?id=" . $id[$b] . "\">del</a></font> ] | " . htmlentities($name[$b]) . "</td>\n";
                    echo "<td>" . $age . "</td>\n";
                    echo "<td>" . $birthday[$b] . "</td>\n";
                    echo "</tr>\n\n";
                    
                    $birthdays = 1;
                }

                else
                {
                    echo "<tr>\n";
                    echo "<td>&nbsp;</td>\n";
                    echo "<td>[ <font color=\"#ff0000\"><a href=\"" . $_SERVER['PHP_SELF'] . "?id=" . $id[$b] . "\">del</a></font> ] | " . htmlentities($name[$b]) . "</td>\n";
                    echo "<td>" . $age . "</td>\n";
                    echo "<td>" . $birthday[$b] . "</td>\n";
                    echo "</tr>\n\n";
                }
            }
        }
        

        if (!$birthdays)
        {
            echo "<td><i>Geen verjaardagen</i></td>\n";
            echo "<td>&nbsp;</td>\n";
            echo "<td>&nbsp;</td>\n";
            echo "</tr>\n\n";
        }
        
        unset($birthdays);
    }
?>

<?php
	require 'data/included/footer.php';
?>