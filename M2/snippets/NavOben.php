<div class="row my-1 " id="topbar">
    <div class="col-3 align-self-center " id="Namewebsite">e-Mensa</div>
    <nav class="col-6 align-self-center justify-content-center" id="inhalt">
        <ul class="nav justify-content-center my-1" >
            <li class="nav-item">
                <a class="nav-link <?php
                $a = $_SERVER['REQUEST_URI'];
                if(strpos($a, 'Start')) echo "disabled"; ?>" href="Start.php">Startseite </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php if(strpos($a, 'Produkte')) echo "disabled"; ?>" href="Produkte.php">Mahlzeiten </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php if(strpos($a, '/M2/#')) echo "disabled"; ?>" href="#">Bestellungen </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php if(strpos($a, '/M2/#')) echo "disabled"; ?>" href="https://www.fh-aachen.de/studium/informatik-bsc/" target="_blank">FH-Aachen </a>
            </li>
        </ul>
    </nav>
    <div class="col-3  align-self-center ">
        <form action="http://www.google.de/search" class="input-group" method="GET" target="_blank">
            <input name="as_sitesearch" type="hidden" value="www.fh-aachen.de" />
            <div class="input-group ">
                <div class="input-group-prepend">
                    <button class="btn btn-outline-dark" id="button-addon1" type="submit"><i class="fa fa-search"></i></button>
                </div>
                <input aria-label="Search" class="form-control border-dark"  name="q" placeholder="Suchen..." type="text">
            </div>
        </form>
    </div>
</div>