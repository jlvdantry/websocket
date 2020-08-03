@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <h1>StorageService</h1>
                    <p>De manera predeterminada el arquetipo guarda los archivos cargados en una carpeta no accesible desde la web,
                    a cada archivo se le asocia un identificador único. Para acceder a los archivos subidos se 
                    requiere ser un usuario autenticado.</p>
                    <hr>
                    <h2>Datos del archivo que subiste</h2>
                    <p><strong>Nombre otiginal:</strong> {{$saved->nb_archivo}}</p>
                    <p><strong>Mime Type:</strong> {{$saved->tx_mime_type}}</p>
                    <p><strong>Tamaño:</strong> {{$saved->nu_tamano}}</p>
                    <p><strong>Identificador:</strong> {{$saved->tx_uuid}}</p>
                    <h2>Descarga de el archivo</h2>
                    <p>Haz clic <a target="_blank" href="{{route('downloadFileByUuid',['uuid' => $saved->tx_uuid])}}">aquí</a></p>
                    <p><strong>Permalink (Content-Disposition: attachment):</strong></p>
                    <pre>{{route('downloadFileByUuid',['uuid' => $saved->tx_uuid])}}</pre>
                    <p><strong>Permalink (Content-Disposition: inline):</strong></p>
                    <pre>{{route('showFileByUuid',['uuid' => $saved->tx_uuid])}}</pre>
                    @if($public)
                    <h2>Descarga de el archivo (public)</h2>
                    <p>Haz clic <a target="_blank" href="{{route('publicFileByUuid',['uuid' => $saved->tx_uuid])}}">aquí</a></p>
                    <p><strong>Permalink (Content-Disposition: inline):</strong></p>
                    <pre>{{route('publicFileByUuid',['uuid' => $saved->tx_uuid])}}</pre>
                    @endif

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
