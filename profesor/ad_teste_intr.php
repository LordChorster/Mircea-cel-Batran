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
	
	$text=@$_POST['submit_int'];
    $nr=@$_POST['numar'];
	$nrcapt=@$_POST['nr_capt'];
	
	if(@$_POST['cont_intr'])
    {
		if($text=='Intrebare' or $text==NULL or $nr==0)
        {
            echo "<form action=\"ad_teste_intr.php\" method=\"post\">
            <input class=\"text\" type=\"text\" name=\"submit_int\" placeholder=\"Intrebare\"><br>
            Cate raspunsuri are intrebarea?
            <input class=\"text\" style=\"width:60px\" type=\"number\" name=\"numar\" value=\"0\" min=\"0\"><br>";
            if($text=='Intrebare' or $text==NULL)
                echo "<i style=\"margin:4px;color:red\">Nu ati completat intrebarea!</i><br><br>";
            if($nr==0)
                echo "<i style=\"margin:4px;color:red\">Nu ati completat cu numarul de raspunsuri!</i><br><br>";
            echo "<span><input class=\"buton\" type=\"submit\" name=\"cont_test\" value=\"Continuati\"></span></form>";
        }
        elseif($text!='Intrebare' and $text!=NULL and $nr>0)
        {
			echo "<form action=\"ad_teste_rasp.php\" method=\"post\">";
			echo "<input type=\"hidden\" name=\"continut\" value=\"$text\">";
			echo "<input type=\"hidden\" name=\"numar_rasp\" value=\"$nr\">";
			echo "<input type=\"hidden\" name=\"numar_capt\" value=\"$nrcapt\">";
            for($r=1;$r<=$nr;$r++)
            {
				echo "<input class=\"text\" type=\"text\" name=\"submit_rasp$r\" placeholder=\"Raspuns $r\">";
				echo "<input type=\"radio\" name=\"radio$r\" value=\"corect\"> corect&nbsp&nbsp";
				echo "<input type=\"radio\" name=\"radio$r\" value=\"incorect\"> incorect<br>";
			}
			echo "<br><span><input class=\"buton\" type=\"submit\" name=\"cont_rasp\" value=\"Continuati\"></span>";
			echo "</form>";
		}
		echo "<br><br><a href=\"acasa_prof.php\"><span><< Inapoi</span></a>";
	}
	    
    @mysql_close($con);
    ?>
</div>
    
</body>
</html>