<fieldset >
    <legend class="Überschrift"> Speisenliste filtern</legend>
    <form method="get">
        <select class="form-control border-dark" id="Speise" name="categorie">
            {{$optgroupname = "Gernerell"}}
                    <optgroup label="{{$optgroupname}}">
                    <option value="-1">Alle zeigen</option>';
                        @foreach($ArrKategorien as $row)
                            @if($row['Ober_Kategorie'] != $optgroupname)
                                {{$optgroupname = $row['Ober_Kategorie']}}
                                </optgroup> <optgroup label="{{$optgroupname}}">
                            @endif
                                <option
                    @if (isset($_GET['categorie']) && $_GET['categorie'] == $row['ID'])selected @endif
                    value="{{$row['ID']}}" >{{$row['Unter_Kategorie']}}</option>
                @endforeach
            </optgroup>
        </select>

        <ul>
            <li>
                <label class="form-check-label ">
                    <input class="form-check-input" type="checkbox" @if (isset($_GET['avail'])) checked @endif name="avail" value="1">nur verfügbar
                </label>
            </li>
            <li>
                <label class="form-check-label ">
                    <input class="form-check-input" type="checkbox" @if (isset($_GET['vegetarisch']) == true)checked @endif name="vegetarisch" value="true" >nur vegetarische
                </label>
            </li>
            <li>
                <label class="form-check-label">
                    <input class="form-check-input" type="checkbox" @if (isset($_GET['vegan']) == true ) checked @endif name="vegan" value="true">nur vegane
                </label>
            </li>
        </ul>
        <button class="btn btn-outline-dark btn-block" type="submit">Speisen filtern</button>
    </form>
</fieldset>
