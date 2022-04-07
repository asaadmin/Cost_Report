<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('partials.head')
    </head>
    <body>
        <div class="container">
        <header class="row">
            @include('partials.header')
        </header>
        <div id="main" class="row">
                @yield('content')
        </div>
        <footer class="row">
            @include('partials.footer')
        </footer>
        </div>
    </body>
</html>