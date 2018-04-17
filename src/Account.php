<?php


namespace ConvertKit;

class Account extends ConvertKit {
    function __construct($url_base, $api_key, $api_secret_key) {
        parent::__construct($api_key, $api_secret_key);
        $this->url_base    = $url_base;
        $this->request_url = "{$this->url_base}/account/";
    }

    public function view() {
        $request_url = $this->request_url . '?' . http_build_query($this->getSecretTokenParam());
        $response    = $this->curl($request_url);

        return $response;
    }
}