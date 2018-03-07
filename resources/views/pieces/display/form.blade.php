
@if ($selectTable)

    <form id="form" method="get" action="{{ route('get-table') }}" class="form-display">
    <div>Select options for the table: </div>
    <div class="form-group">
        <label for="date-from">From</label>
        <input id="date-from" name="date-from" type="date" value="2014-10-01" required>
        <label for="date-to">To</label>
        <input id="date-to" name="date-to" type="date" value="2015-09-30" required>
    </div>
    <ul>
    @foreach ($selectTable as $categoryName => $groups)
        <li><label class="category-name"><input type="checkbox" class="unfold"> {{ $categoryName }}</label>
            <ul>
            @foreach ($groups as $groupName => $articles)
                <li class="collapsable"><label class="group-name"><input class="unfold" type="checkbox" > {{ $groupName }}</label>
                    <ul class="collapsable">
                    @foreach ($articles as $articleName => $articleCode)
                        <li><label><input class="form__article" name="articles{{ $articleCode }}" type="checkbox"> {{ $articleName }}</label></li>
                    @endforeach
                    </ul>
                </li>
            @endforeach
            </ul>
        </li>
    @endforeach
    <button class="btn btn-dark send">Render a table</button>
    </ul>

@else
    <div>No records in DB go <a href="{{ route('home') }}">here</a> to import table</div>
@endif
</form>

