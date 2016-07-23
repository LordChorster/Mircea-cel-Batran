<?php
include '../autentificare.php';
?>

<!DOCTYPE html>
<html>

<?php
include '../conectare.php';
$ncapt=$_SESSION['numecap'];
?>

<head>
<link rel="stylesheet" type="text/css" href="style.css">
<link rel="stylesheet" type="text/css" href="../style_prof.css">
<title><?php echo $ncapt; ?></title>
</head>
<style>
body .ac {
	border:2px solid rgba(158, 20, 20, 1);
	-webkit-border-radius: 100px;
	-moz-border-radius: 100px;
	border-radius: 100px;
	float:right;
	margin:20px 20px 0 5px;
	padding:10px;
	color:rgba(158, 20, 20, 1);
	text-decoration:none;
	background-color:rgba(158, 20, 20, 0.1);
}
body span :hover {
	color:rgba(158, 20, 20, 0.8);
	border:2px solid rgba(158, 20, 20, 0.5);
	background-color:rgba(158, 20, 20, 0.05);
}
</style>
<body>

<header>
<h1><?php echo $ncapt; ?></h1>
<span><br><br><a href="../logout.php" style="margin-left:20px">Deconecteaza-te</a></span>
</header>

<?php
$d=$_SESSION['domeniu'];
if($d=='profesor')
	echo "<span><a class=\"ac\" href=\"index.php\">Acasa</a></span>";
elseif($d=='elev')
	echo "<span><a class=\"ac\" href=\"index_elev.php\">Acasa</a></span>";
?>
<section>
<?php
if($d=='profesor')
	echo "<a href=\"../acasa_prof.php\" title=\"Panou de administrare\"><img src=\"imagini/admin.png\" width=\"40px\" style=\"float:left;margin-left:10px;margin-top:15px;\"/></a>";
?>
<div class="intrasp">

<?php
if(isset($_POST['trimite2']))
{
?>

<table  border="0"   cellpadding="2" cellspacing="2">
<?php
for($r=1;$r<=6;$r++)
{
	$idin=$_POST['intreb'.$r];
	//echo $idin." ";
	$rez1=@mysql_query("SELECT * FROM intrebari WHERE `id-intreb`='$idin'");
	$rand1=@mysql_fetch_array($rez1,MYSQL_NUM); 
	$testi=$rand1[2];
	echo"<tr><td><br><div class=\"cifre\"><b>$r</b></div>&nbsp;&nbsp;&nbsp;&nbsp;</td><td>$testi</td></tr>";
	$rasp1=@mysql_query("SELECT * FROM raspunsuri WHERE `id-intreb`='$idin' and corect=1");
	$nr_rasp=@mysql_num_rows($rasp1);
	for($i=1;$i<=$nr_rasp;$i++)
	{
		$rr1=@mysql_fetch_array($rasp1,MYSQL_NUM); 
		$testrasp=$rr1[2];
		//echo $testrasp;
		echo"<tr><td>&nbsp;</td><td><div class=\"corect\">&nbsp;&nbsp;&nbsp;<b>$testrasp</b></div></td></tr>";
	}
}
echo "<tr><td colspan='2'><form action=\"teste.php\">";
echo "<input class='buton1' type='submit' name='trimite3' value='REIA TESTUL'>";
echo "</form></td></tr>";
}
else
{
if(isset($_POST['trimite1']))
  { $punct_max=$_POST['punct_max'];
    $punctaj=0;
    $i=$_POST['numar'];   
    $p=0;
    for($j=1;$j<=$i-1;$j++)
      {if(isset($_POST['del'.$j])){
         $a=$_POST['del'.$j];
	 	$punctaj=$punctaj+$a;
         $p++;
			}
       }   
		if($punctaj==0)
			echo "<div class=\"punctaj\"><b>Îmi pare rău, ai obţinut ".$punctaj." din ".$punct_max.".<br><br>&nbsp;&nbsp;&nbsp;Poate data viitoare vei şti mai multe şi vei obţine punctajul maxim.</b><br></div>";
		else 
			if($punctaj<=$punct_max/2)
			echo "<div class=\"punctaj\"><b>Ai obţinut $punctaj puncte din $punct_max.<br><br>Încearcă să înveţi mai mult ca să obţii un punctaj mai mare.</b></div>";
			else 
				if($punctaj>$punct_max/2)
					echo "<div class=\"punctaj\"><b>Ai obţinut $punctaj puncte din $punct_max.<br><br>Te-ai descurcat destul de bine.</b></div>";
				else echo "<div class=\"punctaj\"><b>Felicitări!<br><br>Ai obţinut punctajul maxim.<br><br>Te-ai descurcat foarte bine!<br><br>Punctajul tău : ".$punctaj." din " .$punct_max."</b></div>";
		for($r=1;$r<=6;$r++)
		{
			$tab[$r]=$_POST['intreb'.$r];
			//echo "<input type='hidden' name='intreb$r' value=$tab4[$r]>"; 
		}
		
	?>
	<form method='post' action='teste.php'>
	<?php
		for($r=1;$r<=6;$r++)
		{
			echo "<input type='hidden' name='intreb$r' value=$tab[$r]>";
		}
	//echo "<a href=\"teste.php\" style=\"margin-left:100px\">Resetare test</a>";
	echo "<div class=\"butoo\"><input class='buton1' type='submit' name='trimite2' value='VERIFICĂ-TE'>
	<input class='buton1' type='submit' name='trimite3' value='REIA TESTUL'>
	<div></form> ";
  }
else
{
	$v=1;
?>
<table  border="0"   cellpadding="2" cellspacing="2">
<form method='post' action='teste.php'>
   	<?php
		$ss=1;
		$punct=0;
		$cap1=$_SESSION['cap'];
		
        $rez1=mysql_query("SELECT * FROM intrebari WHERE `id-cap`='$cap1'" );
        $nr_rand1=@mysql_num_rows($rez1);  
               
		for($l=1;$l<=6;$l++)
        {
			$ok=0;
			while($ok==0)
			{
				$i=rand(2,$nr_rand1);
				if($v==1)
				
					{
					$tab4[$v]=$i;
					$ok=1;
			
					}
				else
					{
						$ok1=1;
						for($j=1;$j<=$v-1;$j++)
							if($tab4[$j]===$i or $tab4[$j]==`1`)
								$ok1=0;
							if($ok1===1)
							{	
								$tab4[$v]=$i;$ok=1;
								
							}
						
					}
				
			}
			
            $rezi=@mysql_query("SELECT * FROM intrebari WHERE `id-intreb`='$i' ");
            $randi=@mysql_fetch_array($rezi,MYSQL_NUM);                       
            $tip=$randi[3];
            
            $nr_intreb=$randi[0];
            
            echo "<tr><td><div class=\"cifre\"><b>$v</b></div></td><td>$randi[2]</td></tr>";
			$rezr=@mysql_query("SELECT * FROM raspunsuri WHERE `id-intreb`='$nr_intreb'");
            $nr_randr=@mysql_num_rows($rezr);
            if($tip==2)
          	{
            	for($j=1;$j<=$nr_randr;$j++)
               	{
	   				$randr=@mysql_fetch_array($rezr,MYSQL_NUM);
       				$c=$randr[2];
       				$corect=$randr[3];
					$punct=$punct+$corect;
	   				echo "<tr><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type=checkbox name=del$ss value=$corect>&nbsp;&nbsp; $c</td></tr>";
        			$ss++;
      			}
      			$tab6[$v]=$ss-1;
				$v++;
			}
        	else
          		if($tip==1)
            	{

              		for($j=1;$j<=$nr_randr;$j++)
              		{
	           			$randr1=@mysql_fetch_array($rezr,MYSQL_NUM);
               			$c=$randr1[2];
               			$corect=$randr1[3];
						$punct=$punct+$corect;
						echo "<tr><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type=radio name=del$ss value=$corect>&nbsp;&nbsp; $c</td></tr>";

              		} 
					$v++;
                    $ss++;
           		}	
        }
        echo "<input type='hidden' name='numar' value=$ss>";
		echo "<input type='hidden' name='punct_max' value=$punct>";
		for($r=1;$r<=6;$r++)
		{
			echo "<input type='hidden' name='intreb$r' value=$tab4[$r]>";
		}
		echo "<tr><td colspan='4'><div class=\"butoo\"><input class='buton' type='submit' name='trimite1' value='VEZI PUNCTAJUL'></div></td></tr></form> ";
?>                   
</table>
<?php
}
}
@mysql_close($con);
?>

</div>
</section>

</body>
</html>