<!-- Stored in views/pages/registration.blade.php -->

@extends('layouts.app')

@section('title')
    Registrieren
@endsection

@section('content')
    <h2>Ihre Registrierung</h2>
    @if(isset($_SESSION['errmessage']))
    <div class="alert alert-danger" style="display:inline-block; background-color: #FA5858"
         role="alert">{{$_SESSION['errmessage']}}</div>
    @endif
    @if(isset($_SESSION['err']))
        <div class="alert alert-danger" style="display:inline-block; background-color: #FA5858"
             role="alert">{{$_SESSION['err']}}</div>
    @endif
    <form method="POST" action="">
        <div>
            <label for="nickname">Nickname:</label>
            <input class="form-control"   type="text" id="nickname" name="nickname" required>
        </div>
        <div>
            <label for="passwort">Passwort:</label>
            <input class="form-control"   type="passwort" id="passwort" name="passwort" minlength="10" required >
            <p>Das Passwort muss mindestens 10 Zeichen lang sein und mindestens eine Ziffer und ein<br>
                Sonderzeichen enthalten.</p>
        </div>
        <div>
            <label for="passwort">Passwort:</label>
            <input class="form-control"   type="passwort" id="passwort_again" name="passwort_again" minlength="10" required>
            <p>Hier müssen Sie das Passwort wiederholen.</p>
        </div>
        <div>
            <input type="checkbox" id="gast" name="role[]" value="Gast">Ich bin Gast<br>
            <input type="checkbox" id="ma" name="role[]" value="Mitarbeiter">Ich arbeite an der FH<br>
            <input type="checkbox" id="student" name="role[]" value="Student">Ich studiere an der FH<br>
        </div>
        <div>
            <button class=" btn-outline-dark btn btn-default" type="submit" name="submit">Registrierung fortsetzen</button>
        </div>
    </form>
@endsection