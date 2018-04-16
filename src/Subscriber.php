<?php

namespace ConvertKit;

class Subscriber extends ConvertKit {

    function __construct($url_base, $api_key, $api_secret_key) {
        parent::__construct($api_key, $api_secret_key);
        $this->url_base    = $url_base;
        $this->request_url = "{$this->url_base}/subscribers/";
    }

    public function showall() {
        $request_url = $this->request_url . '?' . http_build_query($this->getSecretTokenParam());
        $response    = $this->curl($request_url);

        return $response;
    }

    public function view($id) {
        if ($id) {
            $this->setSubscriberId($id);
        }
        $request_url = $this->request_url . '/' . $this->id . '?' . http_build_query($this->getSecretTokenParam());
        $response    = $this->curl($request_url);

        return $response;
    }

    public function setSubscriberId($id) {
        $this->id = (int)$id;
    }


    public function addToCourse($courseId, $subscriberData) {
        $request_url = "{$this->url_base}/courses/" . $courseId . '/subscribe';

        $payload = array_merge($this->getSimpleTokenParam(), $subscriberData);

        $response = $this->curl($request_url, $payload, 'POST');

        return $response;
    }

    public function addToForm($formId, $subscriberData) {
        $request_url = "{$this->url_base}/forms/" . $formId . '/subscribe';

        $payload = array_merge($this->getSimpleTokenParam(), $subscriberData);

        $response = $this->curl($request_url, $payload, 'POST');

        return $response;
    }

    public function removeTag($subscriberId, $tagId) {
        if (!$tagId) {
            return false;
        }
        if (!$subscriberId) {
            return false;
        }

        $request_url = $this->request_url . $subscriberId . '/tags/' . $tagId . '?' . http_build_query($this->getSecretTokenParam());

        $response = $this->curl($request_url, null, 'DELETE');

        return $response;
    }
}