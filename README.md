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
- Descargar o clonar este repositorio y colocarlo en una carpeta, por ejemplo %DOCUMENT_ROOT%/mi-proyecto
- Dentro de la carpeta donde se descomprimió, ejecutar los siguientes commandos:
  - composer install
  - cp .env.example .env
  - php artisan key:generate
  - Configurar los valores del archivo .env
  - composer require laravel/ui
  - composer require doctrine/dbal
  - php artisan ui vue --auth
  - npm install
  - npm run dev
  - Editar el archivo config/session y cambiar lo siguiente:
    ` 'expire_on_close' => false, // Reemplazar por TRUE `
    ` 'path' => '/' // reemplazar por env('SESSION_PATH',base_path()), `
  - php artisan session:table
  - npm install datatables.net
  - npm install datatables.net-dt
  - npm install datatables.net-buttons
  - npm install datatables.net-buttons-dt
  - npm install --save @fortawesome/fontawesome-free
  - npm run dev

Para verificar la instalación, acceder a la URL de la aplicación e intentar iniciar sesion con Llave.

## Nuevas funciones!
Esta es la versión inicial, no hay nuevas funciones

## Changelog
08/07/2020 - Version inicial.

