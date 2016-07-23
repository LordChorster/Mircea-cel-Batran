<?php
session_start();
$domeniu=@$_POST['domeniu'];
$password=@$_POST['parr'];
$password1=@$_POST['parr1'];
$submit=@$_POST['submit'];
if($submit)
    if ($domeniu=="profesor")
    {
		$con=@mysql_connect("localhost","root","")
		or die("nu");
        mysql_select_db("profesor");
		$par=mysql_query("SELECT parola FROM utilizator WHERE user='profesor'");
		$r=mysql_fetch_row($par);
        if(!$password)
        {
            echo "<!DOCTYPE html><html><body>";
            echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"design_index.css\">";
            echo "<title>Pagina de logare</title>";
            echo "<div class=\"chenar\">";
            echo "Va rog sa introduceti parola!";
            echo "<br><br><a href=\"login.html\"><span><< Inapoi</span></a>";
            echo "</div>";
            echo "</body></html>";
        }
        elseif(md5($password)!=$r[0])
        {
            echo "<!DOCTYPE html><html><body>";
            echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"design_index.css\">";
            echo "<title>Pagina de logare</title>";
            echo "<div class=\"chenar\">";
            echo "Parola este gresita!";
            echo "<br><br><a href=\"login.html\"><span><< Inapoi</span></a>";
            echo "</div>";
            echo "</body></html>";
        }
        elseif(md5($password)==$r[0])
        {
			$_SESSION['domeniu']=$domeniu;
			$_SESSION['password']=$password;
            echo "<!DOCTYPE html><html><body>";
            echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"design_index.css\">";
            echo "<title>Pagina de logare</title>";
            echo "<div class=\"chenar\">";
            echo "Bine ati sosit pe site-ul nostru. Acest site va permite sa acumulati cunostinte despre istoria domnitorilor romani. De asemenea, acesta permite un acces rapid la o interfata vizuala ce ajuta la o mai buna intelegere a informatiilor.";
            echo "<br><a href=\"profesor\acasa_prof.php\"><span>Accesati pagina</span></a>";
            echo "</div>";
            echo "</body></html>";
        }
		@mysql_close($con);
    }
    elseif($domeniu=="elev")
    {
    	$con=@mysql_connect("localhost","root","");
        mysql_select_db("profesor");
		$par=mysql_query("SELECT parola FROM utilizator WHERE user='elev'");
		$r=mysql_fetch_row($par);
		if(!$password1)
        {
            echo "<!DOCTYPE html><html><body>";
            echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"design_index.css\">";
            echo "<title>Pagina de logare</title>";
            echo "<div class=\"chenar\">";
            echo "Va rog sa introduceti parola!";
            echo "<br><br><a href=\"login.html\"><span><< Inapoi</span></a>";
            echo "</div>";
            echo "</body></html>";
        }
        elseif(md5($password1)!=$r[0])
        {
            echo "<!DOCTYPE html><html><body>";
            echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"design_index.css\">";
            echo "<title>Pagina de logare</title>";
            echo "<div class=\"chenar\">";
            echo "Parola este gresita!";
            echo "<br><br><a href=\"login.html\"><span><< Inapoi</span></a>";
            echo "</div>";
            echo "</body></html>";
        }
        elseif(md5($password1)==$r[0])
        {
			$_SESSION['domeniu']=$domeniu;
			$_SESSION['password']=$password1;
            echo "<!DOCTYPE html><html><body>";
            echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"design_index.css\">";
            echo "<title>Pagina de logare</title>";
            echo "<div class=\"chenar\">";
            echo "Bine ati sosit pe site-ul nostru. Acest site va permite sa acumulati cunostinte despre istoria domnitorilor romani. De asemenea, acesta permite un acces rapid la o interfata vizuala ce ajuta la o mai buna intelegere a informatiilor.";
            echo "<br><a href=\"profesor\capitole\index_elev.php\"><span>Accesati pagina</span></a>";
            echo "</div>";
            echo "</body></html>";
        }
		@mysql_close($con);
    }
    else 
        {
            echo "<!DOCTYPE html><html><body>";
            echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"design_index.css\">";
            echo "<title>Pagina de logare</title>";
            echo "<div class=\"chenar\">";
            echo "Alegeti o categorie!<br><br><a href=\"login.html\"><span><< Inapoi</span></a>";
            echo "</div>";
            echo "</body></html>";
        }
?>     