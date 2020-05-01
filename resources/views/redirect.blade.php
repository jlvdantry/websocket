<html>
    <head>
        <title>Redireccionando</title>
    </head>
    <body>
        <p style="font-size:1.1em;">Si no eres redireccionado al índice, haz clic <a href="{{route('home')}}">aquí</a></p>
        <script>
            docment.onLoad=location.href="{{route('home')}}";
        </script>
    </body>
</html>