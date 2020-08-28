@extends('layouts.app')

@section('content')
<nav class="text-right container-fluid secciones" id="nav-secciones">&nbsp;</nav>
<div class="plecota">
    <h2 class="encabezado-cdmx pt-2 pl-5">{{config('app.name')}}</h2>
</div>
<div class="row align-items-center justify-content-center height-60">
    <div class="col-12">
        <div class="d-flex flex-column flex-md-row justify-content-center">
            <div class="col-12 col-md-3 d-flex flex-column justify-content-center align-items-center">
                <h3 class="mt-5 encabezado-cdmx">503</h3>
            </div>
            <div class="col-12 col-md-6 d-flex flex-column border-left-thin-grey justify-content-center pl-md-4 pl-lg-5">
                <h3 class="error-title mt-5">Mantenimiento programado</h3>
                <p class="grey-light">Lo sentimos, por el momento esta aplicación no está disponible. ¡Estará de vuelta pronto!.</p>
            </div>
        </div>
    </div>
</div>
@endsection
