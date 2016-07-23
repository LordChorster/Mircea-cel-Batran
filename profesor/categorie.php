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
    
   
    
    if(@$_POST['modif_capt'])
    {
		$text=@$_POST['submit_text'];
		$b=@$_FILES["file_b"]["name"];
        $capitol=mysql_query("SELECT * FROM capitole");
        if(mysql_num_rows($capitol))
        {
            echo "Ultimele capitole:<br><br>";
            while($rand=mysql_fetch_row($capitol))
                echo "<li>".$rand[1]."</li><br>";
        }
        if(empty($text)or empty($b))
        {
			if($text==NULL)
				echo "<i style=\"margin:4px;color:red\">Nu ati completat cu numele capitolului!</i><br>";
            if($b==NULL)
				echo "<i style=\"margin:4px;color:red\">Nu ati adaugat fisierul!</i><br>";
			echo "<form action=\"categorie.php\" method=\"post\" enctype=\"multipart/form-data\"><input class=\"text\" type=\"text\" name=\"submit_text\" placeholder=\"Nume capitol\"><br>";
			echo "<br>Adauga bibliografia:<br>";
			echo "<input class=\"text\" type=\"file\" name=\"file_b\">";
			echo "<span><input class=\"buton\" type=\"submit\" name=\"modif_capt\" value=\"Modifica\"></span></form>";
			
        }
        else
        {
            $k=1;
            $capitol=mysql_query("SELECT * FROM capitole");
            while($rand=mysql_fetch_row($capitol))
                if($text==$rand[1])
                    $k=0;
           /*if(!$k)
            {
                echo "<i style=\"margin:4px;color:red\">Capitolul exista!</i><br>";
                echo "<form action=\"categorie.php\" method=\"post\" enctype=\"multipart/form-data\"><input class=\"text\" type=\"text\" name=\"submit_text\" placeholder=\"Nume capitol\"><br>";
				echo "<input class=\"text\" type=\"file\" name=\"file_b\">";
				echo "<span><input class=\"buton\" type=\"submit\" name=\"modif_capt\" value=\"Modifica\"></span></form>";
            }*/
            if($k==1)
            {
				$extensie = pathinfo($b, PATHINFO_EXTENSION);
				if($extensie ==='html' or $extensie==='HTML')
				{
					$insert="INSERT INTO `capitole`(`id-cap`,`nume-cap`) VALUES ('','$text')";
					mysql_query($insert);
					@mkdir("capitole/$text");
					@mkdir("capitole/$text/imagini");
					@mkdir("capitole/$text/teste");
					move_uploaded_file($_FILES["file_b"]["tmp_name"],"capitole/$text/".$b);
					@rename("capitole/$text/".$b,"capitole/$text/bibliografie.html");
					@copy("capitole/$text/bibliografie.html","capitole/$text/bibliografie_elev.html");
					@copy("capitole/index_capitol.php","capitole/$text/index.php");
					@copy("capitole/index_cap_elev.php","capitole/$text/index_elev.php");
					@copy("style.css","capitole/$text/style.css");
					echo "<i style=\"margin:4px;color:red\">Capitolul \"$text\" si bibliografia au fost adaugate!</i><br>";
				}
				else
					echo "<i style=\"margin:4px;color:red\">Acesta nu este fisier html!</i>";
			}
        }
        echo "<br><br><a href=\"acasa_prof.php\"><span><< Inapoi</span></a>";
    }
    elseif(@$_POST['continua'])
    {
        if(isset($_POST['radio']))
        {
            $valoare=@$_POST['radio'];
			$lectie=mysql_query("SELECT `nume-lect` FROM `lectii` WHERE `id-cap`='$valoare'");
			if(mysql_num_rows($lectie))
			{
				echo "Ultimele lectii de la acest capitol:<br><br>";
				while($rand=mysql_fetch_row($lectie))
					echo "<li> ".$rand[0]."</li><br>";
			}
            echo "<form action=\"ad_lectie.php\" method=\"post\" enctype=\"multipart/form-data\">
            <input type=\"hidden\" name=\"nr_capt\" value=\"$valoare\">
            <input class=\"text\" type=\"text\" name=\"submit_text\" placeholder=\"Nume lectie\"><br>
			<input class=\"text\" type=\"file\" name=\"file_lect\">
			<span><input class=\"buton\" type=\"submit\" name=\"modif_lect\" value=\"Modificati\"></span>
            </form>";
        }
        else
        {
            $capitol=mysql_query("SELECT * FROM capitole");
			echo "<form action=\"categorie.php\" method=\"post\">";
            echo "La care capitol doriti sa adaugati lectia?<br><br>";
            while($rand=mysql_fetch_row($capitol))
                echo "<input type=\"radio\" name=\"radio\" value=\"$rand[0]\">&nbsp".$rand[1]."<br>";
            echo "<br><i style=\"margin:4px;color:red\">Nu ati selectat nimic!</i><br>";
            echo "<br><span><input class=\"buton\" type=\"submit\" name=\"continua\" value=\"Continuati\"></span>";
			echo "</form>";
		}
        echo "<br><br><a href=\"acasa_prof.php\"><span><< Inapoi</span></a>";
    }
    elseif(@$_POST['continua_img'])
    {
		$val=@$_POST['radio'];
        if($val=='lectie')
        {
            $capitol=mysql_query("SELECT * FROM capitole");
			$lectie=mysql_query("SELECT * FROM lectii");
			if(mysql_num_rows($capitol)==0)
                echo "<i style=\"margin:4px;color:red\">Nu aveti nici un capitol si nici o lectie pentru a putea adauga o imagine.</i><br>";
            elseif(mysql_num_rows($lectie))
			{
				while($rand=mysql_fetch_row($capitol))
                {
					echo "<li> ".$rand[1].":</li><br>";
					$lectie=mysql_query("SELECT `id-lect`,`nume-lect` FROM `lectii` WHERE `id-cap`='$rand[0]'");
					echo "<form action=\"ad_imagine.php\" method=\"post\">";
					if(mysql_num_rows($lectie))
						while($rand1=mysql_fetch_row($lectie))
							echo "<input type=\"radio\" name=\"radio\" value=\"$rand1[0]\">&nbsp ".$rand1[1]."<br>";
					else
						echo "<i style=\"margin:4px;color:red\">Nu aveti lectii la acest capitol.</i><br>";
				}
				echo "<br><span><input class=\"buton\" type=\"submit\" name=\"continua2_img\" value=\"Continuati\"></span>";
				echo "</form>";
			}
			elseif(mysql_num_rows($lectie)==0)
			{
				echo "<i style=\"margin:4px;color:red\">Nu aveti lectii la aceste capitole pentru a putea adauga imagini:</i><br><br>";
				while($rand=mysql_fetch_row($capitol))
					echo "<li>".$rand[1]."</li><br>";
			}
        }
        elseif($val!='lectie' and $val!=NULL)
        {
			echo "<form action=\"ad_imagine.php\" method=\"post\" enctype=\"multipart/form-data\">
			<input class=\"text\" type=\"file\" name=\"file_img\">";
            echo "<input type=\"hidden\" name=\"val_capt\" value=\"$val\">";
            echo "<span><input class=\"buton\" type=\"submit\" name=\"modif_img\" value=\"Adaugati\"></span>
			</form>";
		}
		else
		{
			echo "<form action=\"categorie.php\" method=\"post\">";
			echo "Unde doriti sa adaugati imginea?<br><br>";
			echo "La un capitol:<br><br>";
            $capitol=mysql_query("SELECT * FROM capitole");
            if(mysql_num_rows($capitol)==0)
                echo "<i style=\"margin:4px;color:red\">Nu aveti nici un capitol pentru a putea adauga o imagine.</i><br>";
            else
				while($rand=mysql_fetch_row($capitol))
					echo "<input type=\"radio\" name=\"radio\" value=\"$rand[0]\">&nbsp ".$rand[1]."<br>";
			echo "<br><input type=\"radio\" name=\"radio\" value=\"lectie\">&nbsp La o lectie specifica unui capitol<br>";
			echo "<br><i style=\"margin:4px;color:red\">Nu ati selectat nimic!</i><br>";
			echo "<br><span><input class=\"buton\" type=\"submit\" name=\"continua_img\" value=\"Continuati\"></span>";
			echo "</form>";
		}
        echo "<br><br><a href=\"acasa_prof.php\"><span><< Inapoi</span></a>";
    }
    elseif(@$_POST['continua_test'])
    {
        $val=@$_POST['radio'];
        if($val=='ev_fin')
        {
			echo "La care capitol doriti sa adaugati intrebarile?<br>";
			echo "<form action=\"ad_teste.php\" method=\"post\">";
			$capitol=mysql_query("SELECT * FROM capitole");
			if(mysql_num_rows($capitol)==0)
				echo "<br><i style=\"margin:4px;color:red\">Nu aveti nici un capitol.</i><br>";
			else
				while($rand=mysql_fetch_row($capitol))
					echo "<br><input type=\"radio\" name=\"radio\" value=\"$rand[0]\">&nbsp $rand[1]<br>";
            echo "<br><span><input class=\"buton\" type=\"submit\" name=\"cont_test\" value=\"Continuati\"></span>";
			echo "</form>";
        }
        elseif($val!='ev_fin' and $val!=NULL)
		{
			echo "<form action=\"ad_teste.php\" method=\"post\" enctype=\"multipart/form-data\">";
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
			echo "<form action=\"categorie.php\" method=\"post\">";
            echo "Ce teste doriti sa adaugati?<br>";
            echo "<br><input type=\"radio\" name=\"radio\" value=\"ev_fin\">&nbsp Teste pentru evaluarea finala<br>";
            echo "<br>Teste pentru o lectie specifica unui capitol:<br><br>";
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
					else
					while($rand1=mysql_fetch_row($lectie))
						echo "<input type=\"radio\" name=\"radio\" value=\"$rand1[0]\">&nbsp ".$rand1[2]."<br>";
				}
            echo "<br><i style=\"margin:4px;color:red\">Nu ati selectat nimic!</i><br>";
            echo "<br><span><input class=\"buton\" type=\"submit\" name=\"continua_test\" value=\"Continuati\"></span>";
			echo "</form>";
		}
        echo "<br><br><a href=\"acasa_prof.php\"><span><< Inapoi</span></a>";
    }
	elseif(@$_POST['modif_scap'])
	{
		if(isset($_POST['radio']))
		{
			$val=@$_POST['radio'];
			$ncapt=mysql_query("SELECT `nume-cap` FROM `capitole` WHERE `id-cap`='$val'");
			$nncapt=mysql_fetch_row($ncapt);
			$nlect=mysql_query("SELECT `nume-lect` FROM `lectii` WHERE `id-cap`='$val'");
			$idl=mysql_query("SELECT `id-lect` FROM `lectii` WHERE `id-cap`='$val'");
			while($r=mysql_fetch_row($idl))
			{
				mysql_query("DELETE FROM `teste` WHERE `id-lect`='$r[0]'");
				mysql_query("DELETE FROM `imagini` WHERE `idl`='$r[0]'");
			}
			$i=mysql_query("SELECT `id-intreb` FROM `intrebari` WHERE `id-cap`='$val'");
			while($r=mysql_fetch_row($i))
				mysql_query("DELETE FROM `raspunsuri` WHERE `id-inreb`='$r[0]'");
			mysql_query("DELETE FROM `intrebari` WHERE `id-cap`='$val'");
			mysql_query("DELETE FROM `imgcapitol` WHERE `idc`='$val'");
			$del="DELETE FROM `capitole` WHERE `id-cap`=$val";
			mysql_query($del);
			$del="DELETE FROM `lectii` WHERE `id-cap`=$val";
			mysql_query($del);
			echo "<i style=\"margin:4px;color:red\">Capitolul \"$nncapt[0]\" a fost sters!</i><br>";
			while($r=mysql_fetch_row($nlect))
			{
				$fisiere = glob("capitole/$nncapt[0]/$r[0]/*"); 
				foreach($fisiere as $fis)
					if(is_file($fis))
						@unlink($fis); 
				@rmdir("capitole/$nncapt[0]/$r[0]");
			}
			$img = glob("capitole/$nncapt[0]/imagini/*"); 
			foreach($img as $fis)
				if(is_file($fis))
					@unlink($fis);
			$teste = glob("capitole/$nncapt[0]/teste/*"); 
			foreach($teste as $fis)
				if(is_file($fis))
					@unlink($fis);
			@rmdir("capitole/$nncapt[0]/imagini");
			@rmdir("capitole/$nncapt[0]/teste");
			$altefis = glob("capitole/$nncapt[0]/*"); 
			foreach($altefis as $fis)
				if(is_file($fis))
					@unlink($fis);
			@rmdir("capitole/$nncapt[0]");
		}
		else
		{
			$capitol=mysql_query("SELECT * FROM capitole");
			echo "Care capitol doriti sa-l stergeti?<br><br>";
			echo "<form action=\"categorie.php\" method=\"post\">";
            while($rand=mysql_fetch_row($capitol))
                echo "<input type=\"radio\" name=\"radio\" value=\"$rand[0]\">&nbsp".$rand[1]."<br>";
			echo "<br><i style=\"margin:4px;color:red\">Nu ati bifat nimic!</i>";
            echo "<br><span><input class=\"buton\" type=\"submit\" name=\"continua_scap\" value=\"Continuati\"></span>";
			echo "</form>";
		}
		echo "<br><br><a href=\"acasa_prof.php\"><span><< Inapoi</span></a>";
	}
	elseif(@$_POST['modif_slec'])
	{
		if(isset($_POST['radio']))
		{
			$val=@$_POST['radio'];
			$nlect=mysql_query("SELECT `id-cap`,`nume-lect` FROM `lectii` WHERE `id-lect`='$val'");
			$nnlect=mysql_fetch_row($nlect);
			$ncapt=mysql_query("SELECT `nume-cap` FROM `capitole` WHERE `id-cap`='$nnlect[0]'");
			$nncapt=mysql_fetch_row($ncapt);
			mysql_query("DELETE FROM `imagini` WHERE `idl`='$val'");
			mysql_query("DELETE FROM `teste` WHERE `idl`='$val'");
			$del="DELETE FROM `lectii` WHERE `id-lect`=$val";
			mysql_query($del);
			echo "<i style=\"margin:4px;color:red\">Lectia \"$nnlect[1]\" din capitolul \"$nncapt[0]\" a fost stearsa!</i><br>";
			$altefis = glob("capitole/$nncapt[0]/$nnlect[1]/*"); 
			foreach($altefis as $fis)
				if(is_file($fis))
					@unlink($fis); 
			@rmdir("capitole/$nncapt[0]/$nnlect[1]");
		}
		else
		{
			echo "Ce lectie doriti sa stergeti?<br><br>";
			echo "<form action=\"categorie.php\" method=\"post\">";
            while($rand=mysql_fetch_row($capitol))
			{
				$lectie=mysql_query("SELECT `id-lect`,`nume-lect` FROM `lectii` WHERE `id-cap`='$rand[0]'");
				if(mysql_num_rows($lectie))
				{
					echo "<li> ".$rand[1]."</li><br>";
					while($rand1=mysql_fetch_row($lectie))
						echo "<input type=\"radio\" name=\"radio\" value=\"$rand1[0]\">&nbsp".$rand1[1]."<br>";
				}
			}
			echo "<i style=\"margin:4px;color:red\">Nu ati bifat nimic!</i><br>";
            echo "<br><span><input class=\"buton\" type=\"submit\" name=\"continua_slec\" value=\"Continuati\"></span>";
			echo "</form>";
		}
		echo "<br><br><a href=\"acasa_prof.php\"><span><< Inapoi</span></a>";
	}
	elseif(@$_POST['modif_simg'])
	{
		$val=@$_POST['radio'];
		if($val=='im_cap')
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
							echo "<th>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<input type=\"radio\" name=\"radio\" value=\"$r1[0]\" style=\"margin-top:5px\"></th></td></tr>";
						}
						echo "</table>";
					}
				}
				echo "<br><br><span><input class=\"buton\" type=\"submit\" name=\"sterg_img1\" value=\"Stergeti\"></span>";
				echo "</form>";
			}
		}
		elseif($val=='im_lect')
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
									echo "<th>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<input type=\"radio\" name=\"radio\" value=\"$r2[0]\" style=\"margin-top:5px\"></th></tr></td>";
								}
								echo "</table>";
							}
							echo "</ol>";
						}
					}
					echo "</ul>";
				}
				echo "<br><span><input class=\"buton\" type=\"submit\" name=\"sterg_img2\" value=\"Stergeti\"></span>";
				echo "</form>";
			}
		}
		else
		{
			echo "Ce imagini doriti sa stergeti?<br><br>";
			echo "<form action=\"categorie.php\" method=\"post\">";
			echo "<input type=\"radio\" name=\"radio\" value=\"im_cap\"> Imaginile de la un capitol<br><br>";
			echo "<input type=\"radio\" name=\"radio\" value=\"im_lect\"> Imaginile de la o lectie specifica unui capitol<br>";
			echo "<br><i style=\"margin:4px;color:red\">Nu ati selectat nimic!</i><br>";
			echo "<br><span><input class=\"buton\" type=\"submit\" name=\"modif_simg\" value=\"Continuati\"></span>";
			echo "</form>";
		}
		echo "<br><br><a href=\"acasa_prof.php\"><span><< Inapoi</span></a>";
	}
	elseif(@$_POST['modif_stest'])
	{
		$val=@$_POST['radio'];
        if($val=='ev_fin')
        {
			echo "La care capitol doriti sa stergeti intrebarile?<br>";
			echo "<form action=\"st_teste.php\" method=\"post\">";
			$capitol=mysql_query("SELECT * FROM capitole");
			if(mysql_num_rows($capitol)==0)
				echo "<br><i style=\"margin:4px;color:red\">Nu aveti nici un capitol.</i><br>";
			else
				while($rand=mysql_fetch_row($capitol))
					echo "<br><input type=\"radio\" name=\"radio\" value=\"$rand[0]\">&nbsp $rand[1]<br>";
            echo "<br><span><input class=\"buton\" type=\"submit\" name=\"cont_test\" value=\"Continuati\"></span>";
			echo "</form>";
        }
        elseif($val!='ev_fin' and $val!=NULL)
		{
			$idcap=mysql_query("SELECT `id-cap` FROM `lectii` WHERE `nume-lect`='$val'");
			$idcap=mysql_fetch_row($idcap);
			$ncap=mysql_query("SELECT `nume-cap` FROM `capitole` WHERE `id-cap`='$idcap[0]'");
			$ncap=mysql_fetch_row($ncap);
			$idl=mysql_query("SELECT `id-lect` FROM `lectii` WHERE `nume-lect`='$val'");
			$idl=mysql_fetch_row($idl);
			$ntest=mysql_query("SELECT `test` FROM `teste` WHERE `id-lect`='$idl[0]'");
			$nhtml=mysql_query("SELECT `html` FROM `teste` WHERE `id-lect`='$idl[0]'");
			while($r=mysql_fetch_row($ntest))
				@unlink("capitole/$ncap[0]/teste/$r[0]");
			while($r=mysql_fetch_row($nhtml))
			{
				$n=basename("capitole/$ncap[0]/teste/$r[0]",".html");
				@unlink("capitole/$ncap[0]/teste/$r[0]");
				@unlink("capitole/$ncap[0]/teste/".$n."_elev.html");
			}
			mysql_query("DELETE FROM `teste` WHERE `id-lect`='$idl[0]'");
        }
		else
        {
			echo "<form action=\"categorie.php\" method=\"post\">";
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
					else
					while($rand1=mysql_fetch_row($lectie))
						echo "<input type=\"radio\" name=\"radio\" value=\"$rand1[0]\">&nbsp ".$rand1[2]."<br>";
				}
            echo "<br><i style=\"margin:4px;color:red\">Nu ati selectat nimic!</i><br>";
            echo "<br><span><input class=\"buton\" type=\"submit\" name=\"modif_stest\" value=\"Continuati\"></span>";
			echo "</form>";
		}
        echo "<br><br><a href=\"acasa_prof.php\"><span><< Inapoi</span></a>";
	}
    
    @mysql_close($con);
    ?>
</div>

</body>
</html>