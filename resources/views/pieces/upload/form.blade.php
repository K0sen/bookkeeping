
<form class="file-upload" action="{{ route('load') }}" method="POST" enctype="multipart/form-data">
    {{ csrf_field() }}
    <label for="inputFile" class="file-upload__label">Upload the table (be sure that it is the <strong>csv</strong> file).</label>
    <input name="file" type="file" class="form-group form-control-file file-upload__input" id="inputFile" aria-describedby="fileHelp" required>
    <div class="form-group file-upload__date-set">
        <label for="date-from">From</label>
        <input id="date-from" name="date-from" class="date-set__from" type="date" value="2014-10-01" required>
        <label for="date-to">To</label>
        <input id="date-to" name="date-to" class="date-set__to" type="date" value="2015-09-30" required>
    </div>
    <button class="btn btn-dark">Load</button>
</form>

