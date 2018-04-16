<?php

namespace ConvertKit;

use ConvertKit\exceptions\ResponseException;

class Connector {


    public    $api_url_base = 'https://api.convertkit.com';
    protected $api_version  = 3;
    public    $api_key;
    public    $api_secret_key;
    public    $base_url;
    public    $version      = 1;

    function __construct($api_key, $api_secret_key) {
        $this->base_url       = $this->api_url_base . '/v' . $this->api_version;
        $this->api_key        = $api_key;
        $this->api_secret_key = $api_secret_key;
    }

    public function curl($url, $params_data = [], $verb = "") {


        $request = curl_init();
        //        curl_setopt($request, CURLOPT_HEADER, 0);
        curl_setopt($request, CURLOPT_RETURNTRANSFER, true);

        if ($params_data && $verb == "GET") {
            if ($this->version == 2) {
                $url .= "&" . $params_data;
                curl_setopt($request, CURLOPT_URL, $url);
            }
        } else {
            curl_setopt($request, CURLOPT_URL, $url);
            if ($params_data && !$verb) {
                // if no verb passed but there IS params data, it's likely POST.
                $verb = "POST";
            } elseif ($verb) {
                // $verb is likely "POST" or "PUT".
            } else {
                $verb = "GET";
            }
        }
        if ($verb == "POST" || $verb == "PUT" || $verb == "DELETE") {

            $params_data = json_encode($params_data);

            if ($verb == "PUT") {
                curl_setopt($request, CURLOPT_CUSTOMREQUEST, "PUT");
            } elseif ($verb == "DELETE") {
                curl_setopt($request, CURLOPT_CUSTOMREQUEST, "DELETE");
            } else {
                $verb = "POST";
                curl_setopt($request, CURLOPT_POST, 1);

                curl_setopt($request, CURLOPT_CUSTOMREQUEST, "POST");
            }


            curl_setopt($request, CURLOPT_POSTFIELDS, $params_data);
            curl_setopt($request, CURLOPT_HTTPHEADER, [
                                    'Content-Type: application/json',
                                    'Content-Length: ' . strlen($params_data)]
            );

        }
        curl_setopt($request, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($request, CURLOPT_SSL_VERIFYHOST, 0);

        $response   = curl_exec($request);
        $curl_error = curl_error($request);
        if (!$response && $curl_error) {
            return $curl_error;
        }
        $http_code = curl_getinfo($request, CURLINFO_HTTP_CODE);
        if (!preg_match("/^[2-3][0-9]{2}/", $http_code)) {
            // If not 200 or 300 range HTTP code, return custom error.
            throw new ResponseException("HTTP code {$http_code} returned", $http_code);
        }
        curl_close($request);

        return json_decode($response);
    }

}