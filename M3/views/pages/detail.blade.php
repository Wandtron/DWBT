@extends('layouts.app')
@foreach($Arrinfo as $rowinfo)@endforeach
@section('title')
    @if (sizeof($Arrinfo) != 0)
    Details für: "{{$rowinfo['Name']}}"
    @else
    Details
    @endif
@endsection

@if (sizeof($Arrinfo) == 0)
    <head> <meta http-equiv="refresh" content="3; URL=Produkte.php"> </head>
@endif

@section('content')
    <div class="row" id="body1">
        <div class="col-3 bottom-manual2">
            @include("includes.Auth")
        </div>
        <div class="col-6">
            <div class="row mt-1 mb-1">
                <div class="col ">
                    <h2>Details für "@if (sizeof($Arrinfo) != 0){{$rowinfo['Name']}}@else???@endif"</h2>

                </div>
            </div>
            <div class="row mt-1 mb-1 ">
                <div class="col">
                @if (sizeof($Arrinfo) == 0) <img alt="Kein Bild gefunden" style="height: 250px;" class="rounded img-fluid w-100" src="pic/Artistic-4K-Wallpaper-3840x2160-banner.jpg"/>
                    @elseif ($rowinfo['Alt-Text'] == '') <img alt="Kein Bild gefunden" style="height: 250px;" class="rounded img-fluid w-100" src="pic/Artistic-4K-Wallpaper-3840x2160-banner.jpg"/>
                    @else
                            <img class="rounded img-fluid w-100" style="height: 250px;"  alt="{{$rowinfo['Alt-Text']}}" src="data:image/gif;base64,@php echo  base64_encode($Arrinfo[0]['Binärdaten']) @endphp">
                    @endif

                </div>
            </div>

        </div>
        <div class="col-3">

            <div class="row mt-4" id="preis">
                <div class="col text-right">
                    @if(isset($_SESSION['role'])) {{$_SESSION['role']}}-Preis
                    @else Gast-Preis
                        @endif
                </div>
            </div>
            <div class="row" >
                <div class="col text-right">
                    @if (sizeof($Arrinfo) == 0)
                        <h2>Kein Gericht gefunden</h2>
                    @elseif ($rowinfo['Jahr'] == '')
                    <h2>kein Preis vorhanden</h2>
                    @else
                        @if(isset($_SESSION['role']) && $_SESSION['role'] == "Student")
                            <h2>{{$rowinfo['Student-preis']}} </h2>
                        @elseif(isset($_SESSION['role']) && $_SESSION['role'] == "Mitarbeiter")
                            <h2>{{$rowinfo['MA-Preis']}}</h2>
                        @else
                            <h2>{{$rowinfo['Gastpreis']}}</h2>
                        @endif
                    @endif
                </div>
            </div>
            <div class="row align-items-end">
                <div class="col ">
                    <button class="btn btn-outline-dark btn-block bottom-manual" type="button"><i class="fas fa-utensils"></i> Vorbestellen</button>
                </div>
            </div>
        </div>
    </div>
    <div class="row" id="body2">
        <div class="col-3">
            Melden Sie sich jetzt an, um die wirklich viel günstigeren Preise für Mitarbeiter oder Studenten zu sehen.
        </div>
        <div class="col-6">
            <div class="row mt-1 mb-1">
                <div class="col">
                    <div class="container">
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs " id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active " id="beschreibung-tab" data-toggle="tab" href="#beschreibung" role="tab"  aria-selected="true">Beschreibung</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link " id="zutaten-tab" data-toggle="tab" href="#zutaten" role="tab"  aria-selected="false">Zutaten</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link " id="Bewertungen-tab" data-toggle="tab" href="#Bewertungen" role="tab" aria-selected="false">Bewertungen</a>
                            </li>
                        </ul>

                        <!-- Tab panes -->
                        <div class="tab-content border border-top-0 ">
                            <div class="tab-pane active" id="beschreibung" role="tabpanel" aria-labelledby="beschreibung-tab">
                                @if(sizeof($Arrinfo) != 0)
                                {{$rowinfo['Beschreibung']}}
                                @endif
                            </div>
                            <div class="tab-pane " id="zutaten" role="tabpanel" aria-labelledby="zutaten-tab">
                                @include("includes.Zutatentabelle", array("zutatenarray" => $Arrzutaten))

                            </div>
                            <div class="tab-pane" id="Bewertungen" role="tabpanel" aria-labelledby="Bewertungen-tab">
                                @include("includes.Bewertung", array("Arrbewertung" => $Arrbewertung))
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-3 ">
        </div>
    </div>

@endsection