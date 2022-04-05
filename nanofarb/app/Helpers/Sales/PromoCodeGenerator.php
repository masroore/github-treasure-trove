<?php
/**
 * Created by PhpStorm.
 * User: its
 * Date: 15.03.19
 * Time: 14:47.
 */

namespace App\Helpers\Sales;

use App\Models\Shop\SalePromoCode;

class PromoCodeGenerator
{
    protected $existingCodes = [];

    public function generate(int $amount = 1): array
    {
        $existingCodes = SalePromoCode::select('code')->get()
            ->pluck('code')->toArray();

        for ($i = 0, $codes = []; $i < $amount; ++$i) {
            $codes[] = $this->getUniqueCode($existingCodes);
        }

        return $codes;
    }

    public function generateOne(): string
    {
        $existingCodes = SalePromoCode::select('code')->get()
            ->pluck('code')->toArray();

        return $this->getUniqueCode($existingCodes);
    }

    /**
     * @param int $length
     *
     * @return string
     */
    protected function getNonUniqueCode($length = 8)
    {
        return strtoupper(str_random($length));
    }

    /**
     * @return string
     */
    protected function getUniqueCode(array $existingCodes = [])
    {
        do {
            $code = $this->getNonUniqueCode();
        } while (in_array($code, $existingCodes));

        $this->existingCodes[] = $code;

        return $code;
    }
}
