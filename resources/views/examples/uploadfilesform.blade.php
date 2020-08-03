@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <h1>StorageService</h1>
                    <p>Este componente surge para evitar que las aplicaciones generadas presenten un fallo conocido como
                    <em>divulgación de documentos</em>.</p>
                    <p>Algunas aplicaciones permiten la carga de documentos al usuario, y los almacenan en la carpeta <em>public</em>
                    lo cual los hace accesibles para cualquier usaurio, incluso sin iniciar sesión. <small>(ver detalles en https://codigofuente.cdmx.gob.mx/adip.dev/php/laravel/archetype_laravel7.5_with_llavecdmx/wikis/Arquitectura-backend/Storage-Service)</small>
                    <p>La principal función de este componente es almacenar de manera segura los archivos enviados por formulario.</p>
                    <form name="frmArchivito" id="frmArchivito" class="form-search needs-validation" novalidate action="{{route('examples.uploadfiles')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <p>Para probar el componente, agrega un archivo al formulario siguiente:</p>
                        <div class="form-group">
                            <label for="biArchivo" class="control-label form-label-cdmx">Agregar archivo:</label>
                            <input type="file" name="biArchivo" id="biArchivo" class="form-control form-control-cdmx" required>
                        </div>
                        <div class="form-group">
                            <input type="checkbox" name="chkPublic" id="chkPublic" value="1">
                            <label for="chkPublic" class="control-label form-label-cdmx">Es de acceso público</label>
                        </div>
                        <hr>
                        <button type="submit" id="btn_send" class="btn btn-cdmx btn-shadow">Enviar</button>
                    </form>
                    <hr>
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
