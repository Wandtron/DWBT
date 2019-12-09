<!-- Stored in resources/views/child.blade.php -->
<html lang="de">

    <head>

        @include('includes.head')

        <title>@yield('title')</title>

    </head>
    <body>
        <div class="container">
            @include('includes.NavOben')
            @yield('content')
            @include('includes.NavUnten')
        </div>
    </body>
</html>