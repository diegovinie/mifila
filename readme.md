# Mi Fila

Mi fila es un sistema de gestión de turnos enfocado en permitir a los usuarios
poder solicitar, posponer o cancelar un turno en los establecimientos que lo
usen.

El proyecto está conformado por las siguientes partes:

- Base de datos.
- API Restful.
- Aplicación web para el usuario.
- Un simulador.

## Requisitos

PHP 7.1^ además requiere de:
- ext-mbstring
- ext-curl
- ext-dom (php-xml)

puede preguntar por libpng-dev en la instalación de los *node_modules*

## Instalación

`composer install`
`cp .env.example .env`
`php artisan key:gen`

Editar .env:

### Para mysql:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=<nombre_bd>
DB_USERNAME=<usuario_bd>
DB_PASSWORD=<clave_bd>
```
### Para sqlite:
`touch database/database.sqlite`
```
DB_CONNECTION=sqlite
```

`php artisan migrate --seed`

### Compilar el cliente:
`yarn install` (npm funciona también)
`yarn run dev`

### Iniciar el simulador:
`php artisan simulator:run`

### Iniciar el servidor:
`php artisan serve`

El servidor por defecto se levanta en http://localhost:8000

## Documentación de la API
*TODO*

## Caso de uso básico
*TODO*

## Documentación de desarrollo
*TODO*
