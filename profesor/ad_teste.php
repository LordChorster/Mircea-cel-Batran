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
		if(isset($_POST['radio']))
		{
			$val=@$_POST['radio'];
			echo "<form action=\"ad_teste_intr.php\" method=\"post\">";
			echo "<input type=\"hidden\" name=\"nr_capt\" value=\"$val\">";
			echo "<input class=\"text\" type=\"text\" name=\"submit_int\" placeholder=\"Intrebare\"><br>
            Cate raspunsuri are intrebarea?
            <input class=\"text\" style=\"width:60px\" type=\"number\" name=\"numar\" value=\"0\" min=\"0\"><br><br>";
			echo "<span><input class=\"buton\" type=\"submit\" name=\"cont_intr\" value=\"Continuati\"></span>";
			echo "</form>";
		}
		else
		{
			echo "La care capitol doriti sa adaugati intrebarile?<br>";
			echo "<form action=\"ad_teste.php\" method=\"post\">";
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
	elseif(@$_POST['modif_test_lectie'])
	{
		$val=@$_POST['id-lect'];
		$nume=$_FILES["file_test"]["name"];
		$numeh=$_FILES["file_html"]["name"];
		if($nume==NULL or $numeh==NULL)
		{
			echo "<form action=\"ad_teste.php\" method=\"post\" enctype=\"multipart/form-data\">";
			if($nume==NULL and $numeh==NULL)
				echo "<i style=\"margin:4px;color:red\">Nu ati incarcat nici un fisier!</i><br>";
			elseif($nume==NULL)
				echo "<i style=\"margin:4px;color:red\">Nu ati incarcat fisierul swf!</i><br>";
			elseif($numeh==NULL)
				echo "<i style=\"margin:4px;color:red\">Nu ati incarcat fisierul html!</i><br>";
			echo "Incarca fisier swf:<br>";
			echo "<input class=\"text\" type=\"file\" name=\"file_test\"><br>";
			echo "<br>Incarca fisier html:<br>"; 
			echo "<input class=\"text\" type=\"file\" name=\"file_html\">";
			echo "<input type=\"hidden\" name=\"id-lect\" value=\"$val\">";
			echo "<span><input class=\"buton\" type=\"submit\" name=\"modif_test_lectie\" value=\"Modifica\"></span>";
            echo "</form>";
		}
		else
		{
			$extensie = pathinfo($nume, PATHINFO_EXTENSION);
			$extensie1= pathinfo($numeh, PATHINFO_EXTENSION);
			if( $extensie === 'swf' and ($extensie1=== 'html' or $extensie1==='htm') )
			{
				$idcap=mysql_query("SELECT `id-cap` FROM `lectii` WHERE `id-lect`='$val'");
				$idcap=mysql_fetch_row($idcap);
				$numecapt=mysql_query("SELECT `nume-cap` FROM `capitole` WHERE `id-cap`='$idcap[0]'");
				$numecapt=mysql_fetch_row($numecapt);
				$numelect=mysql_query("SELECT `nume-lect` FROM `lectii` WHERE `id-lect`='$val'");
				$numelect=mysql_fetch_row($numelect);
				$loc="capitole/$numecapt[0]/teste/";
				move_uploaded_file($_FILES["file_test"]["tmp_name"], $loc.$nume);
				move_uploaded_file($_FILES["file_html"]["tmp_name"], $loc.$numeh);
				echo "<i style=\"margin:4px;color:red\">Fisierele au fost adaugate!</i>";
				$n=basename($loc.$numeh,".html");
				@copy("capitole/$numecapt[0]/teste/".$numeh,"capitole/$numecapt[0]/teste/".$n."_elev.html");
				mysql_query("LOCK TABLES teste WRITE");
				$insert="INSERT INTO `teste`(`id-lect`,`test`,`html`) VALUES ('$val','$nume','$numeh')";
				mysql_query($insert);
				mysql_query("UNLOCK TABLES");
			}
			elseif($extensie !== 'swf')
				echo "<i style=\"margin:4px;color:red\">Fisierul swf nu a fost adaugat!</i>";
			elseif($extensie1!== 'html')
				echo "<i style=\"margin:4px;color:red\">Fisierul html nu a fost adaugat!</i>";
		}
		echo "<br><br><a href=\"acasa_prof.php\"><span><< Inapoi</span></a>";
	}
    
    @mysql_close($con);
    ?>
</div>
    
</body>
</html>