@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>
                <div class="card-body">
                    <h1>Controles</h1>
                    <h2>Botones</h2>
                    <p>Botón CDMX</p>
                    <code>{!! htmlentities('<button class="btn btn-cdmx" type="button" >Aceptar</button>', ENT_QUOTES, 'UTF-8') !!}</code>
                    <hr><button class="btn btn-cdmx" type="button" >Aceptar</button><hr>
                    <p>Botón CDMX con sombra</p>
                    <code>{!! htmlentities('<button class="btn btn-cdmx btn-shadow" type="button" >Botón sombra</button>', ENT_QUOTES, 'UTF-8') !!}</code>
                    <hr><button class="btn btn-cdmx btn-shadow" type="button" >Botón sombra</button><hr>

                    <h1>Formulario CDMX</h1>
                    <h2>Validación con HTML5</h2>
                    <p>Para usar la validacion de formularios incluida en los navegadores, basta con incluir los atributos de validación
                    de HTML5, por ejemplo <em>required</em> y <em>pattern</em>, como en el siguiente ejemplo:</p>
                    <code>
                    {!! htmlentities('<form name="test" id="test" class="form-search">
                        <p>Este formulario usa la validación de HTML5</p><div class="form-group">
                            <label for="txPrueba" class="control-label form-label-cdmx">Escribe tu nombre:</label>
                            <input type="text" name="txPrueba" id="txPrueba" class="form-control form-control-cdmx" required>
                        </div><hr><button type="submit" class="btn btn-cdmx btn-shadow">Enviar</button></form>
                        ', ENT_QUOTES, 'UTF-8'); !!}
                    </code>
                    <form name="test" id="test" class="form-search">
                        <p>Este formulario usa la validación de HTML5</p>
                        <div class="form-group">
                            <label for="txPrueba" class="control-label form-label-cdmx">Escribe tu nombre:</label>
                            <input type="text" name="txPrueba" id="txPrueba" class="form-control form-control-cdmx" required>
                        </div>
                        <hr>
                        <button type="submit" class="btn btn-cdmx btn-shadow">Enviar</button>
                    </form>
                    <hr />
                    <h2>Validación con el validador de la App</h2>
                    <p>Para usar la validacion de formularios incluida en la aplicación, se debe incluir los atributos de validación
                    de HTML5, por ejemplo <em>required</em> y <em>pattern</em>, además, incluir el atributo <em>novalidate</em> y la clase
                    <em>needs-validation</em> en la etiqueta <strong>form</strong> como en el siguiente ejemplo:</p>
                    <code>{!! htmlentities('<form name="test2" id="test2" class="form-search needs-validation" novalidate>
                        <p>Este formulario usa la validación de la App</p><div class="form-group">
                            <label for="txPrueba2" class="control-label form-label-cdmx">Escribe tu nombre:</label>
                            <input type="text" name="txPrueba2" id="txPrueba2" class="form-control form-control-cdmx" required>
                        </div><hr><button type="submit" class="btn btn-cdmx btn-shadow">Enviar</button></form>
                        ', ENT_QUOTES, 'UTF-8'); !!}
                    </code>
                    <form name="test2" id="test2" class="form-search needs-validation" novalidate>
                        <p>Este formulario usa la validación de la App</p>
                        <div class="form-group">
                            <label for="txPrueba2" class="control-label form-label-cdmx">Escribe tu nombre:</label>
                            <input type="text" name="txPrueba2" id="txPrueba2" class="form-control form-control-cdmx" required>
                        </div>
                        <hr>
                        <button type="submit" class="btn btn-cdmx btn-shadow">Enviar</button>
                    </form>
                    <hr>
                    <h1>Validación de sesiones</h1>
                    <p>La aplicación incluye un validador de sesión activa (intervalos de 5 minutos). Si la sesión ha caducado, se mostrará un modal con un aviso.</p>
                    <p>Para desactivarlo, editar el archivo app.js en resources y comentar la siguiente línea:</p>
                    <code>timercito = setInterval(laSesion, 5*60*1000); // minutostimer * 60 * 1000</code>
                    <hr>
                    <h1>Envío de correos</h1>
                    <p>En PHP se considera mala práctica de programación realizar envío de correos "al vuelo", es decir,  
                    realizar el envío dentro de la programación que implica lógica de negocio. Por ejemplo</p>
                    @php
                    $foo = '$solicitud->actualizar();'.PHP_EOL;
                    $foo.= '$to = $solicitud->usuario()->email;'.PHP_EOL;
                    $foo.= 'Mail::to($to)->send(\'solicitud-validada\'); // Esta línea en Laravel envía el correo'.PHP_EOL;
                    $foo.= 'return view(\'solicitud.actualizada\');'.PHP_EOL;
                    @endphp
                    <code>{!! nl2br($foo) !!}</code>
                    <p>En el ejemplo anterior si el envío de correo demora 25000 milisegundos (25 segundos), ese tiempo se verá reflejado
                    en el tiempo que tarda la página en cargar, lo cual disminuye la experiencia de usaurio.</p>
                    <p>Para solventar este comportamiento el arquetipo incluye un servicio de envío de correos, usando dicho
                    servicio, se elimina el tiempo de respuesta de envío de correo. (en el ejemplo anterior, los 25 segundos)</p>
                    <p>El servicio envía los correos pendientes mediante una tarea programada. Consulta el manual técnico para obtener los detalles.</p>
                    @php
                    $foo = '$html = view(\'emails.email\')->render();'.PHP_EOL;
                    $foo .= '$correo = ['.PHP_EOL;
                    $foo .= '    \'tx_from\' => env(\'MAIL_FROM_ADDRESS\', \'no-reply@cdmx.gob.mx\')'.PHP_EOL;
                    $foo .= '    ,\'tx_to\' => $solicitud->tx_email'.PHP_EOL;
                    $foo .= '    ,\'tx_subject\' => \'Alta Vehicular / Validando documentos\''.PHP_EOL;
                    $foo .= '    ,\'tx_body\' => $html'.PHP_EOL;
                    $foo .= '    ,\'nu_priority\' => 0'.PHP_EOL;
                    $foo .= '];'.PHP_EOL;
                    $foo .= 'Correo::create($correo);'.PHP_EOL;
                    @endphp
                    <code>{!! nl2br($foo) !!}</code>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
