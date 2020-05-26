<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="urlbase" content="{{ url('') }}">
    <meta name="author" content="Agencia Digital de Innovavión Pública">
    <meta name="description" content="{{env('APP_NAME')}}">

    <title>{{env('APP_NAME')}}</title>

    <script>
        var ubase = "{{ route('welcome')}}";
        var uHome = "{{ route('home')}}";
    </script>
    <script src="{{ asset('js/app.js') }}" defer></script>


    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="author" type="text/plain" href="{{asset('humans.txt')}}" charset="UTF-8" />
	<meta name="apple-mobile-web-app-capable" content="no" />
	<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent" />
	<link rel="apple-touch-startup-image" href="{{ asset('images/apple-bg-start.jpg') }}">
	<link rel="apple-touch-icon" href="{{ asset('images/favicon192.png') }}" />
	<link rel="shortcut icon" type="image/png" href="{{ asset('images/favicon.png') }}" />
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('images/favicon192.png') }}" />
    
    <meta property="og:url" content="{{route('welcome')}}" />
    <meta property="og:type" content="website" />
    <meta property="og:title" content="{{env('APP_NAME')}} | Ciudad de México" />
    <meta property="og:description" content="{{env('APP_DESCRIPTION')}}" />
    <meta property="og:image" content="{{ asset('images/thumb.jpg') }}" />
    <meta property="og:image:type" content="image/jpg"/>
    <meta property="og:image:width" content="615"/>
    <meta property="og:image:height" content="485"/>


</head>
<body class="d-flex flex-column">
    <div id="app" class="flex-fill container-fluid">
        <header>
            <nav class="navbar navbar-expand-sm navbar-light bg-white">
                <a class="navbar-brand" href="{{ route('welcome') }}">
                    <img src="{{asset('images/brand.svg')}}" class="brand-logo-cdmx">
                </a>
                @guest
                @else
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                @endguest
                <div class="collapse navbar-collapse bar" id="navbarSupportedContent">
                    <div class="linea auto-hide"></div>
                    <div class="jeader-title auto-hide">
                        {{env('APP_NAME')}}
                    </div>
                </div>
                @guest
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item btn-sesion-pad-r">
                                <a class="nav-link" href="{{ route('login') }}">
                                    <img src="{{asset('images/btn-llave-sm.png')}}" title="Iniciar sesión con Llave CDMX">
                                </a>
                            <div class="tx-crea-cuenta">¿Aún no tienes cuenta? <a href="{{env('LLAVE_CREATE_ACCOUNT')}}" target="_blank">Crea una</a></p>
                        </li>
                    </ul>
                @else
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ml-auto">

                        <li class="nav-item dropdown btn-sesion-pad-r">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                <img src="{{asset('images/user-ico-sm.png')}}" alt="Usuario" class="user-ico">
                                <span class="nb-usuario">{{ strtolower(Auth::user()->nombre.' '.Auth::user()->primerApellido) }}</span> <span class="caret"></span>
                            </a>
                            <div class="tp-user">{{ ucfirst(Auth::user()->descripcionRol) }}</div>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('welcome') }}">Inicio</a>
                                <a class="dropdown-item" href="{{ route('home') }}">Dashboard</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                                document.getElementById('logout-form').submit();">
                                    Cerrar sesión
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    </ul>
                </div>
                @endguest
                
            </nav>
        </header>
        <main>
            @yield('content')
        </main>


    </div>

    <div class="modal fade" id="modal-logo" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">                        
            <div class="modal-content">                    
                <div class="modal-body">
                    <div class="alert alert-warning" role="alert">
                        Tu sesión ha caducado. Debes iniciar sesion de nuevo.
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-cdmx" id="relogi">Iniciar sesión</button>
                </div>
            </div>
        </div>
    </div>  

    <footer>
        <div style="float:left">
            <img class="img-footer brand-logo-cdmx pi-footer" src="{{asset('images/adip-footer.svg')}}" alt="">
        </div>
        <div>
            <p class="label-footer">{{env('APP_NAME')}}</p>
            <p class="label-footer"><strong>Diseñado por la Agencia Digital de Innovación Pública. {{env('APP_DEPENDENCIA')}}</strong></p>
        </div>
        <div id="footer-mark"></div>
    </footer>

    
</body>
</html>
