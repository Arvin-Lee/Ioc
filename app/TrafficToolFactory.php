<?php

namespace App;

use App\Tool\Car;
use App\Tool\Leg;
use App\Tool\Train;

class TrafficToolFactory
{
    public static function createTrafficTool($name)
    {
        switch ($name) {
            case 'Leg':
                return new Leg();
                break;
            case 'Car':
                return new Car();
                break;
            case 'Train':
                return new Train();
                break;
            default:
                exit('get traffic tool error');
                break;
        }
    }
}