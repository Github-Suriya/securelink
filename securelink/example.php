<?php

require_once __DIR__ . '/src/SecureLink.php';

$secureLink = new SecureLink(__DIR__ . '/storage', 'my-very-secret-key');

$timeLink = $secureLink->createTimeLink('https://google.com', 30);
echo $timeLink;

$clickLink = $secureLink->createClickLink('https://mail.yahoo.com', 3);
echo $clickLink;