<?php

namespace App\Tool;

use App\Visit;

class Leg implements Visit
{
    public function go()
    {
        echo 'go leg';
    }
}