<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Administracija zaposlenika - Prijava</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
	<link rel="stylesheet" media="screen" href="style.css">
	<link rel="shortcut icon" href="slike/favicon.ico" />
</head>
<style>
	html, body {
		height: 100%;
	}
</style>
<body class="main-login" style="text-align:center;">
	<div class="wrapper-login">
		<?php
			if(isset($_SESSION["loggedIn"])){
				if($_SESSION["loggedIn"] == true){
					header("Location: ../NTPWS-projekt");
					exit;
				}
			}
			require_once "connection.php";

			if (isset($_POST["submit"])) {

				$username = $_POST["username"];
				$password = $_POST["password"];
					
				$query = "SELECT korisnicko_ime, lozinka FROM korisnici WHERE korisnicko_ime = ?;";
				$stmt = mysqli_stmt_init($conn);
				if (mysqli_stmt_prepare($stmt, $query)) {
					mysqli_stmt_bind_param($stmt, 's', $username);
					mysqli_stmt_execute($stmt);
					mysqli_stmt_store_result($stmt);
					mysqli_stmt_bind_result($stmt, $korisnicko_ime, $hash);
					mysqli_stmt_fetch($stmt);
					
					if (password_verify($password, $hash)) {
						echo "Prijava je uspjela";
							
						$queryRow = "SELECT korisnicko_ime, dozvola FROM korisnici WHERE korisnicko_ime = '$username';";
						$result = mysqli_query($conn, $queryRow) or die("Query Error");           
						$row = mysqli_fetch_array($result);
							
						$dozvola = $row["dozvola"];
						$username = $row["korisnicko_ime"];
							
						session_start();
						$_SESSION["loggedIn"] = true;
						$_SESSION["username"] = $username;
						$_SESSION["dozvola"] = $dozvola;
						
						mysqli_close($conn);
						header("Location: ../NTPWS-projekt");
						exit;
					} 

					mysqli_stmt_close($stmt);
				}
			}
		?>
		<div style="font-family: Trebuchet MS, Arial, Helvetica, sans-serif; text-align:center; margin-top:20vh;">
			<h2><a style="text-decoration:none;" href="/NTPWS-projekt">Administracija zaposlenika</a></h2>
			<form method="POST" style="margin-top:30px;">
				<label>Korisničko ime:
					<input class="form-control" name="username" type="text" required>
				</label> <br/>

				<label>Lozinka:
					<input class="form-control" name="password" type="password" required>
				</label> <br/><br/>

				<input class="btn btn-primary" name="submit" type="submit" value="Prijava">
				<?php
					if(isset($_POST["submit"]) && !isset($_SESSION["loggedIn"])){
						echo "<br/><br/><span class='text-danger'>Unijeli ste pogrešno korisničko ime ili lozinku</span>";
					}
				?>
			</form>
		</div>
		<div class="footer" style="margin-top:45vh;">
			<hr></hr>
			<p>Web aplikacija za administraciju podataka zaposlenika poduzeća - Završni rad - Amar Karamehmedović</p>
		</div>
	</div>

	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
</body>
</html>