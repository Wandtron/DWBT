<!-- Stored in views/pages/registrationFinal.blade.php -->

@extends('layouts.app')

@section('title')
    Benutzerdaten
@endsection

@section('content')
    <h2>Ihre Benutzerdaten  {{$_SESSION['role']}}</h2>
    <form method="POST" action="">
        <div>
            <label for="vorname">Vorname:</label>
            <input class="form-control"   type="text" id="vorname" name="vorname" required>
        </div>
        <div>
            <label for="nachname">Nachname:</label>
            <input class="form-control"   type="text" id="nachname" name="nachname" required>
        </div>
        <div>
            <label for="email">E-Mail:</label>
            <input class="form-control"   type="text" id="email" name="email" required>
        </div>
        <div>
            <label for="geburtstag">Geburtsdatum:</label>
            <input class="form-control"    type="date" id="geburtstag" name="geburtstag"  required>
        </div>
        @if($_SESSION['role'] == "Student" || $_SESSION['role'] == "Mitarbeiter")
            <h2>Ihr Fachbereich</h2>
            <div>
                <label for="fb">Welchen Fachbereichen gehören Sie an?
                    <select name="fb" size="5">
                        <option value="Architektur">Architektur</option>
                        <option value="Bauingenieurwesen">Bauingenieurwesen</option>
                        <option value="Chemie und Biotechnologie">Chemie und Biotechnologie</option>
                        <option value="Gestaltung">Gestaltung</option>
                        <option value="Elektrotechnik und Informationstechnik">Elektrotechnik und Informationstechnik</option>
                        <option value="Luft- und Raumfahrttechnik">Luft- und Raumfahrttechnik</option>
                        <option value="Wirtschaftswissenschaften">Wirtschaftswissenschaften</option>
                        <option value="Maschinenbau und Mechatronik">Maschinenbau und Mechatronik</option>
                        <option value="Medizintechnik und Technomathematik">Medizintechnik und Technomathematik</option>
                        <option value="Energietechnik">Energietechnik</option>
                    </select>
                </label>
            </div>
        @endif
        @if($_SESSION['role'] == "Student")
        <h2>Ihre Daten als Student</h2>
        <div>
            <label for="matnr">Matrikelnummer</label>
            <input class="form-control"   type="text" id="matnr" name="matnr" required>
        </div>
        <div>
            <label for="studiengang">Studiengang</label>
            <select name="type" id="type">
                <option value="ET">ET</option>
                <option value="INF">INF</option>
                <option value="ISE">ISE</option>
                <option value="MCD">MCD</option>
                <option value="WI">WI</option>
            </select>
        </div>
        @endif
        <div>
            <button class=" btn-outline-dark btn btn-default" type="submit" name="submit2">Senden</button>
        </div>
    </form>
@endsection