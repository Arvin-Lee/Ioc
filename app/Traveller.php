<?php

namespace App;

// traveller
class Traveller
{
    protected $trafficTool;

    public function __construct(Visit $trafficTool)
    {
        //依赖产生
        $this->trafficTool = $trafficTool;
    }

    public function visitTibet()
    {
        $this->trafficTool->go();
    }
}
