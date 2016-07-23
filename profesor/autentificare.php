<?php
session_start();
if(!isset($_SESSION['domeniu']) and !isset($_SESSION['password']))
{
	echo "<h3>Acces neautorizat</h3>";
	exit();
}
?>