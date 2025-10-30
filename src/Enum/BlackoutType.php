<?php

namespace App\Enum;
enum BlackoutType: string
{
    case ELECTRICITY = 'electricity';
    case HOT_WATER   = 'hot_water';
    case COLD_WATER  = 'cold_water';
    case HEAT        = 'heat';
}
