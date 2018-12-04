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
<div id="app" class="admin">

    <nav class="navbar navbar-fixed-top navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="{{ route( 'home' ) }}">
            {{ config( 'app.name' ) }}
        </a>

        <span class="navbar-text mr-3 ml-auto">
            {{ Auth::user()->name }}
        </span>

        <form class="form-inline" action="{{ route( 'logout' ) }}" method="post">
            {{ csrf_field() }}
            <button class="btn btn-info" type="submit">{{ __( 'Sign out' ) }}</button>
        </form>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-4 col-md-3 mt-3 sidebar">
                <div class="list-group">
                    @foreach( Menu::getItems( 'admin' ) as $menuItem )
                        <a href="{{ $menuItem->url }}" class="list-group-item list-group-item-action @if( $menuItem->isActive() ) active @endif">
                            {{ $menuItem->title }}
                        </a>
                    @endforeach
                </div>
            </div>
            <div class="col-sm-8 col-md-9 pt-3 content">
                @yield( 'content' )
            </div>
        </div>
    </div>
</div>
</body>
</html>
