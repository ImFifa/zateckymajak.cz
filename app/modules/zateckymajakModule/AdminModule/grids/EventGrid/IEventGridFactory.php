<?php

namespace App\Grid;

interface IEventGridFactory
{

    public function create(): EventGrid;

}
