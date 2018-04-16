<?php

namespace ConvertKit;


class CustomField extends ConvertKit {

    function __construct($url_base, $api_key, $api_secret_key) {
        parent::__construct($api_key, $api_secret_key);
        $this->url_base    = $url_base;
        $this->request_url = "{$this->url_base}/custom_fields";
    }


    public function setCustomFieldId($id) {
        $this->id = (int)$id;
    }

    public function showall() {
        $request_url = $this->request_url . '?' . http_build_query($this->getSimpleTokenParam());
        $response    = $this->curl($request_url);

        return $response;
    }

    public function add($post_data) {
        $payload  = array_merge($this->getSecretTokenParam(), $post_data);
        $response = $this->curl($this->request_url, $payload);

        return $response;
    }

    public function edit($id = null, $post_data) {
        if ($id) {
            $this->setCustomFieldId($id);
        }
        $payload  = array_merge($this->getSecretTokenParam(), $post_data);
        $response = $this->curl($this->request_url . '/' . $this->id, $payload, 'PUT');

        return $response;
    }

    public function delete($id = null) {
        if ($id) {
            $this->setCustomFieldId($id);
        }
        $payload  = $this->getSecretTokenParam();
        $response = $this->curl($this->request_url . '/' . $this->id, $payload, 'DELETE');

        return $response;
    }

}