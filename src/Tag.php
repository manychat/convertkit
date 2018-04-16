<?php

namespace ConvertKit;

class Tag extends ConvertKit {

    function __construct($url_base, $api_key, $api_secret_key) {
        parent::__construct($api_key, $api_secret_key);
        $this->url_base    = $url_base;
        $this->request_url = "{$this->url_base}/tags";
    }


    public function setTagId($id) {
        $this->id = (int)$id;
    }

    function showall() {
        $request_url = $this->request_url . '?' . http_build_query($this->getSimpleTokenParam());
        $response    = $this->curl($request_url);

        return $response;
    }

    public function addToSubscriber($subscriberData, $id = null) {
        if ($id) {
            $this->setTagId($id);
        }
        $request_url = $this->request_url . '/' . $this->id . '/subscribe';

        $payload = array_merge($this->getSimpleTokenParam(), $subscriberData);

        $response = $this->curl($request_url, $payload, 'POST');

        return $response;
    }

    public function deleteFromSubscriber($subscriberId = null) {
        if (!$subscriberId) {
            return false;
        }
        if (!$this->id) {
            return false;
        }

        $subscriber = new Subscriber($this->url_base, $this->api_key, $this->getSecretTokenParam()[0]);
        $subscriber->removeTag($subscriberId, $this->id);

        return $subscriber;
    }

    public function listSubscriptions($id = null) {
        if ($id) {
            $this->setTagId($id);
        }
        $request_url = $this->request_url . '/' . $this->id . '/subscriptions?' . http_build_query($this->getSecretTokenParam());
        $response    = $this->curl($request_url);

        return $response;
    }
}