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
    $link = mysqli_connect(
        getenv('DB_HOST'),
        getenv('DB_USER'),
        getenv('DB_PASS'),
        getenv('DB_NAME'),
        (int)getenv('DB_PORT')
    );
    $id = -1;
    if (isset($_GET['id'])) {
        $id = (int)$_GET['id']; //do stuff that requires 's'
        //do stuff that requires 's'
    }
    $queryinfo = 'SELECT `Alt-Text`, Mahlzeiten.ID, Titel, `Binärdaten`, `Name`, `Verfügbar`,Beschreibung, Vorrat, Kategorien_ID, Jahr, Gastpreis, `MA-Preis`, `Student-preis`
FROM (((Mahlzeiten
LEFT JOIN ZT_Mahlzeiten_hat_Bilder ON Mahlzeiten_ID = Mahlzeiten.ID) 
LEFT JOIN Bilder ON Bilder.ID=ZT_Mahlzeiten_hat_Bilder.Bilder_ID )  
LEFT JOIN Preise ON Preise.Mahlzeiten_ID=Mahlzeiten.ID)
WHERE Mahlzeiten.ID = ' . $id . ' AND Jahr = ' . date("Y") . ' ORDER BY `Kategorien_ID`;'; //Ihre SQL Query aus HeidiSQL

    $queryzutaten = 'SELECT * FROM Mahlzeiten LEFT JOIN `ZT_Mahlzeiten_enthält_Zutaten` ON `ZT_Mahlzeiten_enthält_Zutaten`.`Mahlzeiten_ID` = `Mahlzeiten`.`ID`
                                                LEFT JOIN `zutaten` ON zutaten.ID = ZT_Mahlzeiten_enthält_Zutaten.Zutaten_ID
                                                WHERE Mahlzeiten.ID = ' . $id . ' ORDER BY zutaten.Bio DESC, zutaten.Name;';

    $queryBewertung = 'SELECT ID , Name FROM `Mahlzeiten` ORDER BY `Name`;';

    $resultinfo = mysqli_query($link, $queryinfo);
    $resultzutaten = mysqli_query($link, $queryzutaten);
    $resultbewertung = mysqli_query($link, $queryBewertung);

    $Arrinfo = array();
    while ($rowinfo = mysqli_fetch_array($resultinfo)) {
        array_push($Arrinfo, $rowinfo);
    }
    $Arrzutaten = array();
    while ($rowzutaten = mysqli_fetch_array($resultzutaten)) {
        array_push($Arrzutaten, $rowzutaten);
    }
    $Arrbewertung = array();
    while ($rowbewertung = mysqli_fetch_array($resultbewertung)) {
        array_push($Arrbewertung, $rowbewertung);
    }

    try {
        echo $blade->run("pages.detail", array("Arrinfo" => $Arrinfo, "Arrzutaten" => $Arrzutaten, "Arrbewertung" => $Arrbewertung));
    } catch (Exception $e) {
    }

    mysqli_free_result($resultinfo);
    mysqli_free_result($resultzutaten);
    mysqli_free_result($resultbewertung);
    mysqli_close($link);
}
