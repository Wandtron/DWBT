
@extends('layouts.app')

@section('title')
    Login
@endsection

@section('content')
    {{-- Rolle {{$_SESSION['role']}}  Eingeloggt  {{$_SESSION['loggedin']}} Nutzer {{$_SESSION['user']}} Loginname: {{$_SESSION['nickname']}}  {{$_SESSION['id']}}--}}
    @include("includes.Auth")
    @if(isset($_SESSION['loggedin']))
        <div class="row">
            <div class="col">

                <p></p>
                <p>Deine Account Daten sind hier aufgelistet:</p>
                <table>
                    <tr>
                        <td>Nutzername:</td>
                        <td>{{$_SESSION['nickname']}} </td>
                    </tr>
                    <tr>
                        <td>Nummer:</td>
                        <td>{{$_SESSION['id']}}</td>
                    </tr>
                    <tr>
                        <td>E-Mail:</td>
                        <td>{{$_SESSION['E-Mail']}}</td>
                    </tr>
                </table>
            </div>
        </div>
    @endif
 @endsection