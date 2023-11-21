<?php
	$servername = "localhost:3306";
	$user = "root";
	$pass = "";	
	$db = "administracija_zaposlenika_db";
				
	$conn = mysqli_connect($servername, $user, $pass, $db) or die("Connection Error" . mysqli_connect_error());
?>