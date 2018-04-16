<?php


namespace ConvertKit;

class Form extends ConvertKit {
    function __construct($url_base, $api_key, $api_secret_key) {
        parent::__construct($api_key, $api_secret_key);
        $this->url_base    = $url_base;
        $this->request_url = "{$this->url_base}/forms/";
    }

    public function showall() {
        $request_url = $this->request_url . '?' . http_build_query($this->getSecretTokenParam());
        $response    = $this->curl($request_url);

        return $response;
    }

    public function setFormId($id) {
        $this->id = (int)$id;
    }


    public function listSubscriptions($id = null) {
        if ($id) {
            $this->setFormId($id);
        }
        $request_url = $this->request_url . '/' . $this->id . '/subscriptions' . '?' . http_build_query($this->getSecretTokenParam());
        $response    = $this->curl($request_url);

        return $response;
    }
}