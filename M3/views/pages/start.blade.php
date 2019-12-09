@extends('layouts.app')

@section('title')
    Start
@endsection

@section('content')
    <div class="row mt-1 mb-1 " id="banner">
        <div class="col">
            <img alt="ein kleines X" class="img-fluid width: 100% rounded" src="pic/Artistic-4K-Wallpaper-3840x2160-banner.jpg"/>
        </div>
    </div>
    <div class="row">
        <div class="col-3" id="hinweis">
            Der Dienst <b>e-Mensa</b> ist noch beta. Sie können bereits <a href="Produkte.php"> Mahlzeiten </a> durch Stöbern, aber noch nicht bestellen.
            <br><br>
            Registrieren Sie sich <a href="Registrierung.php"> hier </a>, um über die Veröffentlichung des Dienstes per Mail informiert zu werden.
        </div>
        <div class="col">
            <div class="row">
                <div class="col">
                    <h3>Leckere Gerichte vorbestellen</h3>...und gemeinsam mit Kommilitonen und Freunden essen
                </div>
                <div class="col-3">
                    <div class="row  mt-1 mb-1">
                        <div class="col">
                            <form method="get" action="Registrierung.php">
                            <button class="btn btn-outline-dark btn-block" type="submit"><i class="far fa-hand-point-right" ></i> Registrieren</button>
                            </form>
                        </div>
                    </div>
                    <div class="row  mt-1 mb-1">
                        <div class="col">
                            <form method="get" action="Login.php">
                            <button class="btn btn-outline-dark btn-block" type="submit"><i class="fas fa-sign-in-alt"></i>@if(isset($_SESSION['user']) && isset($_SESSION['role'])) Abmelden @else Anmelden @endif</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-1 mb-1">
                <div class="col">
                    <img alt="ein kleines X" class="img-fluid rounded" src="pic/Artistic-4K-Wallpaper-3840x2160-banner.jpg"/>
                </div>
            </div>
        </div>
    </div>
@endsection