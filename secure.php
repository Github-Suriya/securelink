<?php

require_once 'src/SecureLink.php';
$secureLink = new SecureLink(__DIR__.'/storage', 'your-secret-key');

$token = $_GET['token'] ?? '';
$url = $secureLink->resolve($token);

if ($url && !in_array($url, ['Link expired', null])) {
    header("Location: $url");
    exit;
} else {
    echo "Link expired or invalid.";
}
