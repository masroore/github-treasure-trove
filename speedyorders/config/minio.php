<?php

return [
    'private_bucket' => env('MINIO_BUCKET'),
    'public_bucket' => env('MINIO_BUCKET_PUBLIC'),
    'public_endpoint' => env('MINIO_ENDPOINT_PUBLIC'),
    'public' => [
    ],
    'private' => [
    ],
];
