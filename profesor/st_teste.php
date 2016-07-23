<?php
include 'autentificare.php';
?>
<!DOCTYPE html>
<html>

<head>
<link rel="stylesheet" type="text/css" href="style.css">
<link rel="stylesheet" type="text/css" href="style_prof.css">
<title>Panou de administrare</title>
</head>
      
<body>

<header>
<h1>Bine ati venit domnule profesor!</h1>
<br><span><a href="logout.php">Deconecteaza-te</a></span>
</header>

<div class="rotund">
    <?php
    include 'conectare.php';
	
	if(@$_POST['cont_test'])
	{
		$val=@$_POST['radio'];
		if($val)
		{
			$intr=mysql_query("SELECT `id-intreb`,`intrebare` FROM `intrebari` WHERE `id-cap`='$val'");
			echo "Ce intrebare doriti sa stergeti?<br><br>";
			if(mysql_num_rows($intr))
			{echo "<form action=\"st_teste_2.php\" method=\"post\">";
			while($intrr=mysql_fetch_row($intr))
			{
				echo "<input type=\"radio\" name=\"radio\" value=\"$intrr[0]\">&nbsp $intrr[1]<br>";
				echo "<br>Raspunsurile:<br>";
				$rasp=mysql_query("SELECT `raspuns` FROM `raspunsuri` WHERE `id-intreb`='$intrr[0]'");
				while($r=mysql_fetch_row($rasp))
					echo "<li> ".$r[0]."</li><br>";
			}
			echo "<span><input class=\"buton\" type=\"submit\" name=\"cont_intr\" value=\"Continuati\"></span>";
			echo "</form>";
			}
			else
				echo "<br><i style=\"margin:4px;color:red\">Nu aveti nici o intrebare!</i><br>";
		}
		else
		{
			echo "La care capitol doriti sa stergeti intrebarile?<br>";
			echo "<form action=\"st_teste.php\" method=\"post\">";
			$capitol=mysql_query("SELECT * FROM capitole");
			if(mysql_num_rows($capitol)==0)
				echo "<br><i style=\"margin:4px;color:red\">Nu aveti nici un capitol.</i><br>";
			else
				while($rand=mysql_fetch_row($capitol))
					echo "<br><input type=\"radio\" name=\"radio\" value=\"$rand[0]\">&nbsp $rand[1]<br>";
            echo "<br><i style=\"margin:4px;color:red\">Nu ati selectat nimic!</i><br>";
			echo "<br><span><input class=\"buton\" type=\"submit\" name=\"cont_test\" value=\"Continuati\"></span>";
			echo "</form>";
		}
		echo "<br><br><a href=\"acasa_prof.php\"><span><< Inapoi</span></a>";
	}
	
	@mysql_close($con);
    ?>
</div>
    
</body>
</html>