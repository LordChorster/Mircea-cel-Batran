<?php
include '../autentificare.php';
?>
<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="style.css">
<link rel="stylesheet" type="text/css" href="../style_prof.css">
<title>Capitole</title>
</head>

<style>
.capitol input  {
	background-color: rgba(215, 44, 0, 0.1);
	border:0;
	margin:10px 0;
	padding:25px 0;
	width:100%;
	cursor:pointer;
	font-family:'Bookman Old Style';
    font-size:18px;
}
.capitol {
	padding-top:70px;
	text-align:center;
}
.capitol input {
	color:grey;
	text-decoration:none;
}
.capitol span :hover {
	color:maroon;
	background-color: rgba(215, 44, 0, 0.3);
}
</style>

<body>
<header>
<h1>Alege un capitol pe care vrei sa il studiezi</h1>
<span><br><br><a href="../logout.php" style="margin-left:50px">Deconecteaza-te</a></span>
</header>

<section>
<a href="../acasa_prof.php" title="Panou de administrare"><img src="imagini/admin.png" width="40px" style="float:left;margin-left:10px;margin-top:15px;"/></a>
<?php
include '../conectare.php';
?>
<div class="capitol">
	<?php
	$capt=mysql_query("SELECT * FROM capitole");
	while($r=mysql_fetch_row($capt))
	{
	?>
	<form action='<?php echo $r[1]."/index.php"?>' method='post'>
	<span><input type="hidden" name="idcap" value="<?php echo $r[0];?>"></span>
	<span><input type="submit" name="submit" value="<?php echo $r[1];?>"></span>
	</form>
	<?php
	}
	?>
</div>
<?php
@mysql_close($con);
?>
</section>

</body>
</html>