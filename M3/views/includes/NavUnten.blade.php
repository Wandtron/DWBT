<div class="row my-1" id="bottombar">
    <div class="col align-self-center"  id="Copyright">
        <i class="far fa-copyright"></i> 2019 DBWT</div>
    <nav class="col-auto align-self-center my-1" id="inhalt2">
        <ul class="nav" >
            @php $a = $_SERVER['REQUEST_URI']; @endphp
            <li class="nav-item">
                @if(isset($_SESSION['user']) && isset($_SESSION['role']))
                   <a class="nav-link @if(strpos($a, 'Login')) disabled @endif" href="Login.php">Logout </a>
                @else
                    <a class="nav-link @if(strpos($a, 'Login')) disabled @endif" href="Login.php">Login </a>
                @endif

            </li>
            <li class="nav-item">
                <a class="nav-link @if(strpos($a, 'Registrierung')) disabled @endif" href="Registrierung.php">Registrieren </a>
            </li>
            <li class="nav-item">
                <a class="nav-link @if(strpos($a, 'Zutaten')) disabled @endif" href="Zutaten.php">Zutatenliste </a>
            </li>
            <li class="nav-item">
                <a class="nav-link @if(strpos($a, 'Impressum')) disabled @endif" href="Impressum.php">Impressum </a>
            </li>
        </ul>
    </nav>
    <div class="col"></div>
</div>