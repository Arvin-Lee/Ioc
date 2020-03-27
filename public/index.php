<?php

require __DIR__ . '/../vendor/autoload.php';

use App\Traveller;
use App\TrafficToolFactory;

$traveller = new Traveller(TrafficToolFactory::createTrafficTool('Leg'));
$traveller->visitTibet();
//var_dump($traveller);