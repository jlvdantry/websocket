@extends('layouts.app')

@section('content')
<nav class="text-right container-fluid secciones" id="nav-secciones">&nbsp;</nav>
<div class="plecota">

    <h2 class="encabezado-tramites pt-2 pl-5">{{env('APP_NAME')}}</h2>
</div>
<div class="row align-items-center justify-content-center height-60">
    <div class="col-12">
        <div class="d-flex flex-column flex-md-row justify-content-center">
            <div class="col-12 col-md-3 d-flex flex-column justify-content-center align-items-center">
                <h3 class="mt-5 encabezado-tramites">419</h3>
            </div>
            <div class="col-12 col-md-6 d-flex flex-column border-left-thin-grey justify-content-center pl-md-4 pl-lg-5">
                <h3 class="error-title mt-5">{{ strlen(trim($exception->getMessage()))==0?'Token erróneo':$exception->getMessage()}}</h3>
                <p class="grey-light">Se envió un identificador de sesión desconocido. Para volver a enviar el formulario
                    presona "Reenviar formulario", si eso no resulta, puedes intentar regresar a la página de inicio.
                </p>
                <small><strong>ID de incidencia:</strong> {{session()->get('requuid')??'N/A'}}</small>
                <div class="align-self-lg-end mt-3">
                    <a href="javascript:location.reload();" class="btn btn-warning btn-sm">Reenviar formulario</a>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;||&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <a href="{{route('home')}}" class="btn btn-success btn-sm">Regresar al inicio</a>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
