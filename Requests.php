<?php

if(!class_exists('StarRequests')){

  class StarRequests {

    public $url;
    public $method;
    public $headers;
    public $request_args = array();

    public function __construct( $args ) {

      $this->url = $args['url'];
      $this->method = $args['method'];
      $this->headers = $args['headers'];

      $this->request_args = [
        'method' => $this->method,
        'headers' => $this->headers
      ];

    }

    public function send() {

      return wp_remote_request($this->url, $this->request_args);
    }

  }
}

?>
