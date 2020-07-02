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
Storage Service, servicio para almacenar de manera segura los documentos que se envían por formulario.

## Changelog
08/04/2020 - Version inicial.

08/04/2020 - Soporte para exponer servicios API.

08/05/2020 - Servicio para envío de correos.

01/07/2020 - Storage Service.

