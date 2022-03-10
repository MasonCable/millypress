<?php

namespace Mason\Millypress;
use Mason\Millypress\Response;

class Gitlab
{

    public function makeRequest()
    {
        $token = "glpat-oHV_EnycTxXNpG2xBLC9";
        $url = "https://gitlab.com/api/v4/projects/33927786/repository/files/package.json?ref=master";
        $headers = array(
            'PRIVATE-TOKEN: '.$token
        );
        $client = curl_init();
            
        curl_setopt($client, CURLOPT_URL, $url);
        curl_setopt($client, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($client, CURLOPT_HEADER, 0);
        curl_setopt($client, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($client);
        $httpcode = curl_getinfo($client, CURLINFO_HTTP_CODE);
        curl_close($client);       
        
        return $response;
    }

}