
<div>Categories added: {{ $catCount }}</div>
<div>Groups added: {{ $groupCount }}</div>
<div>Transactions added: {{ $transCount }}</div>
<div>Script time: {{ $time }}</div>
<button type="button" class="close-info close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
</button>
<a href="{{ route('display') }}">Look at the table</a>