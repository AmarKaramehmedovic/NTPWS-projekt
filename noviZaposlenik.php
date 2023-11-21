<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Administracija zaposlenika - Unos zaposlenika</title>
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
        if($dozvola == 'pretplatnik'){
            header("Location: ../administracija-zaposlenika");
            exit;
        }

        $username = $_SESSION["username"];

        include "header.php";
        require_once "connection.php";
    ?>
    
    <div class="container-fluid wrapper">
    <h4 style="font-size: 1.6rem;">Unos zaposlenika</h4>
    <br />
        <form method="POST">
            <div class="row">
                <label class="col-8">Naziv poduzeća zaposlenika:
                    <select name="poduzeceId" class="form-select">
                        <?php
                            $query = "SELECT id, nazivPoduzeca FROM poduzeca ORDER BY nazivPoduzeca";
                            $result = mysqli_query($conn, $query) or die("Query Error");
                            while ($row = mysqli_fetch_array($result)) {
                                echo "<option value='" . $row['id'] . "'>" . $row['nazivPoduzeca'] . "</option>";
                            }
                        ?>
                    </select>
                </label>
            </div>

            <div class="row form-spacing">
                <label class="col-4">Ime:
                    <input class="form-control" name="imeZaposlenika" type="text" placeholder="Unesite ime">
                </label>
                <label class="col-4">Prezime:
                    <input class="form-control" name="prezimeZaposlenika" type="text" placeholder="Unesite prezime">
                </label>
            </div>

            <div class="row form-spacing">
                <label class="col-4">Email:
                    <input class="form-control" name="email" type="email" placeholder="example@mail.com">
                </label>
                <label class="col-4">Kontakt broj:
                    <input class="form-control" type="tel" name="kontaktBr" pattern="[0-9\s\/\-\+]*" placeholder="Unesite broj telefona">
                </label>
            </div>

            <div class="row form-spacing">
                <label class="col-8">Napomena:
                    <textarea class="form-control" name="napomena" rows="3" placeholder="Unesite napomenu"></textarea>
                </label>
            </div>

            <div class="row" style="margin-top:20px">
                <div class="col-4">
                    <input class="btn btn-primary" name="submit" id="submit" type="submit" value="Unesi">
                </div>
                <div class="col-4" style="text-align:right;">
                    <a class="btn btn-outline-secondary" href="../administracija-zaposlenika">Povratak na početnu</a>
                </div>
            </div>
        </form>

        <?php
            if (isset($_POST["submit"])) {

                $ime = $_POST["imeZaposlenika"];
                $prezime = $_POST["prezimeZaposlenika"];
                $email = $_POST["email"];
                $kontakt = $_POST["kontaktBr"];
                $napomena = $_POST["napomena"];
                $poduzeceId = $_POST["poduzeceId"];

                $query = "SELECT ime, prezime FROM zaposlenici WHERE poduzeceId = '$poduzeceId' AND ime = '$ime' AND prezime = '$prezime'";
                $result = mysqli_query($conn, $query) or die("Query Error");

                if (mysqli_num_rows($result) >= 1)
                    echo "</br><span class='text-danger'>Zaposlenik sa unesenim imenom i prezimenom već postoji!</span>";
                else {
                    $sql = "INSERT INTO zaposlenici (ime, prezime, email, kontaktBr, napomena, poduzeceId) values (?, ?, ?, ?, ?, ?)";
                    $stmt = mysqli_stmt_init($conn);

                    if (mysqli_stmt_prepare($stmt, $sql)) {
                        mysqli_stmt_bind_param($stmt, 'sssssi', $ime, $prezime, $email, $kontakt, $napomena, $poduzeceId);
                        mysqli_stmt_execute($stmt);
                        echo "<br/><span class='text-success'>Zaposlenik uspješno unesen!</span>";
                    } else{
                        echo "<br/>Greška, zaposlenik nije unesen!";
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