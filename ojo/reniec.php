<?php

$content = http_build_query(
    [
        'type_doc' => 'dni',
        'number_doc' => '42464222',
    ]
);

$header = [
    'Content-Type: application/x-www-form-urlencoded',
    'Content-Length: ' . strlen($content),
    'Host : api-peru.com',
    'Content-Length :  41',
    'User-Agent:  Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.88 Safari/537.36',
    'Content-Type: application/x-www-form-urlencoded',
    'Accept: /',
    'Origin:  http://api-peru.com',
    'Referer : http://api-peru.com/',
    'Accept-Encoding : gzip, deflate',
    'Accept-Language: es-ES,es;q=0.9',
    'Connection: close',
];

$options = [
    'http' => [
        'method' => 'POST',
        'content' => $content,
        'header' => implode("\r\n", $header),
    ],

];

$context = stream_context_create($options);

$file = file_get_contents('http://api-peru.com/consultaDoc.php', false, $context);

print_r($file);
