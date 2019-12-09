<table class="table table-striped border border-dark">
    <thead>
    <tr>
        <th scope="col">Zutat</th>
        <th scope="col">Vegan?</th>
        <th scope="col">Vegetarisch?</th>
        <th scope="col">Glutenfrei?</th>
    </tr>
    </thead>
    <tbody>
    @foreach($zutatenarray as $row)
        <td id="id-{{$row['ID']}}">
            <form action="http://www.google.de/search" method="GET" target="_blank" style="margin-bottom: 0px;">
                <input class="btn btn-link" style="color:#00b5ad; margin: 0" data-toggle="tooltip" title="Suchen Sie nach {{$row['Name']}} im Web" type="submit" name="q" value="{{$row['Name']}}">
                @if ($row['Bio'] == 1) <span> </span><img width="20" height="20" src="pic/bio-icon.svg" alt="Bio">@endif
            </form>
        </td>
        <td>
            @if ($row['Vegan'] == 1) <i class="far fa-check-circle"></i> @else <i class="far fa-circle"></i> @endif
        </td>
        <td>
            @if ($row['Vegetarisch'] == 1) <i class="far fa-check-circle"></i> @else <i class="far fa-circle"></i> @endif
        </td>
        <td>
            @if ($row['Glutenfrei'] == 1) <i class="far fa-check-circle"></i> @else <i class="far fa-circle"></i> @endif
        </td>
        </tr>
    @endforeach
    </tbody>
</table>