<?php

namespace ConvertKit;

class ConvertKit extends Connector {
    public $api_key;
    public $api_secret_key;
    public $url_base;
    public $request_url;
    public $id;

    protected function getSimpleTokenParam() {
        if ($this->api_secret_key !== null) {
            return ['api_secret' => $this->api_secret_key];
        }

        return ['api_key' => $this->api_key];
    }

    protected function getSecretTokenParam() {
        return ['api_secret' => $this->api_secret_key];
    }


    public function subscriber($id = null) {

        $class = new Subscriber($this->base_url, $this->api_key, $this->api_secret_key);
        if (!$id) {
            return $class;
        }

        $class->setSubscriberId($id);

        return $class;
    }

    public function sequence($id = null) {

        $class = new Sequence($this->base_url, $this->api_key, $this->api_secret_key);
        if (!$id) {
            return $class;
        }

        $class->setSequenceId($id);

        return $class;
    }


    public function webhook() {
        $class = new Webhook($this->base_url, $this->api_key, $this->api_secret_key);

        return $class;
    }


    public function form($id = null) {
        $class = new Form($this->base_url, $this->api_key, $this->api_secret_key);
        if (!$id) {
            return $class;
        }

        $class->setFormId($id);

        return $class;
    }


    public function tag($id = null) {
        $class = new Tag($this->base_url, $this->api_key, $this->api_secret_key);
        if (!$id) {
            return $class;
        }

        $class->setTagId($id);

        return $class;
    }

    public function customfield($id = null) {
        $class = new CustomField($this->base_url, $this->api_key, $this->api_secret_key);
        if (!$id) {
            return $class;
        }

        $class->setCustomFieldId($id);

        return $class;
    }

    public function account() {
        return new Account($this->base_url, $this->api_key, $this->api_secret_key);
    }

}


