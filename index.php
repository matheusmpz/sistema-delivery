<?php

require __DIR__ . '/vendor/autoload.php';

use App\Core\SistemaDelivery;

$sistema = new SistemaDelivery();
$sistema->iniciar();
