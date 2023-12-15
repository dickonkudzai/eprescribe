<?php

namespace config;
use Infobip\Configuration;
class InfobipConfig
{
    private $hostBaseUrl;
    private $apiKey;
    public function __construct($hostBaseUrl, $apiKey)
    {
        $this->hostBaseUrl = $hostBaseUrl;
        $this->apiKey = $apiKey;
    }

    public function getConfiguration($mobileNumber, $message){
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => ''.$this->hostBaseUrl.'/sms/2/text/advanced',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>'{"messages":[{"destinations":[{"to":"'.$mobileNumber.'"}],"from":"EPrescribe","text":"'.$message.'"}]}',
            CURLOPT_HTTPHEADER => array(
                'Authorization: App '.$this->apiKey,
                'Content-Type: application/json',
                'Accept: application/json'
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }

}