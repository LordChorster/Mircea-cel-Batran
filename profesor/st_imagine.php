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
	
	if(@$_POST['sterg_img1'])
	{
		$val=@$_POST['radio'];
		if($val)
		{
			$icap=mysql_query("SELECT `idc` FROM `imgcapitol` WHERE `idim`='$val'");
			$icap=mysql_fetch_row($icap);
			$numecap=mysql_query("SELECT `nume-cap` FROM `capitole` WHERE `id-cap`='$icap[0]'");
			$numecap=mysql_fetch_row($numecap);
			$numeimg=mysql_query("SELECT `nume-img` FROM `imgcapitol` WHERE `idim`='$val'");
			$numeimg=mysql_fetch_row($numeimg);
			@unlink("capitole/$numecap[0]/imagini/$numeimg[0]");
			mysql_query("DELETE FROM `imgcapitol` WHERE `idim`='$val'");
			echo "<i style=\"margin:4px;color:red\">Imaginea s-a sters!</i>";
		}
		else
		{
			echo "Selectati imaginea pe care doriti sa o stergeti:<br>";
			$capitol=mysql_query("SELECT * FROM capitole");
			if(mysql_num_rows($capitol)==0)
                echo "<i style=\"margin:4px;color:red\">Nu aveti nici un capitol pentru a putea fi stearsa o imagine.</i><br>";
			else
			{
				while($rand=mysql_fetch_row($capitol))
                {
					echo "<br><li><h4> Capitolul \"".$rand[1]."\" cu imaginile:</h4></li><br>";
					$im=mysql_query("SELECT `idim`,`nume-img` FROM `imgcapitol` WHERE `idc`='$rand[0]'");
					if(mysql_num_rows($im)==0)
						echo "<i style=\"margin:4px;color:red\">Nu aveti imagini la acest capitol.</i><br>";
					else
					{
						echo "<form action=\"st_imagine.php\" method=\"post\">";
						echo "<table>";
						while($r1=mysql_fetch_row($im))
						{
							echo "<tr><td><img src=\"capitole/$rand[1]/imagini/$r1[1]\" width=\"80px\" height=\"auto\"/>";
							echo "<th>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<input type=\"radio\" name=\"radio\" value=\"$r1[0]\" style=\"margin-top:5px\"></th></td></tr>";
						}
						echo "</table>";
					}
				}
				echo "<br><br><i style=\"margin:4px;color:red\">Nu ati selectat nimic!</i>";
				echo "<br><br><span><input class=\"buton\" type=\"submit\" name=\"sterg_img1\" value=\"Stergeti\"></span>";
				echo "</form>";
			}
		}
	}
	elseif(@$_POST['sterg_img2'])
	{
		$val=@$_POST['radio'];
		if($val)
		{
			$il=mysql_query("SELECT `idl` FROM `imagini` WHERE `idim`='$val'");
			$il=mysql_fetch_row($il);
			$icap=mysql_query("SELECT `id-cap` FROM `lectii` WHERE `id-lect`='$il[0]'");
			$icap=mysql_fetch_row($icap);
			$numecap=mysql_query("SELECT `nume-cap` FROM `capitole` WHERE `id-cap`='$icap[0]'");
			$numecap=mysql_fetch_row($numecap);
			$numeimg=mysql_query("SELECT `nume-img` FROM `imagini` WHERE `idim`='$val'");
			$numeimg=mysql_fetch_row($numeimg);
			@unlink("capitole/$numecap[0]/imagini/$numeimg[0]");
			mysql_query("DELETE FROM `imagini` WHERE `idim`='$val'");
			echo "<i style=\"margin:4px;color:red\">Imaginea s-a sters!</i>";
		}
		else
		{
			echo "Selectati imaginea pe care doriti sa o stergeti:<br>";
			$capitol=mysql_query("SELECT * FROM capitole");
			if(mysql_num_rows($capitol)==0)
                echo "<i style=\"margin:4px;color:red\">Nu aveti nici un capitol pentru a putea fi stearsa o imagine.</i><br>";
			else
			{
				while($rand=mysql_fetch_row($capitol))
                {
					echo "<br><ul><li><h4> Capitolul \"".$rand[1]."\":</h4></li><br>";
					$lectie=mysql_query("SELECT `id-lect`,`nume-lect` FROM `lectii` WHERE `id-cap`='$rand[0]'");
					if(mysql_num_rows($lectie)==0)
						echo "<i style=\"margin:4px;color:red\">Nu aveti lectii la acest capitol.</i><br>";
					else
					{
						while($rand1=mysql_fetch_row($lectie))
						{
							echo "<form action=\"st_imagine.php\" method=\"post\">";
							echo "<ol><li>Lectia \"".$rand1[1]."\" cu imaginile:</li>";
							$im=mysql_query("SELECT `idim`,`nume-img` FROM `imagini` WHERE `idl`='$rand1[0]'");
							if(mysql_num_rows($im)==0)
								echo "<i style=\"margin:4px;color:red\">Nu aveti imagini la aceasta lectie.</i><br><br>";
							else
							{
								echo "<table>";
								while($r2=mysql_fetch_row($im))
								{
									echo "<tr><td><img src=\"capitole/$rand[1]/imagini/$r2[1]\" width=\"80px\" height=\"auto\"/>";
									echo "<th>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<input type=\"radio\" name=\"radio\" value=\"$r2[0]\" style=\"margin-top:5px\"></th></td></tr>";
								}
								echo "</table>";
							}
							echo "</ol>";
						}
					}
					echo "</ul>";
				}
				echo "<br><i style=\"margin:4px;color:red\">Nu ati selectat nimic!</i>";
				echo "<br><span><input class=\"buton\" type=\"submit\" name=\"sterg_img2\" value=\"Stergeti\"></span>";
				echo "</form>";
			}
		}
	}
	echo "<br><br><a href=\"acasa_prof.php\"><span><< Inapoi</span></a>";
	
	@mysql_close($con);
    ?>
</div>

</body>
</html>