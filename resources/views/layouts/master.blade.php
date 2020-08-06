<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'The Currency Ref.') }}</title>

        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" 
            integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <link rel="stylesheet" href="{{URL::to('css/styles.css')}}"/>
        
        <link href="https://fonts.googleapis.com/css?family=Patua+One&display=swap" rel="stylesheet">

        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" 
            integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" 
            integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" 
            integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
        <script src="https://kit.fontawesome.com/4aafddaf9b.js" crossorigin="anonymous" SameSite=None; Secure></script>
        
    </head>
    <body class="mainBackground pb-5">
        @include('partials.navbar')
        <div class="container py-4">
            @yield('content')
        </div>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js" charset="utf-8"></script>
        @if(\Request::is('rates*'))
            {!! $pieChart->script() !!}
            {!! $radarChart->script() !!}
            {!! $barChart->script() !!}
            {!! $lineChartInterval->script() !!}
        @endif
        @if(\Request::is('crypto*'))
            {!! $barChartVolume->script() !!}
            {!! $lineChartRange->script() !!}
        @endif
    </body>
    <footer class="fixed-bottom p-3 bg-dark border-top border-info">
        <div class="text-center text-secondary">
            &copy; {{now()->year}} Made by 
            <a class="text-info" href="https://www.linkedin.com/in/teodor-tita/">Teodor T.</a>
        </div>
    </footer>
</html>
