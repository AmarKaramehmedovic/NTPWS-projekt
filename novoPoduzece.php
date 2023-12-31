<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Administracija zaposlenika - Unos poduzeća</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <link rel="stylesheet" media="screen" href="style.css">
    <link rel="shortcut icon" href="slike/favicon.ico" />
</head>

<style>
    #text-container {
    position: relative;
    padding-bottom: 2px;
}

#text-success, #text-fail {
    position: absolute;
    left: 5;
    top: 0;
}
</style>

<body>
    <?php
        session_start();
        if (!isset($_SESSION["loggedIn"]) || ($_SESSION["loggedIn"] != true)) {
            header("Location: login.php");
            exit;
        }
        
        $dozvola = $_SESSION["dozvola"];
        if($dozvola == 'pretplatnik'){
            header("Location: ../NTPWS-projekt");
            exit;
        }

        $username = $_SESSION["username"];
            
        include "header.php";
        require_once "connection.php";

        if (isset($_POST["dohvatiPodatke"])) {

            $oib = $_POST["oibPoduzeca"];
            $url = "https://sudreg-api.pravosudje.hr/javni/subjekt_detalji?tipIdentifikatora=oib&identifikator=" . $oib;

            $curl = curl_init();   
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); 
            curl_setopt($curl, CURLOPT_HTTPHEADER, array(
                'Ocp-Apim-Subscription-Key: 421e8e8c0a1c49bea7303d991df14e5a'
             ));
            curl_setopt($curl, CURLOPT_URL, $url); 

            $jsonResponse = curl_exec($curl);

            if($jsonResponse == 'null'){
                $apiFail = true;
            } else {
                $curl_errno = curl_errno($curl);
                $curl_error = curl_error($curl);
                curl_close($curl);

                if ($curl_errno > 0) {
                    echo "Greška u pozivanju API-ja. Više detalja: ($curl_errno): $curl_error\n";
                } else {
                    $apiSuccess = true;

                    $parsedJson = json_decode($jsonResponse);
                    $apiNaziv = $parsedJson -> {'skracene_tvrtke'}[0] -> {'ime'};
                    $apiAdresa = $parsedJson -> {'sjedista'}[0] -> {'ulica'} . " " . $parsedJson -> {'sjedista'}[0] -> {'kucni_broj'};
                    $apiMjesto = $parsedJson -> {'sjedista'}[0] -> {'naziv_naselja'};
                }
            }

        }
    ?>

    <div class="container-fluid wrapper">
    <h4 style="font-size: 1.6rem;">Unos poduzeća</h4>
    <br />
        <form method="POST">
            <div class="row">
                <div class="col-4">
                    <input class="form-control" name="oibPoduzeca" type="number" placeholder="Unesite OIB" required <?php if(!isset($apiSuccess)) {echo 'autofocus';} ?>>
                </div>
                <div class="col-2">
                    <input class="btn btn-outline-primary" name="dohvatiPodatke" id="dohvatiPodatke" type="submit" value="Dohvati podatke">
                </div>
            </div>
            <div class="row">
                <div id="text-container" class="col-6">
                    <span id="text-success" class='text-success form-spacing' style="visibility:
                        <?php 
                            if(isset($apiSuccess)) {
                                if($jsonResponse != 'null'){
                                        echo 'visible';
                                    } else {
                                        echo 'hidden';
                                    }
                            } else {
                                echo 'hidden';
                            } ?>">
                        Uspješno dohvaćeni podaci iz sudskog registra!
                    </span>
                    <span id="text-fail" class='text-danger form-spacing' style="visibility:
                        <?php 
                            if(isset($apiFail)) {
                                if($jsonResponse == 'null'){
                                        echo 'visible';
                                    } else {
                                        echo 'hidden';
                                    }
                            } else {
                                echo 'hidden';
                            } ?>">
                        Unijeli ste neispravan OIB!
                    </span>
                </div>
            </div>
        </form>
        <br />
        <form method="POST">
            <div class="row form-spacing">
                <label class="col-8">Naziv poduzeća:
                    <input class="form-control" value="<?php if(isset($apiNaziv)) echo $apiNaziv; ?>" name="nazivPoduzeca" type="text" placeholder="Unesite naziv" required>
                </label>
            </div>

            <div class="row form-spacing">
                <label class="col-4">Adresa:
                    <input class="form-control" value="<?php if(isset($apiAdresa)) echo $apiAdresa; ?>" name="adresaPoduzeca" type="text" placeholder="Unesite adresu">
                </label>
                <label class="col-4">Poštanski broj:
                    <input class="form-control" name="postBr" type="number" placeholder="Unesite poštanski broj">
                </label>
            </div>

            <div class="row form-spacing">
                <label class="col-4">Mjesto:
                    <input class="form-control" value="<?php if(isset($apiMjesto)) echo $apiMjesto; ?>" name="mjesto" type="text" placeholder="Unesite mjesto">
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
                    <a class="btn btn-outline-secondary" href="../NTPWS-projekt">Povratak na početnu</a>
                </div>
            </div>
        </form>

        <?php 
            if (isset($_POST["submit"])) {

                $naziv = $_POST["nazivPoduzeca"];
                $adresa = $_POST["adresaPoduzeca"];
                $postBr = $_POST["postBr"];
                $mjesto = $_POST["mjesto"];
                $kontakt = $_POST["kontaktBr"];
                $napomena = $_POST["napomena"];

                $query = "SELECT nazivPoduzeca FROM poduzeca WHERE nazivPoduzeca = '$naziv'";
                $result = mysqli_query($conn, $query) or die("Query Error");

                if (mysqli_num_rows($result) >= 1)
                    echo "</br><span class='text-danger'>Poduzeće sa unesenim nazivom već postoji!</span>";
                else {
                    $sql = "INSERT INTO poduzeca (nazivPoduzeca, adresa, postBr, mjesto, kontaktBr, napomena) values (?, ?, ?, ?, ?, ?)";
                    $stmt = mysqli_stmt_init($conn);

                    if (mysqli_stmt_prepare($stmt, $sql)) {
                        mysqli_stmt_bind_param($stmt, 'ssisss', $naziv, $adresa, $postBr, $mjesto, $kontakt, $napomena);
                        mysqli_stmt_execute($stmt);
                        echo "<br/><span class='text-success'>Poduzeće uspješno uneseno!</span>";
                    } else{
                        echo "<br/>Greška, poduzeće nije uneseno!";
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