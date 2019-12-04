<?php $title = "Produkte";
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

$query = "SELECT Mahlzeiten.ID,  Titel, `Verfügbar`,Beschreibung, Vorrat, Kategorien_ID, `Name`, `Alt-Text`, `Binärdaten`
FROM (( Mahlzeiten
LEFT JOIN ZT_Mahlzeiten_hat_Bilder ON Mahlzeiten.ID = ZT_Mahlzeiten_hat_Bilder.Mahlzeiten_ID)
LEFT JOIN Bilder ON ZT_Mahlzeiten_hat_Bilder.Bilder_ID = Bilder.ID )";

if (isset($_GET['avail']))
    {
        $avail = $_GET['avail'];
        if ($_GET['avail'] > 0) {
            $query .= "WHERE Vorrat >= $avail";
        }
        else {
            $query .= " WHERE Vorrat <= $avail ";
        }
    }
$query .= " ORDER BY `Kategorien_ID` DESC, `Name` ";

if (isset($_GET['limit']))
{
    $limit = $_GET['limit'];
        $query .= "LIMIT $limit ";
}
 $query .= ";"; //Ihre SQL Query aus HeidiSQL


$result = mysqli_query($link, $query);
include 'snippets/Head.php';

?>
<body>
<div class="container">
    <?php include 'snippets/NavOben.php';?>

    <div class="row">
        <div class="col text-center">
            <h3>Verfügbare Speisen (Bestseller)</h3>
            <?php // echo "'$limit ' ' $avail'"; ?>
        </div>

    </div>
    <div class="row">
        <div class="col-3">
            <fieldset>
                <legend class="Überschrift"> Speisenliste filtern</legend>
                <form>
                <select class="form-control border-dark" id="Speise">
                    <option selected value="">Kategorien</option>
                    <?php $query2 = 'SELECT `ID` , `Bezeichnung` FROM `Kategorien` ORDER BY `Bezeichnung`;';
                    if ($result2 = mysqli_query($link, $query2))
                    {
                        while ($row = mysqli_fetch_assoc($result2)){
                            echo  '
                    <option value="'.$row['ID'].'">'.$row['Bezeichnung'].'</option>';}; }; ?>
                </select>

                    <ul>
                        <li>
                            <label class="form-check-label ">
                                <input class="form-check-input" type="checkbox" value="verfügbar">nur verfügbar
                            </label>
                        </li>
                        <li>
                            <label class="form-check-label ">
                                <input class="form-check-input" type="checkbox" value="vegetarische">nur vegetarische
                            </label>
                        </li>
                        <li>
                            <label class="form-check-label">
                                <input class="form-check-input" type="checkbox" value="vegane">nur vegane
                            </label>
                        </li>
                    </ul>
                </form>
                <button class="btn btn-outline-dark btn-block" type="button">Speisen filtern</button>
            </fieldset>
        </div>
        <div class="col-6">
            <div class="row">
                <?php
                if (mysqli_connect_errno()) {
                    printf("Konnte nicht zur entfernten Datenbank verbinden: %s\n", mysqli_connect_error());
                    exit();
                }
                if ($result = mysqli_query($link, $query)) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        if ($row['Vorrat'] <= 0) {
                            echo '<div class="col-3">
                                <figure class="figure border my-1 rounded border-dark vergriffen">
                                <img width="100" class="rounded" height="100" alt=" ' . $row['Alt-Text'] . ' " src="data:image/gif;base64,' . base64_encode($row['Binärdaten']) . '">
                                <figcaption class="figure-caption text-center">' . $row['Name'] . '<br>vergriffen</figcaption>
                                </figure></div>';
                        }
                        else {
                            echo '<div class="col-3">
                                <figure class="figure border my-1 rounded border-dark ">
                                    <img width="100" class="rounded" height="100" alt=" ' . $row['Alt-Text'] . ' " src="data:image/gif;base64,' . base64_encode($row['Binärdaten']) . '">
                                    <figcaption class="figure-caption text-center"><form action="Detail.php" method="GET">
                                    ' . $row['Name'] . '<br>
                                    <input name="id" type="hidden" value="' . $row['ID'] . '" />
                                    <input class="btn btn-link btn-sm" style="color:#00b5ad;" data-toggle="tooltip" title="Mehr Details zu ' . $row['Name'] . ' herausfinden" type="submit" value="Details">
                                    </form>
                                </figcaption>
                                </figure></div>';
                        }
                    };
                }?>
            </div>
        </div>
    </div>
    <?php include 'snippets/NavUnten.php';?>
</div>

</body>
<?php mysqli_close($link); ?>
</html>
