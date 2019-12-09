<?php
namespace Emensa\Controller {
    session_start();
    require __DIR__ . '/vendor/autoload.php';

// Blade
    Use eftec\bladeone\BladeOne;

    $views = __DIR__ . '/views';
    $cache = __DIR__ . '/cache';
    $blade = new BladeOne($views, $cache, BladeOne::MODE_AUTO);
// Datenbank
    $dotenv = \Dotenv\Dotenv::create(__DIR__, 'LoginDatenbank.env');
    $dotenv->load();
    $dotenv->required(['DB_HOST', 'DB_NAME', 'DB_USER', 'DB_PASS', 'DB_PORT']);
    $remoteConnection = mysqli_connect(
        getenv('DB_HOST'),
        getenv('DB_USER'),
        getenv('DB_PASS'),
        getenv('DB_NAME'),
        (int)getenv('DB_PORT')
    );
    $categorie = (int)-1;
    if (isset($_GET['categorie'])) {
        $categorie = $_GET['categorie'];
    }


    $queryMahleiten = "SELECT m.ID, m.`Verfügbar`,m.Beschreibung, m.Vorrat, m.Kategorien_ID, m.`Name`, b.Titel, b.`Alt-Text`, b.`Binärdaten`,(COUNT(z.ID) - SUM(z.Vegan)) AS VeganIndex, (COUNT(z.ID) - SUM(z.Vegetarisch)) AS VegetarischIndex
FROM (((( Mahlzeiten AS m
LEFT JOIN ZT_Mahlzeiten_hat_Bilder AS ZT_MB ON m.ID = ZT_MB.Mahlzeiten_ID)
LEFT JOIN Bilder AS b ON ZT_MB.Bilder_ID = b.ID ) 
LEFT JOIN ZT_Mahlzeiten_enthält_Zutaten AS ZT_MZ ON ZT_MZ.Mahlzeiten_ID=m.ID)
LEFT JOIN zutaten AS z ON ZT_MZ.Zutaten_ID= z.ID)";

    If (isset($_GET['avail']) | $categorie != '-1') {
        $queryMahleiten .= " WHERE ";
    }
    if (isset($_GET['avail'])) {
        $avail = $_GET['avail'];
        if ($_GET['avail'] > 0) {
            $queryMahleiten .= "Vorrat >= $avail ";
        } else {
            $queryMahleiten .= "Vorrat <= $avail ";
        }
        if ($categorie != '-1') {
            $queryMahleiten .= " AND ";
        }
    }
    if ($categorie != '-1') {
        $queryMahleiten .= "m.Kategorien_ID = $categorie ";
    }
    $queryMahleiten .= "GROUP BY m.ID ";
    if (isset($_GET['vegan']) && !isset($_GET['vegetarisch'])) {
        $queryMahleiten .= " HAVING VeganIndex = 0 ";
    } elseif (isset($_GET['vegetarisch']) && !isset($_GET['vegan'])) {
        $queryMahleiten .= " HAVING VegetarischIndex = 0 ";
    } elseif (isset($_GET['vegetarisch']) && isset($_GET['vegan'])) {
        $queryMahleiten .= " HAVING VeganIndex = 0 AND VegetarischIndex = 0 ";
    }

    $queryMahleiten .= "ORDER BY `Kategorien_ID` DESC, `Name` ";
    if (isset($_GET['limit'])) {
        $limit = $_GET['limit'];
        $queryMahleiten .= "LIMIT $limit ";
    }
    $queryMahleiten .= ";"; //Ihre SQL Query aus HeidiSQL
    $queryKategorien = 'SELECT a.ID, a.Bilder_ID, b.Bezeichnung AS `Ober_Kategorie`, a.Bezeichnung AS `Unter_Kategorie`
FROM Kategorien AS a 
INNER JOIN Kategorien AS b on a.Kategorien_ID = b.ID  ORDER BY Ober_Kategorie, Unter_Kategorie;';


    $queryThisKategory = "SELECT * FROM Kategorien WHERE ID = $categorie;";

    $resultMahleiten = mysqli_query($remoteConnection, $queryMahleiten);
    $resultKategorien = mysqli_query($remoteConnection, $queryKategorien);
    $resultThisKategory = mysqli_query($remoteConnection, $queryThisKategory);

    $ArrMahleiten = array();
    while ($rowMahleiten = mysqli_fetch_array($resultMahleiten)) {
        array_push($ArrMahleiten, $rowMahleiten);
    }
    $ArrKategorien = array();
    while ($rowKategorien = mysqli_fetch_array($resultKategorien)) {
        array_push($ArrKategorien, $rowKategorien);
    }
    $ArrThisKategory = array();
    while ($rowbewertung = mysqli_fetch_array($resultThisKategory)) {
        array_push($ArrThisKategory, $rowbewertung);
    }

    try {
        echo $blade->run("pages.Produkte", array("ArrMahleiten" => $ArrMahleiten, "ArrKategorien" => $ArrKategorien, "ArrThisKategory" => $ArrThisKategory));
    } catch (Exception $e) {
    }

    mysqli_free_result($resultMahleiten);
    mysqli_free_result($resultKategorien);
    mysqli_free_result($resultThisKategory);
    mysqli_close($remoteConnection);
}
