<!DOCTYPE html>
<html>
    <link rel="stylesheet" type="text/css" href="design_index.css">
    <title>Pagina de logare</title>
    <body>
       <div class="chenar">
	   <?php
	   $vparola=@$_POST['text_v'];
	   $nparola=@$_POST['text_n'];
	   if(@$_POST['submit'])
	   {
		   $con=@mysql_connect("localhost","root","");
			mysql_select_db("profesor");
		   if($vparola==NULL or $nparola==NULL)
		   {
			   echo "Nu ati terminat de completat!";
			   echo "<br><br><a href=\"sch_par.php\"><span><< Inapoi</span></a>";
		   }
		   else
		   {
		   		$vpar=md5($vparola);
		   		$mpar=md5($nparola);
		   		$par=mysql_query("SELECT `parola` FROM `utilizator` WHERE `user`='profesor'");
		   		$r=mysql_fetch_row($par);
		   		if($vpar==$r[0])
			  	{ mysql_query("UPDATE `utilizator` SET `parola`='$mpar' WHERE `user`='profesor'");
			  		 echo "Parola a fost modificata!";
			   		echo "<br><br><a href=\"login.html\"><span><< Inapoi</span></a>";
			   	}
				else
				{
					echo "Vechea parola este gresita!";
					echo "<br><br><a href=\"login.html\"><span><< Inapoi</span></a>";
				}
		   }
		   @mysql_close($con);
	   }
	   else
	   {
	   ?>
       <form action="sch_par.php" method="post">
			Vechea parola:
			<input type="password" name="text_v" style="border-radius: 5px;
												-webkit-border-radius: 5px;
													-moz-border-radius: 5px;
													font-size: 18px;
													width: 150px;
													border:1px solid white;"><br>
			<br>Noua parola:
            <input type="password" name="text_n" style="border-radius: 5px;
												-webkit-border-radius: 5px;
													-moz-border-radius: 5px;
													font-size: 18px;
													width: 150px;
													border:1px solid white;"><br>
			<span><input class="submit" type="submit" name="submit" value="Modifica"></span>
        </form>
		<?php
	   }
	   ?>
        </div>
    </body>
</html>