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
    
    $text=@$_POST['submit_text'];
	$valoare=@$_POST['nr_capt'];
	$fisier=@$_FILES["file_lect"]["name"];
    
    if(@$_POST['modif_lect'])
    {
        if($text==NULL or $fisier==NULL)
        {
			$lectie=mysql_query("SELECT `nume-lect` FROM `lectii` WHERE `id-cap`='$valoare'");
			if(mysql_num_rows($lectie))
			{
				echo "Ultimele lectii de la acest capitol:<br><br>";
				while($rand=mysql_fetch_row($lectie))
					echo "<li> ".$rand[0]."</li><br>";
			}
			if($text==NULL)
				echo "<i style=\"margin:4px;color:red\">Nu ati completat capitolul cu o lectie!</i><br>";
            if($fisier==NULL)
				echo "<i style=\"margin:4px;color:red\">Nu ati adaugat fisierul!</i><br>";
			echo "<form action=\"ad_lectie.php\" method=\"post\" enctype=\"multipart/form-data\">
            <input type=\"hidden\" name=\"nr_capt\" value=\"$valoare\">
            <input class=\"text\" type=\"text\" name=\"submit_text\" placeholder=\"Nume lectie\"><br>
			<input class=\"text\" type=\"file\" name=\"file_lect\">
			<span><input class=\"buton\" type=\"submit\" name=\"modif_lect\" value=\"Modificati\"></span>
            </form>";
        }
        elseif($text!=NULL or $fisier!=NULL)
        {
            $k=1;
            $lectie=mysql_query("SELECT * FROM lectii");
            while($rand=mysql_fetch_row($lectie))
                if($text==$rand[2])
                    $k=0;
            if(!$k)
            {
				$lectie=mysql_query("SELECT `nume-lect` FROM `lectii` WHERE `id-cap`='$valoare'");
				if(mysql_num_rows($lectie))
				{
					echo "Ultimele lectii de la acest capitol:<br><br>";
					while($rand=mysql_fetch_row($lectie))
						echo "<li> ".$rand[0]."</li><br>";
				}
                echo "<i style=\"margin:4px;color:red\">Lectia exista!</i><br>";
            }
            else
            {
				$extensie = pathinfo($fisier, PATHINFO_EXTENSION);
				if( $extensie === 'html' or $extensie === 'htm')
				{
					$insert="INSERT INTO `lectii`(`id-lect`,`id-cap`,`nume-lect`) VALUES ('','$valoare','$text')";
					mysql_query($insert);
					$ncapt=mysql_query("SELECT `nume-cap` FROM `capitole` WHERE `id-cap`='$valoare'");
					$nncapt=mysql_fetch_row($ncapt);
					@mkdir("capitole/$nncapt[0]/$text");
					$loc="capitole/$nncapt[0]/$text/".$fisier;
					move_uploaded_file($_FILES["file_lect"]["tmp_name"], $loc);
					echo "<i style=\"margin:4px;color:red\">Lectia \"$text\" din capitolul \"$nncapt[0]\" a fost adaugata!</i><br>";
					@rename("capitole/$nncapt[0]/$text/".$fisier,"capitole/$nncapt[0]/$text/$text.html");
					@copy("capitole/$nncapt[0]/$text/$text.html","capitole/$nncapt[0]/$text/".$text."_elev.html");
				}
				else
					echo "<i style=\"margin:4px;color:red\">Fisierul nu a putut fi adaugat!</i><br>";
            }
        }
        echo "<br><br><a href=\"acasa_prof.php\"><span><< Inapoi</span></a>";
    }
    
    @mysql_close($con);
    ?>
</div>
    
</body>
</html>