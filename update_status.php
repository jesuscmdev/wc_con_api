<?php
header("Content-Type:application/json");
require __DIR__ . '/vendor/autoload.php';

use Automattic\WooCommerce\Client;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

echo __DIR__;

if (!empty($_POST)) {
    // Inicializamos el cliente WC
    $woocommerce = init();
    // Creamos un arreglo asociativo con los datos de la petición POST
    $datosPost = datosRecibidos($_POST);
    /* Estados disponibles para un pedido */
    $statuses = [
        '1' => 'pending',
        '2' => 'processing',
        '3' => 'on-hold',
        '4' => 'completed',
        '5' => 'cancelled',
        '6' => 'refunded',
        '7' => 'failed',
        '8' => 'trash'
    ];
    /* Arreglo de datos a actualizar en la orden */

    if ($datosPost['idorder']) {
        $id_pedido = $datosPost['idorder'];
    } else {
        echo json_encode(["message" => "No se encontró el id de orden que modificar"]);
        die();
    }
    if ($datosPost['status']) {
        $status_pedido = $datosPost['status'];
    } else {
        echo json_encode(["message" => "No se encontró código de status"]);
        die();
    }

    // Establecemos el nuevo estado
    $data = [
        'status'    => $statuses[$status_pedido]
    ];

    // Respuesta de woocommerce, petición de actualización de estado
    $response = $woocommerce->put('orders/' . $id_pedido, $data);
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
    foreach ($_POST as $key => $value) {
        $datos[$key] = $value;
    }
    return $datos;
}
/*
AÑADIR UNA NOTA
*/
$dataOrderNote = [
    'note'          => 'Estamos verificando su pago, gracias por enviar su comprobante',
    'customer_note' => false
];
// $woocommerce->post('orders/22/notes', $dataOrderNote);

// print_r($woocommerce->get('orders/22/notes'));
