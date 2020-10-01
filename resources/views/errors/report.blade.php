<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Informe de error en {{ config('app.name') }}</title>
        <style type="text/css">
            h1 {font-family:Verdana;color:white;background-color:#525D76;font-size:24px;}
            h2 {font-family:Verdana;color:white;background-color:#525D76;font-size:18px;}
            h3 {font-family:Verdana;color:white;background-color:#525D76;font-size:16px;}
            body {font-family:Verdana;color:black;background-color:white;}
            b {font-family:Verdana;color:white;background-color:#525D76;}
            p {font-family:Verdana;background:white;color:black;font-size:14px;}
            a {color : black;}
            hr {color : #525D76;}
        </style>
    </head>
    <body>
        <h1>Informe de error en {{ config('app.name') }}</h1>
        <hr/>
        <p>
            <b>Mensaje de error:</b> {{ $exception->getMessage() }}
        </p>
        <p>
            <b>Entorno:</b> {{ App::environment() }}
        </p>
        <p>
            <b>Archivo:</b> {{ $exception->getFile() }}
        </p>
        <p>
            <b>Línea:</b> {{ $exception->getLine() }}
        </p>
        <hr/>
        <code>
{!! $exception->getTraceAsString() !!}
        </code>
    </body>
</html>