<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
    <!-- Configuración de Vite para cargar tu aplicación Vue.js -->
    @vite('resources/js/app.js')

    <!-- Métodos de Inertia para configurar el encabezado -->
    @inertiaHead

    <!-- Meta tag para el token CSRF -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
  </head>
  <body>
    <!-- Renderizado de la aplicación Vue.js con Inertia -->
    @inertia
  </body>
</html>
