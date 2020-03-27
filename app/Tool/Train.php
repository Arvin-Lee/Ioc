<?php

namespace App\Tool;

use App\Visit;

class Train implements Visit
{

    public function go()
    {
        echo 'go train';
    }
}