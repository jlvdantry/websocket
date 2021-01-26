@extends('layouts.app')

@section('content')
<nav class="text-right container-fluid secciones" id="nav-secciones">&nbsp;</nav>
<div class="plecota">

    <h2 class="encabezado-cdmx pt-2 pl-5">{{config('app.name')}}</h2>
    <p class="pl-5 instrucciones-pleca"><strong>Bienvenido, realiza bla bla bla.</strong></p>
</div>
<div class="row justify-content-center mt-5">
    <div class="col-md-10">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-6 text-center">
                        <a href="{{ route('login') }}">
                            <img src="{{asset('images/inicia-llave.svg')}}" title="Iniciar sesión con Llave CDMX">
                        </a>
                    </div>
                    @if(\App\AdipUtils\Engine::hasGuestZone())
                    <div class="col-6 text-center"><a href="{{ route('invitados.login') }}" class="btn-login-invitado">Iniciar sesion como invitado</a></div>
                    @endif
                </div>
            </div>
        </div>
    </div>

</div>


@endsection