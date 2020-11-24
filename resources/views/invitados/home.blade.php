@extends('layouts.app')

@section('content')
<div>
    <div class="row align-items-center justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-body">

                    <h1>Dashboard para usuarios invitados</h1>
                    <p>Un usuario invitado es todo aquél que deberá tener acceso a cierta área del sistema pero que por cualquier motivo no tiene una cuenta 
                        <strong>LlaveCDMX</strong>, también se puede usar para sistemas que requieran cierto anonimato al ciudadano. Ejemplos:
                        <ol>
                            <li>Ciudadanos que no tienen Clave Única de Registro de Población.</li>
                            <li>Ciudadanos de otras entidades que no tienen forma de comprobar residencia en CDMX.</li>
                            <li>Sistemas de denuncia anónima.</li>
                        </ol>
                    </p>
                    <p>Para conocer los detalles de implementación del área de invitados, consulta la Wiki del arquetipo</p>
                    <hr>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
