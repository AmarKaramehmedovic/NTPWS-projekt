<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Administracija zaposlenika - Registracija</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
	<link rel="stylesheet" media="screen" href="style.css">
    <link rel="shortcut icon" href="slike/favicon.ico" />
</head>
<body>
    <?php
        session_start();
        if (!isset($_SESSION["loggedIn"]) || ($_SESSION["loggedIn"] != true)) {
            header("Location: login.php");
            exit;
        }

	    $dozvola = $_SESSION["dozvola"];
        if($dozvola != 'administrator'){
            header("Location: ../administracija-zaposlenika");
            exit;
        }

        $username = $_SESSION["username"];

        include "header.php";
        require_once "connection.php";
    ?>

    <div class="container-fluid wrapper">
        <h4 style="font-size: 1.6rem;">Registracija korisnika aplikacije</h4>
        <br />
        <form method="POST">
            <div class="row">
                <label class="col-8">Korisničko ime:
                    <input class="form-control"  name="username" id="username" type="text" placeholder="Unesite korisničko ime" required>
                    <span id="porukaUsername" class="error"></span>
                </label>
            </div>

            <div class="row form-spacing">
                <label class="col-4">Lozinka:
                    <input class="form-control"  name="password" id="password" type="password" placeholder="Unesite lozinku" required>
                    <span id="porukaLozinka" class="error"></span>
                </label>
                
                <label class="col-4">Ponovljena lozinka:
                    <input class="form-control"  name="repeatPassword" id="repeatPassword" type="password" placeholder="Ponovite lozinku" required>
                    <span id="porukaPonovljenaLozinka" class="error"></span>
                </label>
            </div>
            
            <div class="row form-spacing">
                <label class="col-4">Dozvola:
                    <select class="form-select" name="dozvola" required>
                        <option value="administrator">Administrator</option>
                        <option value="urednik">Urednik</option>
                        <option value="pretplatnik">Pretplatnik</option>
                    </select>
                </label>
            </div>
            
            <div class="row" style="margin-top:20px">
                <div class="col-4">
                    <input class="btn btn-primary" name="submit" id="submit" type="submit" value="Registriraj">
                </div>
                <div class="col-4" style="text-align:right;">
                    <a class="btn btn-outline-secondary" href="../administracija-zaposlenika">Povratak na početnu</a>
                </div>
            </div>
        </form>
        
        <script type="text/javascript">
            document.getElementById("submit").onclick = function(event) {
            var slanje_forme = true;

            var poljeUsername = document.getElementById("username");
            var username = document.getElementById("username").value;

            if(username.length < 4 || username.length > 15 || username == "") {
                slanje_forme = false;
                document.getElementById("porukaUsername").innerHTML = "Korisničko ime ne smije biti prazno, mora imati više od 4, a najviše 15 znakova!<br>";
                document.getElementById("porukaUsername").style.color = "red";
                poljeUsername.style.border = "1px solid red";
            } else {
                document.getElementById("porukaUsername").innerHTML = "";
                poljeUsername.style.border = "";
            }


            var poljeLozinka = document.getElementById("password");
            var lozinka = document.getElementById("password").value;

            if(lozinka == "") {
                slanje_forme = false;
                document.getElementById("porukaLozinka").innerHTML = "Lozinka ne smije biti prazna!</br>";
                document.getElementById("porukaLozinka").style.color = "red";
                poljeLozinka.style.border = "1px solid red";
            } else {
                document.getElementById("porukaLozinka").innerHTML = "";
                poljeLozinka.style.border = "";
            }


            var poljePonovljenaLozinka = document.getElementById("repeatPassword");
            var ponovljenaLozinka = document.getElementById("repeatPassword").value;

            if(ponovljenaLozinka == "") {
                slanje_forme = false;
                document.getElementById("porukaPonovljenaLozinka").innerHTML = "Ponovljena lozinka ne smije biti prazna!</br>";
                document.getElementById("porukaPonovljenaLozinka").style.color = "red";
                poljePonovljenaLozinka.style.border = "1px solid red";
            } else {
                document.getElementById("porukaPonovljenaLozinka").innerHTML = "";
                poljePonovljenaLozinka.style.border = "";
            }

            if(lozinka != ponovljenaLozinka) {
                slanje_forme = false;
                document.getElementById("porukaPonovljenaLozinka").innerHTML = "Lozinke moraju biti iste!</br>";
                document.getElementById("porukaLozinka").innerHTML = "Lozinke moraju biti iste!</br>";
                poljeLozinka.style.border = "1px solid red";
                poljePonovljenaLozinka.style.border = "1px solid red";
                document.getElementById("porukaPonovljenaLozinka").style.color = "red";
                document.getElementById("porukaLozinka").style.color = "red";
            }


            if(slanje_forme != true) {
                event.preventDefault();
            }
        }
        </script>

        <?php

        if (isset($_POST["submit"])) {
            $username = $_POST["username"];
            $password = $_POST["password"];
            $dozvola = $_POST["dozvola"];
            $hashPassword = password_hash($password, CRYPT_BLOWFISH);
                
            $query = "SELECT korisnicko_ime FROM korisnici WHERE korisnicko_ime = '$username';";
            $result = mysqli_query($conn, $query) or die ("Query Error");

            if(mysqli_num_rows($result) >= 1)
                echo "</br><span class='text-danger'>Korisničko ime već postoji!</span>";
            else {
                $sql = "INSERT INTO korisnici (korisnicko_ime, lozinka, dozvola) values (?, ?, ?)";
                $stmt = mysqli_stmt_init($conn);

                if (mysqli_stmt_prepare($stmt, $sql)) {
                    mysqli_stmt_bind_param($stmt, 'sss', $username, $hashPassword, $dozvola);
                    mysqli_stmt_execute($stmt);
                    echo "<br/><span class='text-success'>Korisnik uspješno unesen!</span>";
                } else{
                    echo "<br/>Greška, korisnik nije unesen!";
                }
            }
        }

        mysqli_close($conn);
        ?>
    </div>

    <?php readfile("footer.html"); ?>

	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
</body>
</html>