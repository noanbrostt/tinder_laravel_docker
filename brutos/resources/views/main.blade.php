<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Estilos -->
    <link rel="stylesheet" href="{{ asset('css/font-roboto.css') }}" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/cropper.min.css') }}" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/sweetalert2.min.css') }}" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <!-- Scripts -->
    <script src="{{ asset('js/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('js/fontawesome.min.js') }}"></script>
    <script src="{{ asset('js/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('js/cropper.min.js') }}"></script>
    <script src="{{ asset('js/dataTables.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap-4.0.0.min.js') }}"></script>
    <script src="{{ asset('js/jquery.mask-1.14.15.min.js') }}"></script>
    <script src="{{ asset('js/hammer.min.js') }}"></script>
    <script src="{{ asset('js/app.js') }}"></script>

    <link rel="icon" type="image/x-icon" href="{{ asset('img/favicon.jpg')}}">
    <title>@yield('title', 'Plansul')</title>
</head>

<body>

    <div id="conteudo">
        @yield('conteudo')
    </div>

</body>

</html>