<div class="row my-1" id="bottombar">
    <div class="col align-self-center"  id="Copyright">
        <i class="far fa-copyright"></i> 2019 DBWT</div>
    <nav class="col-auto align-self-center my-1" id="inhalt2">
        <ul class="nav" >
            <li class="nav-item">
                <a class="nav-link <?php if($_SERVER['REQUEST_URI'] == "/M2/#") echo "disabled"; ?>" href="#">Login </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php if($_SERVER['REQUEST_URI'] == "/M2/#") echo "disabled"; ?>" href="#">Registrieren </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php if($_SERVER['REQUEST_URI'] == "/M2/Zutaten.php") echo "disabled"; ?>" href="Zutaten.php">Zutatenliste </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php if($_SERVER['REQUEST_URI'] == "/M2/Impressum.php") echo "disabled"; ?>" href="Impressum.php">Impressum </a>
            </li>
        </ul>
    </nav>
    <div class="col"></div>
</div>