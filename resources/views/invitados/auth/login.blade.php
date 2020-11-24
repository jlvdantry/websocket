@extends('layouts.app')

@section('content')
<div class="plecota col-12 mb-4">
    <h2 class="encabezado-cdmx pt-2 pl-5">{{ config('app.name') }}</h2>
    <p class="pl-5 instrucciones-pleca"><strong>{{ config('app.description') }}</strong></p>
</div>
<div class="container">

    <div class="row justify-content-center">

        <div class="col-md-10">
            <div class="card">

                <div class="card-body">
                    <form method="POST" action="{{ route('invitados.loginPost') }}" class="form-search">
                        @csrf

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label form-label-cdmx text-md-right">Dirección de correo electrónico:</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control form-control-cdmx @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="off" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label form-label-cdmx text-md-right">Contraseña:</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control form-control-cdmx @error('password') is-invalid @enderror" name="password" required autocomplete="off">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label form-label-cdmx" for="remember">
                                        Recordarme en este equipo
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-cdmx">
                                    Iniciar sesión
                                </button>

                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        ¿Olvidaste tu contraseña?
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
