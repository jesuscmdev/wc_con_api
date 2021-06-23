# Conexión a API Woocommerce

Con ayuda del cliente de woocommerce podemos conectarnos a la API de WC

## Instalación de dependencias

Ejecuta los siguientes comandos para instalar las dependencias necesarias

``composer require automattic/woocommerce``

Cliente de woocommerce

```composer require vlucas/phpdotenv```

Leer archivos .env 

## Agrega las API keys de WC

Cambia el nombre del archivo `env.example` por .env y agrega ahí tus credenciales de la API de woocommerce

## Uso

En el archivo index.php está un ejemplo para actualizar el status de un pedido.

Puedes apoyarte de la API de woocommerce para lo que requieras

[RestAPI]('https://woocommerce.github.io/woocommerce-rest-api-docs/')
