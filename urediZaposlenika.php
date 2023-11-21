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
        $_SESSION["editSuccess"] = false;
        $id = $_GET["id"];
            
        include "header.php";
        require_once "connection.php";

        $query = "SELECT * FROM zaposlenici WHERE id = '$id'";
        $result = mysqli_query($conn, $query) or die("Query Error");
        $row = mysqli_fetch_array($result);

        $ime = $row['ime'];
        $prezime = $row['prezime'];
        $email = $row['email'];
        $kontakt = $row['kontaktBr'];
        $napomena = $row['napomena'];
        $poduzeceId = $row['poduzeceId'];

        if (isset($_POST["submit"])) {

            $ime = $_POST["imeZaposlenika"];
            $prezime = $_POST["prezimeZaposlenika"];
            $email = $_POST["email"];
            $kontakt = $_POST["kontaktBr"];
            $napomena = $_POST["napomena"];
            $poduzeceId = $_POST["poduzeceId"];

            $query = "SELECT ime, prezime
                    FROM zaposlenici
                    WHERE poduzeceId = '$poduzeceId'
                    AND ime = '$ime' AND prezime = '$prezime'
                    AND ime != '" . $row['ime'] . "' AND prezime != '". $row['prezime'] ."'";
            $result = mysqli_query($conn, $query) or die("Query Error");

            if (mysqli_num_rows($result) == 0){
                $sql = "UPDATE zaposlenici
                        SET ime = ?,
                            prezime = ?,
                            email = ?,
                            kontaktBr = ?,
                            napomena = ?,
                            poduzeceId = ?
                        WHERE id = ?";

                $stmt = mysqli_stmt_init($conn);

                if (mysqli_stmt_prepare($stmt, $sql)) {
                    mysqli_stmt_bind_param($stmt, 'sssssii', $ime, $prezime, $email, $kontakt, $napomena, $poduzeceId, $id);
                    mysqli_stmt_execute($stmt);
                    $_SESSION["editSuccess"] = true;
                } else{
                    echo "<br/>Greška, zaposlenik nije uređen!";
                }
            }
        }

        if (isset($_POST["delete"])) {
            $sql = "DELETE FROM zaposlenici WHERE id = '$id'";

            if (mysqli_query($conn, $sql)) {
                header("refresh:1; url='../administracija-zaposlenika'");
            }else {
                echo "Greška u brisanju: " . mysqli_error($conn);
            }
        }
    ?>
    
    <div class="container-fluid wrapper">
        <h4 style="font-size: 1.6rem;">Uređivanje zaposlenika: 
        "<?php
            if(isset($_POST["submit"]) && $_SESSION["editSuccess"] == false){
                echo $row['ime']. " " .$row['prezime'];
            }else{
                echo $ime." ".$prezime;
            }
        ?>"</h4>
        <br />
        <form method="POST">
            <div class="row">
                <label class="col-8">Naziv poduzeća zaposlenika:
                    <select name="poduzeceId" class="form-select" required>
                        <?php
                            $query = "SELECT id, nazivPoduzeca FROM poduzeca ORDER BY nazivPoduzeca";
                            $result = mysqli_query($conn, $query) or die("Query Error");
                            while ($row = mysqli_fetch_array($result)) {
                                echo "<option value='" . $row['id'] . "'";
                                if($row['id'] == $poduzeceId){
                                    echo " selected";
                                }
                                echo  ">" . $row['nazivPoduzeca'] . "</option>";
                            }
                        ?> 
                    </select>
                </label>
            </div>

            <div class="row form-spacing">
                <label class="col-4">Ime:
                    <input class="form-control" value="<?php echo $ime; ?>" name="imeZaposlenika" type="text" placeholder="Unesite ime" required>
                </label>
                <label class="col-4">Prezime:
                    <input class="form-control" value="<?php echo $prezime; ?>" name="prezimeZaposlenika" type="text" placeholder="Unesite prezime" required>
                </label>
            </div>

            <div class="row form-spacing">
                <label class="col-4">Email:
                    <input class="form-control" value="<?php echo $email; ?>" name="email" type="email" placeholder="example@mail.com">
                </label>
                <label class="col-4">Kontakt broj:
                    <input class="form-control" value="<?php echo $kontakt; ?>" type="tel" name="kontaktBr" pattern="[0-9\s\/\-\+]*" placeholder="Unesite broj telefona">
                </label>
            </div>

            <div class="row form-spacing">
                <label class="col-8">Napomena:
                    <textarea class="form-control" name="napomena" rows="3" placeholder="Unesite napomenu"><?php echo $napomena; ?></textarea>
                </label>
            </div>

            <div class="row" style="margin-top:20px">
                <div class="col-4">
                    <input class="btn btn-primary" name="submit" id="submit" type="submit" value="Spremi">
                    <input class="btn btn-danger" style="margin-left:5px;" name="delete" id="delete" type="submit" value="Izbriši"
                    onclick="return confirm('Jeste li sigurni da želite izbrisati ovog zaposlenika?')">
                </div>
                <div class="col-4" style="text-align:right;">
                    <a class="btn btn-outline-secondary" href="../administracija-zaposlenika">Povratak na početnu</a>
                </div>
            </div>

            <?php
                if(isset($_POST["submit"]) && $_SESSION["editSuccess"] == true){
                    echo "<br/><span class='text-success'>Zaposlenik uspješno uređen!</span>";
                    $_SESSION["editSuccess"] = false;
                }
                else if(isset($_POST["submit"]) && $_SESSION["editSuccess"] == false){
                    echo "</br><span class='text-danger'>Greška, provjerite da niste unijeli ime zaposlenika koji već postoji!</span>";
                }
                else if(isset($_POST["delete"])){
                    echo "</br><span class='text-success'>Zaposlenik uspješno izbrisan!</span>";
                }
                mysqli_close($conn);
            ?>
        </form>
    </div>

    <?php readfile("footer.html"); ?>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
</body>
</html>