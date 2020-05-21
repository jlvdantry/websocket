<html>
    <head>
        <title>Redireccionando</title>
    </head>
    <body>
        <p style="font-size:1.1em;">Si no eres redireccionado, haz clic <a href="{{route($route??'home')}}">aquí</a></p>
        <script>
            document.onLoad=location.href="{{route($route??'home')}}";
        </script>
    </body>
</html>