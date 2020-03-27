<?php

namespace App\Tool;

use App\Visit;

class Car implements Visit
{
    public function go()
    {
        echo 'go car';
    }
}
