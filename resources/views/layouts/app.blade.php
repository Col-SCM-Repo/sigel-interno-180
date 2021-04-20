<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'SIGEL') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">

    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('toastr/toastr.css') }}">

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @yield('styles')
</head>
<body>
    <div id="app">
        <div class="spiner-content">
            <div class="d-flex justify-content-center">
                <div class="spinner-border" role="status">
                  <span class="sr-only">Loading...</span>
                </div>
            </div>
        </div>
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'SIGEL') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                        @guest
                        @else
                            <li id="alumnos-nav" class="nav-item dropdown ">
                                <a  class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    ALUMNOS
                                </a>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="alumnos">
                                    <a class="dropdown-item" href="{{route('editar.alumno.alumnos', ['alumno_id' => 0])}}">
                                        Nuevo Alumno
                                    </a>
                                    <a class="dropdown-item" href="{{ route('index.alumnos') }}">
                                        Pagos
                                    </a>
                                </div>
                            </li>
                            <li id="matriculas-nav" class="nav-item dropdown ">
                                <a  class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    MATRICULAS
                                </a>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="matriculas">
                                    <a class="dropdown-item" href="{{ route('index.aula') }}">
                                        Aulas
                                    </a>
                                    <a class="dropdown-item" href="{{ route('nueva.matriculas', ['alumno_id'=>0,'matricula_id'=>0]) }}">
                                        Nueva Matrícula
                                    </a>
                                </div>
                            </li>
                            <li id="reportes-nav" class="nav-item dropdown ">
                                <a  class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    REPORTES
                                </a>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="matriculas">
                                    <a class="dropdown-item" href="{{ route('vista.pagos.del.dia.pagos') }}">
                                        Pagos Por Usuario
                                    </a>
                                    <a class="dropdown-item" href="{{ route('vista.por.nivel.anio_actual.vacantes') }}">
                                        Alumnos Por Año y Nivel
                                    </a>
                                    <a class="dropdown-item" href="{{ route('vista.morosos.alumnos') }}">
                                        Alumnos Morosos
                                    </a>
                                    <a class="dropdown-item" href="{{ route('vista.pagos.entre.fechas.pagos') }}">
                                        Pagos Entre Fechas
                                    </a>
                                </div>
                            </li>
                        @endguest
                    </ul>
                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->USU_NOMBRES }}
                                </a>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
        <main class="py-4">
            @yield('content')
        </main>
        <input type="text" id="baseUrl" value=""  hidden>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script src="https://use.fontawesome.com/releases/v5.15.3/js/all.js" data-auto-replace-svg="nest"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="{{ asset('toastr/toastr.min.js') }}"></script>
    <script src="{{ asset('js/app.js') }}" defer></script>
    @yield('scripts');
</body>
</html>
