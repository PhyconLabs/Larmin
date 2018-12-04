<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @hasSection( 'title' )
        <title>@yield( 'title' ) - {{ config( 'app.name' ) }}</title>
    @else
        <title>{{ config( 'app.name' ) }}</title>
    @endif

    <script src="{{ asset( 'js/admin.js' ) }}" defer></script>
    <link href="{{ asset( 'css/admin.css' ) }}" rel="stylesheet">
</head>
<body>
<div id="app">
    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-6 col-lg-4 col-xl-4">

                <div class="row justify-content-center mb-3">
                    @if( config( 'larmin.logo_path' ) )
                        <div class="text-center col-6 col-sm-6">
                            <a href="/" class="login-logo">
                                <img class="img-fluid" src="{{ asset( config( 'larmin.logo_path' ) ) }}" alt="{{ config( 'app.name' ) }} logo">
                            </a>
                        </div>
                    @endif
                </div>

                @yield( 'content' )
            </div>
        </div>
    </div>
</div>
</body>
</html>
