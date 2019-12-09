<!-- Stored in views/pages/zutaten.blade.php -->

@extends('layouts.app')

@section('title')
    Zutatenliste ({{sizeof($myArr)}})
@endsection

@section('content')
@include("includes.Zutatentabelle",array("zutatenarray" => $myArr))
@endsection