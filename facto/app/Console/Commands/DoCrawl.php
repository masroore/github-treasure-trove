<?php

namespace App\Console\Commands;

use App\Cronjob;
use Carbon\Carbon;
use DOMDocument;
use GuzzleHttp\Psr7\Request;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Sunra\PhpSimple\HtmlDomParser;

class DoCrawl extends Command
{
    protected $signature = 'crawl:main';

    protected $description = 'Command description';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle(): void
    {
        $url = 'https://nicelink2.com/';
        $this->checkTooLongStopped();
        $this->main($url);
        sleep(3);
    }

    // function file_get_contents_utf8($fn) {
    //   $content = file_get_contents($fn);
    //   // return mb_convert_encoding($content, 'UTF-8', mb_detect_encoding($content, 'UTF-8, ISO-8859-1', true));
    //   return mb_convert_encoding($content, 'UTF-8');
    // }

    public function file_get_contents_utf8($fn)
    {
        // Create a stream
        $opts = [
            'http' => [
                'method' => 'GET',
                'header' => "Accept-language: en\r\n" .
                          "Cookie: foo=bar\r\n",
            ],
        ];

        $context = stream_context_create($opts);

        $content = file_get_contents($fn, false, $context);

        return mb_convert_encoding($content, 'UTF-8', mb_detect_encoding($content, 'UTF-8, ISO-8859-1', true));
    }

    public function checkTooLongStopped(): void
    {
        $job = Cronjob::find(1);
        $status = $job->status;
        $updated_at = $job->updated_at;
        $ddd = Carbon::now()->diffInMinutes($updated_at);
        echo $status . "\n";
        echo $updated_at . "\n";
        echo Carbon::now();
        echo "\n";

        if ($status == 1 && $ddd >= 65) {
            $job->status = 0;
            $job->save();
        }
    }

    public function main($url): void
    {
        $html = $this->file_get_contents_utf8($url);

        $dom = HtmlDomParser::str_get_html($html);
        // // $dom = HtmlDomParser::file_get_html( $file_name );
        $domain = false;
        $elems = $dom->find('a');
        foreach ($elems as $ele) {
            $href = $ele->href;
            echo $href . "\n";
            if (Str::contains($href, 'wfwf')) {
                $domain = $href;

                break;
            }
        }

        if ($domain) {
            echo ' domain : ' . $domain . "\n";

            if (substr($domain, -1) == '/') {
                $domain = substr($domain, 0, -1);
            }

            echo 'saved Domain : ' . $domain . "\n";

            Storage::put('domain.dat', $domain);
        }
    }

    public function getURL($url, $data): void
    {
        // $client = new Client();

        $client = new \GuzzleHttp\Client();
        $url = 'https://wfwf10.com/ing';
        $response = $client->request('GET', $url);
        // $response = $client->request('GET', 'https://wfwf10.com/end?o=n&type1=genre');

        // echo $response->getStatusCode(); # 200
        // echo $response->getHeaderLine('content-type'); # 'application/json; charset=utf8'
        $html = $response->getBody(true)->getContents();
        // $name = HTMLDomParser::str_get_html($html)->find('div.webtoon-list > a')[0]->plaintext;
        dd($html);
        $dom = new DOMDocument();
        $dom->loadHTML($html);
        $dom->preserveWhiteSpace = false;
        // $webtoon_list = $dom->getElement
    }

    public function initPage(): void
    {
    }
}
