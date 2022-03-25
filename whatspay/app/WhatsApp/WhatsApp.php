<?php

namespace App\WhatsApp;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;

class WhatsApp
{
    protected const WBA_VERSION = 'v1';
    protected const HEADERS_ACCEPT = 'application/json';
    protected const HEADERS_CONTENT_TYPE = 'application/json';
    protected const HEADERS_CHARSET = 'charset=utf-8';
    protected $endpoint = 'https://whatsapp-api-840.clare.ai/';
    protected $headers;
    protected $url;
    protected $client;
    protected $template;
    protected $token = 'eyJhbGciOiAiSFMyNTYiLCAidHlwIjogIkpXVCJ9.eyJ1c2VyIjoiYWRtaW4iLCJpYXQiOjE2MzY1MTgzNzgsImV4cCI6MTYzNzEyMzE3OCwid2E6cmFuZCI6ImM3N2QyYmRhMzIzODkxODhkNTc4Mzg5NTk1OWIyZGZlIn0.9ilDyPEF3WAvYdcTK8EXZ-xOb06WWVXs8VVJ5KJGGvE';

    public function __construct()
    {
        $this->client = new Client();
    }

    public function addContact($contact)
    {
        $this->url = $this->endpoint . self::WBA_VERSION . '/contacts';

        $this->requestHeaders();

        $response = $this->httpRequest('POST', [
            'json' => [
                'blocking' => 'wait',
                'contacts' =>  [
                    $contact,
                ],
            ],
        ]);

        return 'valid' == $response->contacts[0]->status ? true : false;
    }

    public function sendTemplate($to)
    {

        // add contact
        $valid = $this->addContact($to);

        // if valid send message
        if ($valid) {
            $this->url = $this->endpoint . self::WBA_VERSION . '/messages/';

            $this->requestHeaders();

            $response = $this->httpRequest('POST', $this->template);
        }
    }

    public function sendOneTimePin($data)
    {
        $this->template = [
            'json' => [
                'to' => $data['to'],
                'recipient_type' => 'individual',
                'type' => 'template',
                'template' => [
                    'namespace' => '308e0887_7362_44b2_bc9d_3c603527f1bd',
                    'name' => $data['template_name'],
                    'language' => [
                        'code' => 'en_US',
                        'policy' => 'deterministic',
                    ],
                    'components' => [
                        [
                            'type' => 'header',
                            'parameters' => [
                                [
                                'type' => 'image',
                                    'image' => [
                                        'link' => 'https://www.whatspays.com/assets/images/whatspays-shopping-experience.jpg',
                                    ],
                                ],
                            ],
                        ],
                        [
                            'type' => 'body',
                            'parameters' => [
                                ['type' => 'text', 'text' => $data['name']],
                                ['type' => 'text', 'text' => $data['code']],
                            ],
                        ],
                        [
                            'type' => 'button',
                            'sub_type' => 'url',
                            'index' => '0',
                            'parameters' => [
                                ['type' => 'text', 'text' => $data['hash']],
                            ],
                        ],
                    ],
                ],
            ],
        ];
    }

    public function requestHeaders($type = 'auth')
    {
        switch ($type) {
            case 'auth':
                $this->headers = [
                    'Accept' => self::HEADERS_ACCEPT,
                    'Content-Type' => self::HEADERS_CONTENT_TYPE . ';' . self::HEADERS_CHARSET,
                    'Authorization' => 'Bearer ' . $this->token,
                ];
            break;

            case 'no-auth':
                $this->headers = [self::HEADERS_CONTENT_TYPE];
            break;
        }
    }

    public function httpRequest($method, $body)
    {
        $response = Http::withHeaders(
            $this->headers
        )->send($method, $this->url, $body);

        if ($response->successful()) {
            return json_decode($response->body());
        }
    }
}
