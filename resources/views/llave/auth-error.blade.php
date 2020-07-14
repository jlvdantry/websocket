
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="error-template">
                <h4 class="my-4">Error inesperado</h4>
                <div class="error-details mt-4">
                    Ocurrió un error inesperado. Por favor realiza nuevamente la operación y si persiste 
                    el problema repórtalo en <a target="_blank" href="https://atencionciudadana.cdmx.gob.mx">atencionciudadana.cdmx.gob.mx</a>
                </div>
                <div class="error-actions mt-5">
                    <a href="{{route('home')}}" class="btn btn-cdmx">
                        <span class="fa fa-home"></span>
                        Volver al inicio
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<!--
{{$res->errorDescription??''}}
-->
