<?php

namespace Khaliddurani;

class Chainpoint {
  var $serverBaseUrl = '';
  const LIST = ['http://3.17.155.208', 'http://18.191.50.129', 'http://18.224.185.143'];

  static function pickupServer() {
    $index = rand(0, count(self::LIST) - 1);
    return self::LIST[$index];
  }

  function __construct() {
    $this->serverBaseUrl = self::pickupServer();
  }

  function submitData($data) {
    $hash = hash("sha256", $data);
    if (empty($this)) return self::submit($hash);
    else return $this->submit($hash);
  }

  function submit(string $hash) {
    
    $urlBase = $this->serverBaseUrl;
    $options = [
      'http' => [
        'header' => "Content-Type: application/json\r\n",
        'method' => 'POST',
        'content' => json_encode(['hashes' => [$hash]])
      ]
    ];

    return json_decode(
      file_get_contents(
        $urlBase . '/hashes', false, stream_context_create($options)
      ),
      true
    );
  }


  function verify(string $proof) {
    if (empty($this)) $urlBase = self::pickupServer();
    else $urlBase = $this->serverBaseUrl;
    $options = [
      'http' => [
        'header' => "Content-Type: application/json\r\n",
        'method' => 'POST',
        'content' => json_encode(['proofs' => [$proof]])
      ]
    ];
    return json_decode(
      file_get_contents(
        $urlBase . '/verify', false, stream_context_create($options)
      ),
      true
    );
  }
}
