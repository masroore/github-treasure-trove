<?php

namespace App\Actions\User;

use App\Models\Vaults\Site;
use Excepttion;

class AddFaviconToSiteAction
{
    public function execute(Site $site): void
    {
        $url = "https://icons.duckduckgo.com/ip3/{$site->getLinkWithoutProtocol()}.ico";

        try {
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_TIMEOUT, 5);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $data = curl_exec($ch);
            $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            if (($httpcode == '200') || ($httpcode == '302')) {
                $site
                    ->addMediaFromUrl($url)
                    ->toMediaCollection('favicon');
            }
        } catch (Excepttion $exception) {
            report($exception);
        }
    }
}
