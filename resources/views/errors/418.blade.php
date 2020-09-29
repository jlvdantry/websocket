@extends('layouts.error')

@section('content')
<nav class="text-right container-fluid secciones" id="nav-secciones">&nbsp;</nav>
<div class="plecota">

    <h2 class="encabezado-cdmx pt-2 pl-5">{{config('app.name')}}</h2>
</div>
<div class="align-items-center justify-content-center height-60">
    <div class="col-12">
        <div class="d-flex flex-column flex-md-row justify-content-center">
            <div class="col-12 col-md-3 d-flex flex-column justify-content-center align-items-center">
                <h3 class="mt-5 encabezado-cdmx">418</h3>
            </div>
            <div class="col-12 col-md-6 d-flex flex-column border-left-thin-grey justify-content-center pl-md-4 pl-lg-5">
                <h3 class="error-title mt-5">{{ strlen(trim($exception->getMessage()))==0?'Detectamos un posible robo de sesión':$exception->getMessage()}}.</h3>
                <p class="grey-light">Detectamos actividad que podría suponer un riesgo a la seguridad de la sesión. 
                    Para mitigar este posible riesgo, es necesario que inicies sesión de nuevo.
                </p>
                <small><strong>ID de incidencia:</strong> {{session()->get('requuid')??'N/A'}}</small>
                <div class="align-self-lg-end mt-3">
                    <a href="{{route('home')}}" class="btn btn-cdmx">Volver a iniciar sesión</a>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
