<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    @include('pieces.meta-header')
    <title>Bookkeeping</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Lobster&amp;subset=cyrillic" rel="stylesheet">

    <!-- Styles -->
    @include('pieces.bootstrap-style')
    <link href="{{ asset('css/style-display.min.css') }}" rel="stylesheet">
</head>
<body>

<div class="wrapper">

    <header class="header">
        <a class="to-top" href="#">Top&nbsp;</a><br>
        <a href="{{ route('home') }}">Home&nbsp;</a>
        <form action="{{ route('truncate') }}" method="post">
            {{ csrf_field() }}
            <button class="btn btn-link">Truncate db</button>
        </form>
    </header>
    <main class="main" id="app">

        @include('pieces.display.form')

    </main>

</div>

@include('pieces.bootstrap-scripts')
<script src="{{ asset('js/scripts-display.js') }}"></script>
</body>
</html>
