<?php

require 'vendor/autoload.php';

$api = new \GibertJeune\Api();
$api->setBarcode('9782344009505');
$product = $api->getProduct();

print_r($product);