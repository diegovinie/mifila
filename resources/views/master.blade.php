<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Laravel</title>

        <!-- Fonts -->
        {{-- <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css"> --}}

        <link rel="stylesheet" href="/css/app.css">

        <script type="text/javascript">
          window.APP_URL = '{{ env('APP_URL') }}';
        </script>
    </head>
    <body id="page-top">
        @include('partials.menu')

        <div class="container-fluid">
            <div id="app">
                @yield('content')
            </div>
        </div>
        {{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> --}}
        <script src="/js/app.js" charset="utf-8" defer async></script>
    </body>
</html>
