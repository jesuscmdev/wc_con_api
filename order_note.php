<?php
header("Content-Type:application/json");
require __DIR__ . '/vendor/autoload.php';

use Automattic\WooCommerce\Client;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

if (!empty($_POST)) {
    // Inicializamos el cliente WC
    $woocommerce = init();
    // Creamos un arreglo asociativo con los datos de la petición POST
    $datosPost = datosRecibidos($_POST);

    /* Arreglo de datos a actualizar en la orden */

    if ($datosPost['idorder']) {
        $id_pedido = $datosPost['idorder'];
    } else {
        echo json_encode(["message" => "No se encontró el id de pedido que modificar"]);
        die();
    }
    if ($datosPost['note']) {
        $nota = $datosPost['note'];
    } else {
        echo json_encode(["message" => "No se encontró nota que agregar"]);
        die();
    }

    $dataOrderNote = [
        'note'  => $nota,
    ];
    /* 
    Sí nos envían un valor en notificación significa que es para el cliente
    */
    if ($datosPost['notificacion']) {
        $dataOrderNote['customer_note'] = true;
    }

    $woocommerce->post('orders/22/notes', $dataOrderNote);

    $response = $woocommerce->get('orders/22/notes');
    echo json_encode($response);
} else {
    echo json_encode(["message" => "Acceso denegado"]);
}

function init()
{
    $woocommerce = new Client(
        $_ENV['DOMAIN'], // Dominio
        $_ENV['WC_KEY'], // Key woocommerce desde env
        $_ENV['WC_SECRET'], // Secret woocommerce desde env
        [
            'wp_api' => true,
            'version' => 'wc/v3',
            'query_string_auth' => true // Force Basic Authentication as query string true and using under HTTPS
        ]
    );
    return $woocommerce;
}
function datosRecibidos($postData)
{
    foreach ($postData as $key => $value) {
        $datos[$key] = $value;
    }
    return $datos;
}
