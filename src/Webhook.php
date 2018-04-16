<?php

namespace ConvertKit;

class Webhook extends ConvertKit {

    public function __construct($url_base, $api_key, $api_secret_key) {
        parent::__construct($api_key, $api_secret_key);
        $this->url_base    = $url_base;
        $this->request_url = "{$this->url_base}/automations/hooks";
    }

    public function add($post_data) {
        $payload  = array_merge($this->getSecretTokenParam(), $post_data);
        $response = $this->curl($this->request_url, $payload);

        return $response;
    }

    public function delete($id) {
        $payload  = [$this->getSecretTokenParam()];
        $response = $this->curl($this->request_url . '/' . $id, $payload, 'DELETE');

        return $response;
    }


}