<?php

namespace App\Traits;

trait CategoryTrait
{
    public function getHexadecimalColor($color)
    {
        switch ($color) {
            case 'spray':
                return '#78ded4';

                break;
            case 'ice-cold':
                return '#a4dfd5';

                break;
            case 'ce-soir':
                return '#9a7aa0';

                break;
            case 'mandys-pink':
                return '#f3be9a';

                break;
            case 'grey-suit':
                return '#98989a';

                break;
            case 'light':
                return '#f8f9fa';

                break;
        }
    }
}
