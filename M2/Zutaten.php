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
$query = 'SELECT * FROM zutaten ORDER BY Bio DESC, Name;'; //Ihre SQL Query aus HeidiSQL
$result = mysqli_query($link, $query);
$anzahl = (int) 0;
if (empty($result)) {
    $anzahl = 0;
}
else {
    $anzahl = mysqli_num_rows($result);
}

$title = "Zutatenliste (" .$anzahl. ")";
?>
<?php include 'snippets/Head.php'; ?>
<body>
<div class="container">
    <?php include 'snippets/NavOben.php';?>

    <div class="row">
        <div class="col">

        <table class="table table-striped border border-dark">
            <thead>
            <tr>
                <th scope="col">Zutat</th>
                <th scope="col">Vegan?</th>
                <th scope="col">Vegetarisch?</th>
                <th scope="col">Glutenfrei?</th>
            </tr>
            </thead>
            <tbody>
            <?php
            if (mysqli_connect_errno()) {
                printf("Konnte nicht zur entfernten Datenbank verbinden: %s\n", mysqli_connect_error());
                exit();
            }
            if ($result = mysqli_query($link, $query)) {
                while ($row = mysqli_fetch_assoc($result)) {
                    // $row['ID'] und $row['Name'] stehen aus der Query zur Verfügung
                    echo '<tr>
                        <th scope="row" id="id-' . $row['ID'] . '">         
                        <form action="http://www.google.de/search" method="GET" target="_blank">
                        <input class="btn btn-link btn-sm" style="color:#00b5ad;" data-toggle="tooltip" title="Suchen Sie nach ' . $row['Name'] . ' im Web" type="submit" name="q" value="' . $row['Name'] . '">';
                    if ($row['Bio'] == 1) echo '<span> </span><img width="20" height="20" src="pic/bio-icon.svg" alt="Bio">';
                    echo '</form> </th> <td>';
                    if ($row['Vegan'] == 1) echo "<i class=\"far fa-check-circle\"></i>"; else echo "<i class=\"far fa-circle\"></i>";
                    echo '</td> <td>';
                    if ($row['Vegetarisch'] == 1) echo "<i class=\"far fa-check-circle\"></i>"; else echo "<i class=\"far fa-circle\"></i>";
                    echo '</td> <td>';
                    if ($row['Glutenfrei'] == 1) echo "<i class=\"far fa-check-circle\"></i>"; else echo "<i class=\"far fa-circle\"></i>";
                    echo '</td> </tr>';
                    }

            }
            ?>
            </tbody>
        </table>
        </div>
    </div>
    <?php include 'snippets/NavUnten.php';?>
</div>
<?php mysqli_close($link); // daran denken, die Verbindung wieder zu schließen wenn sie nicht mehr benötigt ist. ?>
</body>
</html>
