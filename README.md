# Llave CDMX (Cliente para Laravel)

Código base para para proyectos nuevos en Laravel que ocupen inicio de sesión con LlaveCDMX

## Requisitos
- Apache 2.4 
- PHP 7.2 o superior (se recomienda PHP 7.3.9)
- ModRewrite activado

## Incluye
El codigo de este proyecto incluye:
- Laravel 7.5.1
- AdipUtils
- Boostrap
- Datatables Core
- Datatables Buttons
- Fontawesome

## Instalación
Para la instalación del cliente, realizar los siguientes pasos:
- Crear una base de datos vacía
- Descargar o clonar este repositorio y colocarlo en una carpeta, por ejemplo %DOCUMENT_ROOT%/mi-proyecto
- Dentro de la carpeta donde se descomprimió, ejecutar los siguientes commandos:
  - composer install
  - move .env.example .env (Windows)
  - mv .env.example .env (Linux)
  - php artisan key:generate
  - Configurar los valores del archivo .env
  - composer require doctrine/dbal
  - npm install
  - npm install datatables.net
  - npm install datatables.net-dt
  - npm install datatables.net-buttons
  - npm install datatables.net-buttons-dt
  - npm install --save @fortawesome/fontawesome-free
  - npm run dev
  - php artisan migrate
  - php artisan db:seed

Para verificar la instalación, acceder a la URL de la aplicación e intentar iniciar sesion con Llave.

## Nuevas funciones!

### Middleware Basic Auth
Se agregó un middleware que solicita autenticación mediante Basic Auth. Este puede usarse para exponer
servicios sin usar autenticación REST (API).

### Monitoreo de conexión
Se incluye una rutina que valida cada minuto que el sitio donde está alojada la aplicación sea alcanzable.
De manera predeterminada este comportamiento está desactivado, se puede activar estableciendo en `true` la 
variable `__kCheckCon` en el archivo `resources/js/engine.js` (línea 26).


### Validación del tamaño de los archivos a cargar antes de enviarlos
 Los controles `input [type="file"]`  revisan que el archivo seleccionado no exceda el tamaño especificado
 en `__maxUploadFileSize`. Dicha variable se encuentra en `resources/js/engine.js` (línea 43).


 ### Zona de invitados
Un usuario invitado es todo aquél que deberá tener acceso a cierta área del sistema pero que por cualquier motivo no tiene una cuenta LlaveCDMX, también se puede usar para sistemas que requieran cierto anonimato al ciudadano. Ejemplos:

- Ciudadanos que no tienen Clave Única de Registro de Población.
- Ciudadanos de otras entidades que no tienen forma de comprobar residencia en CDMX.
- Sistemas de denuncia anónima.

 ### Bugfixes

 - Busqueda de roles al iniciar sesión
 - Se agrega la carpeta `storage/fonts` a .gitignore para evitar el error de cache de DOMPDF


## Changelog
- 08/04/2020 - Version inicial.

- 08/04/2020 - Soporte para exponer servicios API.

- 08/05/2020 - Servicio para envío de correos.

- 01/07/2020 - Storage Service.

- 01/12/2020 - Zona de invitados.

