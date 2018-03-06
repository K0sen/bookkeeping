<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    @include('pieces.meta-header')
    <title>Bookkeeping</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Raleway:300,600" rel="stylesheet" type="text/css">

    <!-- Styles -->
    @include('pieces.bootstrap-style')
    <link href="{{ asset('css/style-upload.min.css') }}" rel="stylesheet">
</head>
<body>

<div class="wrapper">
    <header>
        <form action="{{ route('truncate') }}" method="post">
            {{ csrf_field() }}
            <button class="btn btn-link">Truncate db</button>
        </form>
    </header>
    <main class="container main">
        <section class="upload">
            @include('pieces.upload.form')
            <div class="loader">
                <div>It may take a time (up to 30 sec :( )</div>
                <img src="{{ asset('images/dogloader-dribbble.gif') }}" alt="loader">
            </div>
        </section>
    </main>

</div>

@include('pieces.bootstrap-scripts')
<script src="{{ asset('js/scripts-upload.js') }}"></script>
</body>
</html>
