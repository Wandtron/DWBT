@extends('layouts.app')

@section('title')
    Produkte
@endsection

@section('content')

        <div class="row">
            <div class="col text-center">
                <h3>Verfügbare Speisen @if(sizeof($ArrThisKategory) != 0) ({{$ArrThisKategory[0]['Bezeichnung']}}) @else ()(Bestseller) @endif</h3>
            </div>

        </div>
        <div class="row">
            <div class="col-3">
                @include("includes.Produktefilter")
            </div>
            <div class="col-6">
                <div class="row">
                    @if (sizeof($ArrMahleiten) == 0)
                        <div class="col text-center"><h3>Keine Mahlzeiten gefunden :( </h3></div>
                    @endif
                    @foreach($ArrMahleiten as $row)
                            @if ($row['Vorrat'] <= 0)
                                <div class="col-3">
                                    <figure class="figure border my-1 rounded border-dark vergriffen">
                                        <img width="100" class="rounded" height="100"  alt="{{$row['Alt-Text']}}" src="data:image/gif;base64,@php echo  base64_encode($row['Binärdaten']) @endphp">
                                        <figcaption class="figure-caption text-center">{{$row['Name']}}<br>vergriffen</figcaption>
                                    </figure>
                                </div>
                            @else
                                <div class="col-3">
                                    <figure class="figure border my-1 rounded border-dark ">
                                        <img width="100" class="rounded" height="100"  alt="{{$row['Alt-Text']}}" src="data:image/gif;base64,@php echo  base64_encode($row['Binärdaten']) @endphp">
                                        <figcaption class="figure-caption text-center"><form action="Detail.php" method="GET">{{$row['Name']}}<br>
                                                <input name="id" type="hidden" value="{{$row['ID']}}" />
                                                <input class="btn btn-link btn-sm" style="color:#00b5ad;" data-toggle="tooltip" title="Mehr Details zu ' . $row['Name'] . ' herausfinden" type="submit" value="Details">
                                            </form>
                                        </figcaption>
                                    </figure>
                                </div>
                            @endif
                        @endforeach
                </div>
            </div>
        </div>
@endsection