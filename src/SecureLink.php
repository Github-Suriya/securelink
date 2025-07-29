<?php
// suriya
class SecureLink {
    protected $storage;
    protected $secret;

    public function __construct($storagePath, $secret) {
        $this->storage = $storagePath;
        $this->secret = $secret;
    }

    public function createTimeLink($url, $minutes) {
        $token = bin2hex(random_bytes(16));
        $expires_at = time() + ($minutes * 60);
        $this->saveLink($token, $url, $expires_at, null);
        return $this->generateUrl($token);
    }

    public function createClickLink($url, $maxClicks) {
        $token = bin2hex(random_bytes(16));
        $this->saveLink($token, $url, null, $maxClicks);
        return $this->generateUrl($token);
    }

    protected function saveLink($token, $url, $expires_at = null, $maxClicks = null) {
        $data = [
            'url' => $url,
            'expires_at' => $expires_at,
            'maxClicks' => $maxClicks,
            'clicks' => 0
        ];
        file_put_contents($this->storage . "/$token.json", json_encode($data));
    }

    public function resolve($token) {
        $file = $this->storage . "/$token.json";
        if (!file_exists($file)) return null;
        $data = json_decode(file_get_contents($file), true);

        if ($data['expires_at'] !== null && time() > $data['expires_at']) {
            unlink($file);
            return 'Link expired';
        }

        if ($data['maxClicks'] !== null && $data['clicks'] >= $data['maxClicks']) {
            unlink($file);
            return 'Link expired';
        }

        $data['clicks'] += 1;
        file_put_contents($file, json_encode($data));

        return $data['url'];
    }

    protected function generateUrl($token) {
        return "https://your-domain/securelink/secure.php?token=" . $token;
    }

}
