<?php

namespace ConvertKit;


class Sequence extends ConvertKit {

    function __construct($url_base, $api_key, $api_secret_key) {
        parent::__construct($api_key, $api_secret_key);
        $this->url_base    = $url_base;
        $this->request_url = "{$this->url_base}/sequences";
    }


    public function setSequenceId($id) {
        $this->id = (int)$id;
    }

    function showall() {
        $request_url = $this->request_url . '?' . http_build_query($this->getSimpleTokenParam());
        $response    = $this->curl($request_url);

        return $response;
    }

    public function listSubscriptions($id = null) {
        if ($id) {
            $this->setSequenceId($id);
        }
        $request_url = $this->request_url . '/' . $this->id . '/subscriptions' . '?' . http_build_query($this->getSecretTokenParam());
        $response    = $this->curl($request_url);

        return $response;
    }
}