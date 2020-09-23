<?php

use Illuminate\Support\Str;

return [

    /*
    |--------------------------------------------------------------------------
    | Default Database Connection Name
    |--------------------------------------------------------------------------
    |
    | Here you may specify which of the database connections below you wish
    | to use as your default connection for all database work. Of course
    | you may use many connections at once using the Database library.
    |
    */

    'default' => env('DB_CONNECTION_APP_SUFIX', 'mysql'),

    /*
    |--------------------------------------------------------------------------
    | Database Connections
    |--------------------------------------------------------------------------
    |
    | Here are each of the database connections setup for your application.
    | Of course, examples of configuring each database platform that is
    | supported by Laravel is shown below to make development simple.
    |
    |
    | All database work in Laravel is done through the PHP PDO facilities
    | so make sure you have the driver for your particular database of
    | choice installed on your machine before you begin development.
    |
    */

    'connections' => [

        'sqlite' => [
            'driver' => 'sqlite',
            'url' => env('DATABASE_URL_APP_SUFIX'),
            'database' => env('DB_DATABASE_APP_SUFIX', database_path('database.sqlite')),
            'prefix' => '',
            'foreign_key_constraints' => env('DB_FOREIGN_KEYS', true),
        ],

        'mysql' => [
            'driver' => 'mysql',
            'url' => env('DATABASE_URL_APP_SUFIX'),
            'host' => env('DB_HOST_APP_SUFIX', '127.0.0.1'),
            'port' => env('DB_PORT_APP_SUFIX', '3306'),
            'database' => env('DB_DATABASE_APP_SUFIX', 'forge'),
            'username' => env('DB_USERNAME_APP_SUFIX', 'forge'),
            'password' => env('DB_PASSWORD_APP_SUFIX', ''),
            'unix_socket' => env('DB_SOCKET', ''),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => true,
            'engine' => null,
            'options' => extension_loaded('pdo_mysql') ? array_filter([
                PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
            ]) : [],
        ],

        'pgsql' => [
            'driver' => 'pgsql',
            'url' => env('DATABASE_URL_APP_SUFIX'),
            'host' => env('DB_HOST_APP_SUFIX', '127.0.0.1'),
            'port' => env('DB_PORT_APP_SUFIX', '5432'),
            'database' => env('DB_DATABASE_APP_SUFIX', 'forge'),
            'username' => env('DB_USERNAME_APP_SUFIX', 'forge'),
            'password' => env('DB_PASSWORD_APP_SUFIX', ''),
            'charset' => 'utf8',
            'prefix' => '',
            'prefix_indexes' => true,
            'schema' => 'public',
            'sslmode' => 'prefer',
        ],

        'sqlsrv' => [
            'driver' => 'sqlsrv',
            'url' => env('DATABASE_URL_APP_SUFIX'),
            'host' => env('DB_HOST_APP_SUFIX', 'localhost'),
            'port' => env('DB_PORT_APP_SUFIX', '1433'),
            'database' => env('DB_DATABASE_APP_SUFIX', 'forge'),
            'username' => env('DB_USERNAME_APP_SUFIX', 'forge'),
            'password' => env('DB_PASSWORD_APP_SUFIX', ''),
            'charset' => 'utf8',
            'prefix' => '',
            'prefix_indexes' => true,
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Migration Repository Table
    |--------------------------------------------------------------------------
    |
    | This table keeps track of all the migrations that have already run for
    | your application. Using this information, we can determine which of
    | the migrations on disk haven't actually been run in the database.
    |
    */

    'migrations' => 'migrations',

    /*
    |--------------------------------------------------------------------------
    | Redis Databases
    |--------------------------------------------------------------------------
    |
    | Redis is an open source, fast, and advanced key-value store that also
    | provides a richer body of commands than a typical key-value system
    | such as APC or Memcached. Laravel makes it easy to dig right in.
    |
    */

    'redis' => [

        'client' => env('REDIS_CLIENT_APP_SUFIX', 'phpredis'),

        'options' => [
            'cluster' => env('REDIS_CLUSTER_APP_SUFIX', 'redis'),
            'prefix' => env('REDIS_PREFIX_APP_SUFIX', Str::slug(env('APP_NAME_APP_SUFIX', 'laravel'), '_').'_database_'),
        ],

        'default' => [
            'url' => env('REDIS_URL_APP_SUFIX'),
            'host' => env('REDIS_HOST_APP_SUFIX', '127.0.0.1'),
            'password' => env('REDIS_PASSWORD_APP_SUFIX', null),
            'port' => env('REDIS_PORT_APP_SUFIX', '6379'),
            'database' => env('REDIS_DB_APP_SUFIX', '0'),
        ],

        'cache' => [
            'url' => env('REDIS_URL_APP_SUFIX'),
            'host' => env('REDIS_HOST_APP_SUFIX', '127.0.0.1'),
            'password' => env('REDIS_PASSWORD_APP_SUFIX', null),
            'port' => env('REDIS_PORT_APP_SUFIX', '6379'),
            'database' => env('REDIS_CACHE_DB_APP_SUFIX', '1'),
        ],

    ],

];
