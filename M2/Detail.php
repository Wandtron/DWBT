<?php
require __DIR__ . '/vendor/autoload.php';
$dotenv = Dotenv\Dotenv::create(__DIR__,'LoginDatenbank.env');
$dotenv->load();
$dotenv->required(['DB_HOST', 'DB_NAME', 'DB_USER', 'DB_PASS','DB_PORT']);
$link = mysqli_connect(
    getenv('DB_HOST'),
    getenv('DB_USER'),
    getenv('DB_PASS'),
    getenv('DB_NAME'),
    (int) getenv('DB_PORT')
);
if (isset($_GET['id']))
{
    $id = (int)$_GET['id'] ?? 0; //do stuff that requires 's'
    //do stuff that requires 's'
}
else
{
    $id = -1; //do stuff that doesn't need 's'
    echo '<head> <meta http-equiv="refresh" content="0; URL=Produkte.php"> </head>';
}

$query = 'SELECT `Alt-Text`, Mahlzeiten.ID, Titel, `Binärdaten`, `Name`, `Verfügbar`,Beschreibung, Vorrat, Kategorien_ID, Jahr, Gastpreis, `MA-Preis`, `Student-preis`
FROM (((Mahlzeiten
LEFT JOIN ZT_Mahlzeiten_hat_Bilder ON Mahlzeiten_ID = Mahlzeiten.ID) 
LEFT JOIN Bilder ON Bilder.ID=ZT_Mahlzeiten_hat_Bilder.Bilder_ID )  
LEFT JOIN Preise ON Preise.Mahlzeiten_ID=Mahlzeiten.ID)
LEFT JOIN `zt_mahlzeiten_enthält_zutaten` ON `zt_mahlzeiten_enthält_zutaten`.`Mahlzeiten_ID` = `Mahlzeiten`.`ID`
LEFT JOIN `zutaten` ON zutaten.ID = zt_mahlzeiten_enthält_zutaten.Zutaten_ID
WHERE Mahlzeiten.ID = '.$id.' AND Jahr = '.date("Y").' ORDER BY `Kategorien_ID`;'; //Ihre SQL Query aus HeidiSQL

$result = mysqli_query($link, $query);
$row =mysqli_fetch_assoc($result);

if (empty($result))
{
    echo '<head> <meta http-equiv="refresh" content="3; URL=Produkte.php"> </head>';
}

$title = "Detail für $row[Name]";
include 'snippets/Head.php'; ?>
<body>
<div class="container">
    <?php include 'snippets/NavOben.php';?>

    <div class="row" id="body1">
        <div class="col-3 bottom-manual2">

            <fieldset class="Login">
                <legend> Login </legend>    <!--Überschrift der gesamten Box-->
                <div class="col ">
                    <!--Klasse für Benutzer und Passworteingabe-->
                    <input class="form-control border-dark my-1" type="text" id="inputBenutzer" placeholder="Benutzer">
                    <input type="password" class="form-control border-dark  my-1" id="inputPassword" placeholder="****">
                </div>

                <button type="button" class="btn" style="margin-top:5px;">Anmelden </button>
            </fieldset>


        </div>
        <div class="col-6">
                <div class="row mt-1 mb-1">
                    <div class="col ">
                        <h2>Details für "<?php echo $row['Name'];?>"</h2>
                    </div>
                </div>
                <div class="row mt-1 mb-1 ">
                    <div class="col">
                        <?php if ($row['Alt-Text'] == '') {echo '<img alt="Kein Bild gefunden" style="height: 250px;" class="rounded img-fluid w-100" src="pic/Artistic-4K-Wallpaper-3840x2160-banner.jpg"/>';}
                        else  {
                            echo '<img class="rounded img-fluid w-100" style="height: 250px;" alt=" '.$row['Alt-Text'].' " src="data:image/gif;base64,'.base64_encode($row['Binärdaten']).'">';
                        }?>
                        <!--<img alt="ein kleines X" class="img-fluid" src="pic/falafel2_breit.jpg"/> -->
                    </div>
                </div>

            </div>
        <div class="col-3">

                <div class="row mt-4" id="preis">
                <div class="col text-right">
                    Gast-Preis
                </div>
            </div>
                <div class="row" >
                <div class="col text-right">
                        <?php
                        if ($row['Jahr'] == '')
                        {
                            echo '<h2>kein Preis vorhanden</h2>';
                        }
                        else
                        {
                            echo '<h2>'.$row['Gastpreis'].'</h2>';
                        };
                        ?>

                </div>
            </div>
                <div class="row align-items-end">
                    <div class="col ">
                    <button class="btn btn-outline-dark btn-block bottom-manual" type="button"><i class="fas fa-utensils"></i> Vorbestellen</button>
                </div>
                </div>
        </div>
    </div>
    <div class="row" id="body2">
        <div class="col-3">
            Melden Sie sich jetzt an, um die wirklich viel günstigeren Preise für Mitarbeiter oder Studenten zu sehen.
        </div>
        <div class="col-6">
            <div class="row mt-1 mb-1">
                <div class="col">
                    <div class="container">
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs " id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active " id="beschreibung-tab" data-toggle="tab" href="#beschreibung" role="tab"  aria-selected="true">Beschreibung</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link " id="zutaten-tab" data-toggle="tab" href="#zutaten" role="tab"  aria-selected="false">Zutaten</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link " id="Bewertungen-tab" data-toggle="tab" href="#Bewertungen" role="tab" aria-selected="false">Bewertungen</a>
                            </li>
                        </ul>

                        <!-- Tab panes -->
                        <div class="tab-content border border-top-0 ">
                            <div class="tab-pane active" id="beschreibung" role="tabpanel" aria-labelledby="beschreibung-tab">
                                <?php echo $row['Beschreibung'];?>
                            </div>
                            <div class="tab-pane " id="zutaten" role="tabpanel" aria-labelledby="zutaten-tab">
                                getrocknete Kichererbsen, Zwiebel, Knoblauch, Petersilie, Zitrone, Korianderpulver, Kreuzkümmel, Salz, Chilipulver, Backpulver, Mehl, Paniermehl und Olivenöl
                            </div>
                            <div class="tab-pane" id="Bewertungen" role="tabpanel" aria-labelledby="Bewertungen-tab">
                                <form method="post" action="http://bc5.m2c-lab.fh-aachen.de/form.php" target="_blank">
                                    <input type="hidden" name="matrikel" value="3137339">
                                    <input type="hidden" name="kontrolle" value="fre">
                                        <div class="row mx-2">
                                            <div class="col-3 mt-2">Produkt: </div>
                                            <div class="col mt-2">
                                                <select name="mahlzeit" class="form-control border-dark">
                                                    <option value="">Wähle Gericht</option>
                                                <?php
                                                $query = 'SELECT * FROM `Mahlzeiten` ORDER BY `Name`;'; //Ihre SQL Query aus HeidiSQL
                                                if ($result = mysqli_query($link, $query))
                                                    {
                                                        while ($row = mysqli_fetch_assoc($result)){
                                                          echo  '<option '; if ($row['ID'] == $id) {echo ' selected '; }; echo 'value="'.$row['ID'].'">'.$row['Name'].'</option>';
                                                        }
                                                    };
                                                ?>
                                                </select>
                                            </div>
                                        </div>
                                    <div class="row mt-2 mx-2">
                                        <div class="col-3">Benutzer: </div>
                                        <div class="col"><input class="form-control rounded-0 border-dark" name="benutzer" id="benutzer" placeholder="Benutzername"></div>
                                    </div>

                                    <div class="row mt-2 mx-2">
                                        <div class="col-3">Bewertung: </div>
                                        <div class="col">
                                            <input type="number" name="bewertung" min="1" max="5" class="form-control rounded-0 border-dark" value="5">
                                        </div>
                                    </div>

                                    <div class="row mt-2 mx-2">
                                        <div class="col-3">Bemerkung: </div>
                                        <div class="col"><textarea class="form-control rounded-0 border-dark" name="bemerkung" rows="3" placeholder="Bitte Schreiben sie eine Bemerkung, damit wir uns verbessern können"></textarea></div>
                                    </div>


                                    <div class="row mt-2 mb-2 mx-2">
                                        <div class="col-3"> </div>
                                        <div class="col">
                                            <button class="btn btn-outline-dark btn-block" type = "submit">Bewertung senden</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-3 ">
        </div>
    </div>

    <?php include 'snippets/NavUnten.php';?>
</div>
<?php mysqli_close($link); ?>
</body>
</html>