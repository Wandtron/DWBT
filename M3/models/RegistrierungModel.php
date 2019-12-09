<?php
namespace Emensa\Model{
    require "vendor/autoload.php";
    require_once('Db.php');
    session_start();


    class RegistrierungModel
    {
        public function getRegistrierungFirstPage()
        {
            $db = new \Db();
            $remoteConnection = $db->connect();
            $value = false;
            $message = array();
            if (isset($_POST['submit'])) {
                if (isset($_POST['nickname']) && isset($_POST['passwort']) && isset($_POST['passwort_again'])) {
                    if ($_POST['passwort'] == $_POST['passwort_again']) {
                        if ((isset($_POST['role']))) {
                            if (!empty($_POST['role'])) {
                                foreach ($_POST['role'] as $role) {
                                    $_SESSION['role'] = $role;
                                }
                            }
                            if ($stmt = $remoteConnection->prepare('SELECT Nummer, `Hash` FROM Benutzer WHERE Nutzername = ? ;')) {
                                $stmt->bind_param('s', $_POST['nickname']);
                                $stmt->execute();
                                $stmt->store_result();
                                if ($stmt->num_rows == 0) {
                                    $passwort = $_POST['passwort'];
                                    $_SESSION['Nutzername'] = $_POST['nickname'];
                                    $_SESSION['passwort'] = password_hash($passwort, PASSWORD_BCRYPT);
                                    //Setze Wert auf true und leite auf zweite Seiet
                                    $value = true;
                                } else {
                                    $message['err'] = 'Nutzername existiert bereits';
                                    session_destroy();
                                    session_start();
                                    $_SESSION['errmessage'] = $message['err'];
                                }
                            }
                            if (mysqli_connect_errno()) {   // Connection check
                                printf("Konnte nicht zur entfernten Datenbank verbinden: %s\n", mysqli_connect_error());
                                exit();
                            }
                        } else {
                            $message['err'] = 'Bitte eine Checkbox auswählen';
                            session_destroy();
                            session_start();
                            $_SESSION['errmessage'] = $message['err'];
                        }
                    } else {
                        $message['err'] = 'Die eingegebenen Passwörter stimmen nicht überein.';
                        session_destroy();
                        session_start();
                        $_SESSION['errmessage'] = $message['err'];
                    }
                } else {
                    $message['err'] = 'Bitte alle Felder ausfüllen';
                    session_destroy();
                    session_start();
                    $_SESSION['errmessage'] = $message['err'];
                }
            }
            mysqli_close($remoteConnection);
            return $value;
        }


        public function getRegistrierungSecondPage()
        {
            $db = new \Db();
            $remoteConnection = $db->connect();
            $value = false;
            $message = array();
            if (isset($_POST['submit2'])) {
                if (!(empty($_POST['vorname'])) || !(empty($_POST['nachname'])) || !(empty($_POST['email'])) || !(empty($_POST['geburtstag'])) || !(empty($_POST['fb']))) {
                    if ($stmt = $remoteConnection->prepare('SELECT `Nummer`, `Hash` FROM Benutzer WHERE `E-Mail` =?;')) {
                        $stmt->bind_param('s', $_POST['email']);
                        $stmt->execute();
                        $stmt->store_result();
                        if ($stmt->num_rows == 0) {
                            $nickname = $_SESSION['Nutzername'];
                            $passwort = $_SESSION['passwort'];
                            if (!(empty($_POST['matnr']))) { //Ist der Nutzer ein Student
                                $_SESSION['matnr'] = $_POST['matnr'];
                                if ($query = $remoteConnection->prepare('SELECT Matrikelnummer FROM Studenten WHERE Matrikelnummer =?;')) {
                                    $query->bind_param('s', $_POST['matnr']);
                                    $query->execute();
                                    // Ergebnis speichern
                                    $query->store_result();
                                    if ($query->num_rows == 0) {
                                        //Kein Eintrag gefunden.. Studenten Registrierung
                                        if ($_SESSION['role'] == 'Student') {
                                            $mysqli=$remoteConnection;
                                            $mysqli->autocommit(FALSE);
                                            $queryInsert = "INSERT INTO `Benutzer` (`Vorname`, `Nachname`, `Hash`, `Nutzername`, `E-Mail`, `Geburtsdatum`, `Aktiv`)
                                        VALUES('" . $_POST['vorname'] . "', '" . $_POST['nachname'] . "', '" . $passwort . "', '" . $nickname . "', '" . $_POST['email'] . "', '" . $_POST['geburtstag'] . "', 1);";
                                            if ($mysqli->query($queryInsert)) {
                                                $last_id = mysqli_insert_id($remoteConnection);
                                                if (isset($_POST['type'])) {
                                                    $_SESSION['studgang'] = $_POST['type'];
                                                    $queryFH = "INSERT INTO `FH Angehörige` (`FHAngehörig_ID`) VALUES((SELECT `Nummer` FROM `Benutzer` WHERE `Nutzername` = '" . $nickname . "'));";
                                                    if(!$mysqli->query($queryFH)){
                                                        session_destroy();
                                                        session_start();
                                                        $_SESSION['errmessage'] = mysqli_error($mysqli);
                                                        $mysqli->rollback();
                                                        exit(header('Location: Registrierung.php'));
                                                    }
                                                    $querySTU = "INSERT INTO `Studenten` (`Student_ID`, `Matrikelnummer`, `Studiengang`) VALUES((SELECT `Nummer` FROM `Benutzer` WHERE `Nutzername` = '" . $nickname . "'), '" . $_SESSION['matnr'] . "', '" . $_SESSION['studgang'] . "');";
                                                    if(!$mysqli->query($querySTU)){
                                                        $mysqli->rollback();
                                                        session_destroy();
                                                        session_start();
                                                        $_SESSION['errmessage'] = mysqli_error($mysqli);
                                                        $mysqli->rollback();
                                                        exit(header('Location: Registrierung.php'));
                                                    }
                                                    if(!$mysqli->commit()){
                                                        session_destroy();
                                                        session_start();
                                                        $_SESSION['errmessage'] = mysqli_error($mysqli);
                                                        $mysqli->rollback();
                                                        exit(header('Location: Registrierung.php'));
                                                    }
                                                }
                                                $queryRolle = "SELECT CONCAT(b.`Vorname`,' ', b.`Nachname`) AS `Namevoll`, b.`Nummer` AS `Nummer`, `Rolle`, `Nutzername`, b.`E-Mail` AS `E-Mail` FROM `Rolle` r INNER JOIN `Benutzer` b ON r.`Nummer` = b.`Nummer` WHERE `Nutzername` = '" . $nickname . "';";   //Nutzerrolle als VIEW gespeichert...
                                                $resultRolle = mysqli_query($remoteConnection, $queryRolle);
                                                if (!mysqli_commit($mysqli)) {
                                                    session_destroy();
                                                    session_start();
                                                    $_SESSION['errmessage'] = mysqli_error($mysqli);
                                                    $mysqli->rollback();
                                                    exit(header('Location: Registrierung.php'));
                                                }
                                                if ($resultRolle) {
                                                    $rowRolle = mysqli_fetch_assoc($resultRolle);   //Speicher alle Daten in Array..
                                                    session_regenerate_id();
                                                    $_SESSION['role'] = $rowRolle['Rolle'];
                                                    $_SESSION['loggedin'] = true;
                                                    $_SESSION['user'] = $rowRolle['Namevoll'];
                                                    $_SESSION['nickname'] = $rowRolle['Nutzername'];
                                                    $_SESSION['id'] = $rowRolle['Nummer'];
                                                    $_SESSION['E-Mail'] = $rowRolle['E-Mail'];
                                                    $sql = 'UPDATE `Benutzer` SET LetzterLogin = CURRENT_TIMESTAMP() WHERE Nutzername="' . $nickname . '";';
                                                    mysqli_query($remoteConnection, $sql);
                                                    header('Location: login.php');
                                                } else {
                                                    $message['err'] = mysqli_error($remoteConnection);
                                                    session_destroy();
                                                    session_start();
                                                    $_SESSION['errmessage'] = $message['err'];
                                                }
                                            } else {
                                                $message['err'] = mysqli_error($remoteConnection);
                                                session_destroy();
                                                session_start();
                                                $_SESSION['errmessage'] = $message['err'];
                                            }
                                        }
                                    } else {
                                        //Eintrag gefunden..
                                        $message['err'] = 'Matrikelnummer bereits vorhanden';
                                        session_destroy();
                                        session_start();
                                        $_SESSION['errmessage'] = $message['err'];
                                    }
                                }
                            } else {
                                $mysqli=$remoteConnection;
                                $mysqli->autocommit(FALSE);

                                $queryInsert = "INSERT INTO `Benutzer` (`Vorname`, `Nachname`, `Hash`, `Nutzername`, `E-Mail`, `Geburtsdatum`, `Aktiv`)
                                        VALUES('" . $_POST['vorname'] . "', '" . $_POST['nachname'] . "', '" . $passwort . "', '" . $nickname . "', '" . $_POST['email'] . "', '" . $_POST['geburtstag'] . "', 1)";
                                if ($mysqli->query($queryInsert)) {
                                    $last_id = mysqli_insert_id($remoteConnection);
                                    //echo $last_id;
                                    if ($_SESSION['role'] == 'Mitarbeiter') {
                                        $queryFH = "INSERT INTO `FH Angehörige` (`FHAngehörig_ID`) VALUES((SELECT `Nummer` FROM `Benutzer` WHERE `Nutzername` = '" . $nickname . "'));";
                                        if(!$mysqli->query($queryFH)) {
                                            session_destroy();
                                            session_start();
                                            $_SESSION['errmessage'] = mysqli_error($mysqli);
                                            $mysqli->rollback();
                                            exit(header('Location: Registrierung.php'));
                                        }
                                        $queryMA = "INSERT INTO `Mitarbeiter` (`Mitarbeiter_ID`, `Telefon`) VALUES((SELECT `Nummer` FROM `Benutzer` WHERE `Nutzername` = '" . $nickname . "'),(SELECT `Nummer` FROM `Benutzer` WHERE `Nutzername` = '" . $nickname . "'));";
                                        if(!$mysqli->query($queryMA)){
                                            session_destroy();
                                            session_start();
                                            $_SESSION['errmessage'] = mysqli_error($mysqli);
                                            $mysqli->rollback();
                                            exit(header('Location: Registrierung.php'));
                                        }
                                    } elseif ($_SESSION['role'] == 'Gast') {
                                        $queryGAST = ("INSERT INTO `Gäste` (`Grund`, `Gäste_ID`) VALUES('not set' ,(SELECT `Nummer` FROM `Benutzer` WHERE `Nutzername` = '" . $nickname . "'));");
                                        if(!$mysqli->query($queryGAST)){
                                            session_destroy();
                                            session_start();
                                            $_SESSION['errmessage'] = mysqli_error($mysqli);
                                            $mysqli->rollback();
                                            exit(header('Location: Registrierung.php'));
                                        }

                                    }

                                    $queryRolle = "SELECT CONCAT(b.`Vorname`,' ', b.`Nachname`) AS `Namevoll`, b.`Nummer` AS `Nummer`, `Rolle`, `Nutzername`, b.`E-Mail` AS `E-Mail` FROM `Rolle` r INNER JOIN `Benutzer` b ON r.`Nummer` = b.`Nummer` WHERE `Nutzername` = '" . $nickname . "';";   //Nutzerrolle als VIEW gespeichert...
                                    $resultRolle = mysqli_query($remoteConnection, $queryRolle);
                                    if (!mysqli_commit($mysqli)) {
                                        session_destroy();
                                        session_start();
                                        $_SESSION['errmessage'] = mysqli_error($mysqli);
                                        $mysqli->rollback();
                                        exit(header('Location: Registrierung.php'));
                                    }
                                    if ($resultRolle) {
                                        $rowRolle = mysqli_fetch_assoc($resultRolle);   //Speicher alle Daten in Array..
                                        session_regenerate_id();
                                        $_SESSION['role'] = $rowRolle['Rolle'];
                                        $_SESSION['loggedin'] = true;
                                        $_SESSION['user'] = $rowRolle['Namevoll'];
                                        $_SESSION['nickname'] = $rowRolle['Nutzername'];
                                        $_SESSION['id'] = $rowRolle['Nummer'];
                                        $_SESSION['E-Mail'] = $rowRolle['E-Mail'];
                                        $sql = 'UPDATE `Benutzer` SET `LetzterLogin` = CURRENT_TIMESTAMP() WHERE `Nutzername`="' . $nickname . '";';
                                        mysqli_query($remoteConnection, $sql);
                                        header('Location: login.php');

                                    } else {
                                        $message['err'] = mysqli_error($remoteConnection);
                                        session_destroy();
                                        session_start();
                                        $_SESSION['errmessage'] = $message['err'];
                                    }

                                } else {
                                    $message['err'] = mysqli_error($remoteConnection);
                                    session_destroy();
                                    session_start();
                                    $_SESSION['errmessage'] = $message['err'];
                                }

                            }
                        } else {
                            $message['err'] = 'Email existiert bereits';
                            session_destroy();
                            session_start();
                            $_SESSION['errmessage'] = $message['err'];
                        }
                    }
                } else {
                    $message['err'] = 'Es wurden nicht alle Felder ausgefüllt.';
                    session_destroy();
                    session_start();
                    $_SESSION['errmessage'] = $message['err'];
                }
                mysqli_close($remoteConnection);
                return $value;
            }
        }


    }
}


