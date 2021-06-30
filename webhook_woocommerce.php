<?php
header("Content-Type:application/json");

if (!empty($_POST)) {

    $response = $_POST;

    file_put_contents('data.json', json_encode($response));
    echo json_encode($response);
}
