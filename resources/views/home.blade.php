@extends('layouts.app')

@section('content')
<div>
    <div class="row align-items-center justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Dashboard</div>
                <div class="card-body">
                    <h1>Controles</h1>
                    <h2>Botones</h2>
                    <p>Se incluyen varios estilos de botones</p>
                    <p>
                        <button class="btn btn-cdmx" type="button" >Verde</button>
                        <button class="btn btn-cdmx-gris" type="button" >Gris</button>
                        <button class="btn btn-cdmx-amarillo" type="button" >Amarillo</button>
                        <button class="btn btn-cdmx-rojo" type="button" >Rojo</button>
                    </p>
                    <textarea rows="4" readonly class="form-control form-control-cdmx"><button class="btn btn-cdmx btn-shadow" type="button" >Verde</button>
<button class="btn btn-cdmx-gris" type="button" >Gris</button>
<button class="btn btn-cdmx-amarillo" type="button" >Amarillo</button>
<button class="btn btn-cdmx-rojo" type="button" >Rojo</button></textarea>
                    
                    <p>Botón CDMX con sombra</p>
                    <p><button class="btn btn-cdmx btn-shadow" type="button" >Botón sombra</button></p>
                    <textarea rows="1" readonly class="form-control form-control-cdmx"><button class="btn btn-cdmx" type="button" >Botón sombra</button></textarea>
                    <hr>

                    <p>Botón CDMX con icono</p>
                    <p>
                        <button class="btn btn-cdmx btn-shadow" type="button" ><span class="fa fa-home"> </span> Inicio</button>
                        <button class="btn btn-cdmx-gris btn-shadow" type="button">Siguiente <span class="fa fa-arrow-right"> </span></button>
                        <button class="btn btn-cdmx-amarillo btn-shadow" type="button"><span class="fa fa-exclamation-triangle"> </span> Aviso</button>
                        <button class="btn btn-cdmx-rojo btn-shadow" type="button"><span class="fa fa-window-close"> </span> Cancelar</button>
                    </p>
                    <textarea rows="4" readonly class="form-control form-control-cdmx"><button class="btn btn-cdmx btn-shadow" type="button" ><span class="fa fa-home"> </span> Inicio</button>
<button class="btn btn-cdmx-gris btn-shadow" type="button">Siguiente <span class="fa fa-arrow-right"> </span></button>
<button class="btn btn-cdmx-amarillo btn-shadow" type="button"><span class="fa fa-exclamation-triangle"> </span> Aviso</button>
<button class="btn btn-cdmx-rojo btn-shadow" type="button"><span class="fa fa-window-close"> </span> Cancelar</button></textarea>
                    <p>Para obtener más detalles consulta la documentación de Font Awesome</p><hr>
                    <h1>Formulario CDMX</h1>
                    <h2>Validación con HTML5</h2>
                    <p>Para usar la validacion de formularios incluida en los navegadores, basta con incluir los atributos de validación
                    de HTML5, por ejemplo <em>required</em> y <em>pattern</em>, como en el siguiente ejemplo:</p>
                    <textarea class="form-control form-control-cdmx" readonly rows="9"><form name="test" id="test" class="form-search">
    <p>Este formulario usa la validación de HTML5</p>
    <div class="form-group">
        <label for="txPrueba" class="control-label form-label-cdmx">Escribe tu nombre:</label>
        <input type="text" name="txPrueba" id="txPrueba" class="form-control form-control-cdmx" required>
    </div>
    <hr>
    <button type="submit" class="btn btn-cdmx btn-shadow">Enviar</button>
</form>
                    </textarea>
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
                    <p>Para usar la validacion de formularios incluida en el arquetipo, se debe incluir los atributos de validación
                    de HTML5, por ejemplo <em>required</em> y <em>pattern</em>, además, incluir el atributo <em>novalidate</em> y la clase
                    <em>needs-validation</em> en la etiqueta <strong>form</strong> como en el siguiente ejemplo:</p>
                    <textarea class="form-control form-control-cdmx" rows="10" readonly><form name="test2" id="test2" class="form-search needs-validation" novalidate>
    <p>Este formulario usa la validación de la App</p>
    <div class="form-group">
        <label for="txPrueba2" class="control-label form-label-cdmx">Escribe tu nombre:</label>
        <input type="text" name="txPrueba2" id="txPrueba2" class="form-control form-control-cdmx" required>
        <div class="invalid-feedback" id="feedback-txPrueba2"></div>
    </div>
    <hr>
    <button type="submit" class="btn btn-cdmx btn-shadow">Enviar</button>
</form>
</textarea>
                    <form name="test2" id="test2" class="form-search needs-validation" novalidate>
                        <p>Este formulario usa la validación de la App</p>
                        <div class="form-group">
                            <label for="txPrueba2" class="control-label form-label-cdmx">Escribe tu nombre:</label>
                            <input type="text" name="txPrueba2" id="txPrueba2" class="form-control form-control-cdmx" required>
                            <div class="invalid-feedback" id="feedback-txPrueba2"></div>
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
                    <h1>Consultar la documentación completa</h1>
                    <p>Para consultar la documentación completa, <a href="https://codigofuente.cdmx.gob.mx/adip.dev/php/laravel/archetype_laravel7.5_with_llavecdmx/wikis/home" target="_blank">visita la Wiki del arquetipo.</a></p>
                    <p><a href="https://codigofuente.cdmx.gob.mx/adip.dev/php/laravel/archetype_laravel7.5_with_llavecdmx/wikis/pages" target="_blank">Índice de temas</a></p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
