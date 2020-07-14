<html>
    <head>
        <script src="{{asset('js/app.js')}}?v={{microtime(true)}}" defer></script>


        <link rel="dns-prefetch" href="//fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
        <link rel="icon" type="image/png" href="{{asset('images/favicon.png')}}">

        <link href="{{asset('css/app.css')}}?v={{microtime(true)}}" rel="stylesheet">
    </head>
    <body>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="error-template">
                        <h2 class="my-5 pregunta-tramite">Error inesperado</h2>
                        <div class="error-details my-5">
                            Ocurrió un error inesperado. Por favor realiza nuevamente la operación y si persiste el problema
                             repórtalo en <a target="_blank" href="https://atencionciudadana.cdmx.gob.mx">atencionciudadana.cdmx.gob.mx</a>
                        </div>
                        <div class="error-actions">
                            <a href="{{route('home')}}" class="btn btn-cdmx"><span class="fa fa-home"></span>
                                Regresar al inicio
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>

<!--
{{$exception->getTraceAsString()}}
-->
