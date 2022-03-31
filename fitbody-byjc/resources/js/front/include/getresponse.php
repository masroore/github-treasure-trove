<?php

require_once 'getresponse/GetResponseAPI3.class.php';

$getresponse = new GetResponse('your-api-key');

$getresponse->addContact([
    'name'              => $name,
    'email'             => $email,
    'dayOfCycle'        => 0,
    'campaign'          => ['campaignId' => 'your-campaign-id'],
    'ipAddress'         => $_SERVER['REMOTE_ADDR'],
]);
