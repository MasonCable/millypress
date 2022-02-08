<?php

namespace Mason\Millypress;

use Mason\Millypress\Response;



class ScanWordpress
{
    private $output_file = 'wpscan-output.json';
    private $wpscanUrl = "https://wpscan.com/api/v3/";

    public function __construct()
    {
        $this->config = require __DIR__.'/../config/index.php';        
    }
    /**
     * The function that will run when a user scans their website URL
     * 
     * @return Json
     */
    public function getDataFromUrl(String $url)
    {
        $command = exec('wpscan --url '.$url.' vp --output '.$this->output_file.' --format json');
        $jsonData = file_get_contents($this->output_file);
        $returnJson = json_decode($jsonData, true);
        exec('rm '.$this->output_file);

        return $returnJson;
    }

    /**
     * Function takes in the name of a plugin and will 
     * use wpscan and other services to check for vulnerabilities.
     * 
     * @return Json
     * ['results'], ['code']
     */
    public function scanPluginForVulnerabilities(String $plugin)
    {
        $apiKey = $this->config['wpscan_key'];
        $headers = array(
            'Authorization: Token token='.$apiKey,
            'accept: application/json'         
        );
        // Replace spaces with dash and other future code
        $plugin = $this->fixString($plugin);
        $url = $this->wpscanUrl."plugins/".$plugin;    

        $response = $this->makeRequest($headers, $url);        
        
        return $response;
    }

    private function makeRequest(Array $headers, String $url)
    {
        $client = curl_init();
        
        curl_setopt($client, CURLOPT_URL, $url);
        curl_setopt($client, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($client, CURLOPT_HEADER, 0);
        curl_setopt($client, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($client);
        $httpcode = curl_getinfo($client, CURLINFO_HTTP_CODE);
        curl_close($client);       
        $returnObj = new Response();
        $returnObj->results = json_decode($response, true);
        $returnObj->code = $httpcode; 

        return $returnObj;
    }

    private function fixString(String $str)
    {
        # remove any spaces
        $str = str_replace(' ', '-', $str);

        return $str;
    }
}