<?php
namespace Emensa\Model {
    session_start();
    include('./db.php');

    $sql = 'SELECT ID,Name,Vegan,Vegetarisch,Glutenfrei,Bio FROM `zutaten` ORDER BY Bio DESC,Name;';
    $result = mysqli_query($remoteConnection, $sql);
    $count = mysqli_num_rows($result);
    mysqli_close($remoteConnection);
    $myArr = array();
    while($row = mysqli_fetch_array($result)) {
        array_push($myArr, $row);
    }
}