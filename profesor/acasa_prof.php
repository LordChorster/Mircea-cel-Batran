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

<style>
body .buton a {
	text-decoration:none;
	color:maroon;
	background-color:white;
	border:5px solid white;
	padding:3px;
	border-radius:10px;
	-webkit-border-radius:10px;
	-moz-border-radius:10px;
}
body .buton :hover {
	border-color:rgba(158, 20, 20, 0.7);
}
</style>
      
<body>

<header>
<h1>Bine ati venit domnule profesor!</h1>
<br><span><a href="logout.php">Deconecteaza-te</a></span>
</header>

    
<div class="rotund">
    <?php
    $capt=@$_POST['submit_ad'];
    $lect=@$_POST['submit_lect'];
    $subimg=@$_POST['submit_img'];
    $teste=@$_POST['submit_test'];
    
    $st_titlu=@$_POST['submit_stit'];
    $st_capt=@$_POST['submit_st'];
    $st_lect=@$_POST['submit_slect'];
    $st_img=@$_POST['submit_simg'];
    $st_test=@$_POST['submit_stest'];
    
    if($capt or $lect or $subimg or $teste or $st_titlu or $st_capt or $st_lect or $st_img or $st_test )
    {
        echo "<form action=\"categorie.php\" method=\"post\" enctype=\"multipart/form-data\">";
        include 'conectare.php';
   		if($capt)
        {
            $capitol=mysql_query("SELECT * FROM capitole");
            if(mysql_num_rows($capitol))
            {
                echo "Ultimele capitole:<br><br>";
                while($rand=mysql_fetch_row($capitol))
                    echo "<li>".$rand[1]."</li><br>";
            }
            echo "<input class=\"text\" type=\"text\" name=\"submit_text\" placeholder=\"Nume capitol\"><br>";
			echo "<br>Adauga bibliografia:<br>";
			echo "<input class=\"text\" type=\"file\" name=\"file_b\">";
			echo "<span><input class=\"buton\" type=\"submit\" name=\"modif_capt\" value=\"Modifica\"></span>";
        }
        elseif($lect)
        {
            $capitol=mysql_query("SELECT * FROM capitole");
            if(mysql_num_rows($capitol)==0)
                echo "<i style=\"margin:4px;color:red\">Imi pare rau, nu aveti nici un capitol.</i>";
            else
            {
                echo "La care capitol doriti sa adaugati lectia?<br><br>";
                while($rand=mysql_fetch_row($capitol))
                    echo "<input type=\"radio\" name=\"radio\" value=\"$rand[0]\">&nbsp".$rand[1]."<br>";
                echo "<br><span><input class=\"buton\" type=\"submit\" name=\"continua\" value=\"Continuati\"></span>";
            }
        }
        elseif($subimg)
        {
			echo "Unde doriti sa adaugati imginea?<br><br>";
			echo "La un capitol:<br><br>";
            $capitol=mysql_query("SELECT * FROM capitole");
            if(mysql_num_rows($capitol)==0)
                echo "<i style=\"margin:4px;color:red\">Nu aveti nici un capitol pentru a putea adauga o imagine.</i><br>";
            else
				while($rand=mysql_fetch_row($capitol))
                	echo "<input type=\"radio\" name=\"radio\" value=\"$rand[0]\">&nbsp ".$rand[1]."<br>";
				echo "<br><input type=\"radio\" name=\"radio\" value=\"lectie\">&nbsp La o lectie specifica unui capitol<br>";
				echo "<br><span><input class=\"buton\" type=\"submit\" name=\"continua_img\" value=\"Continuati\"></span>";
        }
        elseif($teste)
        {
            echo "Ce teste doriti sa adaugati?<br>";
            echo "<br><input type=\"radio\" name=\"radio\" value=\"ev_fin\">&nbsp Teste pentru evaluarea finala<br>";
			echo "<br>Teste pentru o lectie specifica unui capitol:<br><br>";
            $capitol=mysql_query("SELECT * FROM capitole");
            if(mysql_num_rows($capitol)==0)
                echo "<i style=\"margin:4px;color:red\">Imi pare rau, nu aveti nici un capitol.</i><br>";
            else
                while($rand=mysql_fetch_row($capitol))
                {
					echo "<li><h4> ".$rand[1]."</h4></li><br>";
					$lectie=mysql_query("SELECT * FROM lectii WHERE `id-cap`='$rand[0]'");
					if(mysql_num_rows($lectie)==0)
						echo "<i style=\"margin:4px;color:red\">Nu aveti nici o lectie la acest capitol.</i><br>";
					while($rand1=mysql_fetch_row($lectie))
						echo "<input type=\"radio\" name=\"radio\" value=\"$rand1[0]\">&nbsp ".$rand1[2]."<br>";
					echo "<br>";
				}
            echo "<br><span><input class=\"buton\" type=\"submit\" name=\"continua_test\" value=\"Continuati\"></span>";
        }
        elseif($st_capt)
        {
            $capitol=mysql_query("SELECT * FROM capitole");
            if(mysql_num_rows($capitol)==0)
                echo "<i style=\"margin:4px;color:red\">Imi pare rau, nu aveti nici un capitol.</i>";
            else
            {
                echo "Care capitol doriti sa-l stergeti?<br><br>";
                while($rand=mysql_fetch_row($capitol))
                    echo "<input type=\"radio\" name=\"radio\" value=\"$rand[0]\">&nbsp".$rand[1]."<br>";
                echo "<br><span><input class=\"buton\" type=\"submit\" name=\"modif_scap\" value=\"Continuati\"></span>";
            }
        }
        elseif($st_lect)
        {
            $capitol=mysql_query("SELECT * FROM capitole");
			$lectie=mysql_query("SELECT * FROM lectii");
            if(mysql_num_rows($capitol)==0)
                echo "<i style=\"margin:4px;color:red\">Imi pare rau, nu aveti nici o lectie si nici un capitol.</i><br>";
            elseif(mysql_num_rows($lectie))
            {
				echo "Ce lectie doriti sa stergeti?<br><br>";
                while($rand=mysql_fetch_row($capitol))
				{
					echo "<li> ".$rand[1]."</li><br>";
					$lectie=mysql_query("SELECT `id-lect`,`nume-lect` FROM `lectii` WHERE `id-cap`='$rand[0]'");
					if(mysql_num_rows($lectie)==0)
						echo "<i style=\"margin:4px;color:red\">Imi pare rau, nu aveti nici o lectie la acest capitol:</i><br>";
					else	
						while($rand1=mysql_fetch_row($lectie))
							echo "<input type=\"radio\" name=\"radio\" value=\"$rand1[0]\">&nbsp".$rand1[1]."<br>";
				}
				echo "<br><span><input class=\"buton\" type=\"submit\" name=\"modif_slec\" value=\"Continuati\"></span>";
			}
			elseif(mysql_num_rows($lectie)==0)
			{
				echo "<i style=\"margin:4px;color:red\">Nu aveti lectii care pot fi sterse la aceste capitole:</i><br><br>";
				while($rand=mysql_fetch_row($capitol))
					echo "<li>".$rand[1]."</li><br>";
			}
        }
        elseif($st_img)
        {
			echo "Ce imagini doriti sa stergeti?<br><br>";
			echo "<form action=\"categorie.php\" method=\"post\">";
			echo "<input type=\"radio\" name=\"radio\" value=\"im_cap\"> Imaginile de la un capitol<br><br>";
			echo "<input type=\"radio\" name=\"radio\" value=\"im_lect\"> Imaginile de la o lectie specifica unui capitol<br>";
			echo "<br><span><input class=\"buton\" type=\"submit\" name=\"modif_simg\" value=\"Continuati\"></span>";
			echo "</form>";
        }
        elseif($st_test)
        {
            echo "Ce teste doriti sa stergeti?<br>";
            echo "<br><input type=\"radio\" name=\"radio\" value=\"ev_fin\">&nbsp Teste de la evaluarea finala<br>";
			echo "<br>Teste de la o lectie specifica unui capitol:<br><br>";
            $capitol=mysql_query("SELECT * FROM capitole");
            if(mysql_num_rows($capitol)==0)
                echo "<i style=\"margin:4px;color:red\">Imi pare rau, nu aveti nici un capitol.</i><br>";
            else
                while($rand=mysql_fetch_row($capitol))
                {
					echo "<li> ".$rand[1]."</li><br>";
					$lectie=mysql_query("SELECT * FROM lectii");
					if(mysql_num_rows($lectie)==0)
						echo "<i style=\"margin:4px;color:red\">Nu aveti nici o lectie la acest capitol.</i><br>";
					while($rand1=mysql_fetch_row($lectie))
						echo "<input type=\"radio\" name=\"radio\" value=\"$rand1[2]\">&nbsp ".$rand1[2]."<br>";
				}
            echo "<br><span><input class=\"buton\" type=\"submit\" name=\"modif_stest\" value=\"Continuati\"></span>";
        }
        @mysql_close($con);
        echo "<br><br><a href=\"acasa_prof.php\"><span><< Inapoi</span></a>";
        echo "</form>";
    }
    else echo "<h4>Alegeti ce doriti sa efectuati:</h4><br>
    
    <form action=\"capitole/index.php\" method=\"post\">
     <div class=\"vizualizare\">
      <span><input class=\"buton1\" type=\"submit\" name=\"viz_lect\" value=\"Vizualizare lectii\"></span><br>
     </div>
     </form>
     
     <form action=\"acasa_prof.php\" method=\"post\">
    <div class=\"adaugare\">
    <span><input class=\"buton\" type=\"submit\" name=\"submit_ad\" value=\"Adauga capitol\"></span><br>
    <span><input class=\"buton\" type=\"submit\" name=\"submit_lect\" value=\"Adauga lectie\"></span><br>
    <span><input class=\"buton\" type=\"submit\" name=\"submit_img\" value=\"Adauga imagine\"></span><br>
    <span><input class=\"buton\" type=\"submit\" name=\"submit_test\" value=\"Adauga teste\"></span>
    </div>
    
    <div class=\"stergere\">
    <span><input class=\"buton\" type=\"submit\" name=\"submit_st\" value=\"Sterge capitol\"></span><br>
    <span><input class=\"buton\" type=\"submit\" name=\"submit_slect\" value=\"Sterge lectie\"></span><br>
    <span><input class=\"buton\" type=\"submit\" name=\"submit_simg\" value=\"Sterge imagine\"></span><br>
    <span><input class=\"buton\" type=\"submit\" name=\"submit_stest\" value=\"Sterge teste\"></span>
    </div>
    </form>";
    ?>
</div>
    
</body>
</html>