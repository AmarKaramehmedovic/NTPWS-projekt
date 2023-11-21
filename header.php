<div class="header container-fluid" style="padding-bottom:30px;">
    <div class="row">
        <div class="col-4"></div>
        <div class="col-4">
            <h3 style="margin-top:20px; text-align:center;"><a style="text-decoration:none;" href="/NTPWS-projekt">Administracija zaposlenika</a></h3>
        </div>
        <div class="col-4">
            <?php
            echo '<div style="font-size:15px; text-align:right;">Pozdrav, <b>' . $username . '</b>! <br> Vi ste <b>' . $dozvola . '</b>';
            echo "</br>";
            if ($dozvola == 'administrator') {
                echo '<a class="btn btn-secondary" href="registracija.php">Registracija</a>';
            }
            echo '<a style="margin-top:5px;margin-bottom:5px;margin-left:5px;" class="btn btn-danger" href="logout.php">Odjava</a>';
            echo '</div>';
            ?>
        </div>
        <hr>
        </hr>
    </div>
</div>