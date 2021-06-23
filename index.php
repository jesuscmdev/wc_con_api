<?php
require __DIR__ . '/vendor/autoload.php';

use Automattic\WooCommerce\Client;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$woocommerce = new Client(
    'https://cactusdevs.com/store/', // Dominio
    $_ENV['WC_KEY_ADOBES'], // Key woocommerce desde env
    $_ENV['WC_SECRET_ADOBES'], // Secret woocommerce desde env
    [
        'wp_api' => true,
        'version' => 'wc/v3',
        'query_string_auth' => true // Force Basic Authentication as query string true and using under HTTPS
    ]
);

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
$data = [
    'status'            => $statuses['2'],
    // 'customer_note'     => 'Cambio de dirección'
];

/* @PUT actualiza el pedido 
$woocommerce->put('orders/22', $data) con los datos que le pasamos
*/
echo "<pre>";
print_r($woocommerce->put('orders/22', $data));
echo "</pre>";

/*
AÑADIR UNA NOTA
*/

$dataOrderNote = [
    'note'          => 'Estamos verificando su pago, gracias por enviar su comprobante',
    'customer_note' => true
];
$woocommerce->post('orders/22/notes', $dataOrderNote);



echo "<pre>";
print_r($woocommerce->get('orders/22/notes'));
echo "</pre>";
?>