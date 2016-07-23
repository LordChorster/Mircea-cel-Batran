<?php
include '../../autentificare.php';
?>
<!DOCTYPE html>
<html>

<?php
include '../../conectare.php';
if(empty($_SESSION['cap']))
{
$capt=@$_POST['submit'];
$idcap=@$_POST['idcap'];
$_SESSION['cap']=$idcap;
$_SESSION['numecap']=$capt;
}
else
	$capt=$_SESSION['numecap'];
?>

<head>
<link rel="stylesheet" type="text/css" href="style.css">
<link rel="stylesheet" type="text/css" href="../../style_prof.css">
<title><?php echo $capt; ?></title>
</head>

<body>

<header>
<h1><?php echo $capt; ?></h1>
<span><br><br><a href="../../logout.php" style="margin-left:20px">Deconecteaza-te</a></span>
</header>

<section>
<a href="../../acasa_prof.php" title="Panou de administrare"><img src="../imagini/admin.png" width="40px" style="float:left;margin-left:10px;margin-top:15px;"/></a>
<br><br><br><br>
<aside>
	<?php
	$cap=mysql_query("SELECT `id-cap` FROM `capitole` WHERE `nume-cap`='$capt'");
	$capp=mysql_fetch_row($cap);
	$lectie=mysql_query("SELECT `nume-lect` FROM `lectii` WHERE `id-cap`='$capp[0]'");
	while($r=mysql_fetch_row($lectie))
	{
	?>
	<div class="item"><a href='<?php echo $r[0]."/".$r[0].".html"?>'><?php echo $r[0];?></a></div>
	<?php
	}
	?>
	<div class="item"><a href='bibliografie.html'>Bibliografia</a></div>
	<div class="item"><a href='../teste.php'>Evaluare finala</a></div>
</aside>

<?php
$i=mysql_query("SELECT `nume-img` FROM `imgcapitol` WHERE `idc`='$capp[0]'");
$ii=mysql_fetch_row($i);
?>
<div class="pict">
	<img src='<?php echo "imagini/$ii[0]";?>' />
</div>

</section>

<?php
@mysql_close($con);
?>

</body>
</html>