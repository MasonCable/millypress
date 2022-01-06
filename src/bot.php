<?php

namespace Mason\Millypress;

use GuzzleHttp\Client as GuzzleClient;

class Bot
{
    private $baseApiUrl = 'https://patchstack.com/database/api/v2/';

    public function __construct($platform, $packageName, $type, $returnJsonStr = false)
    {        
        $this->platform = $platform; // The platform should always be something link Wordpress, node, npm ...
        $this->packageName = $packageName; // This will be the exact name of the package
        $this->type = $type; // This will be if it is a plugin, package or a theme
        $this->returnJsonStr = $returnJsonStr; // By default we return a php array
        $this->baseStr = 'searchsploit';
        $this->config = require __DIR__.'/../config/index.php';        
    }

    /**
     * This function takes in the init variables and creates a command to run on the host machine. 
     *  The user will recieve a json 
     */
    public function search()
    {        
        $strWData = $this->baseStr.' '.$this->platform.' '.$this->type.' '.$this->packageName;
        $fileName = $this->platform.'-'.$this->type.'-'.$this->packageName.'.json';
        $finalStr = $strWData.' -j -w > '.$fileName;
        
        $exec = exec($finalStr);        
        $jsonStr = file_get_contents($fileName);        
        $removeFile = exec('rm '.$fileName);
        
        return ($this->returnJsonStr) 
                ? $jsonStr 
                : json_decode($jsonStr, true);
    }

    public function searchPatchStack()
    {
        $apiKey = $this->config['patchstack_api'];
        $baseUrl = $this->baseApiUrl;
        $path = 'latest';

        $ch = curl_init();
        $headers = array(
            'PSKey: ' . $apiKey,
            'content-type: application/json',
        );
        curl_setopt($ch, CURLOPT_URL, $baseUrl . $path);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_HEADER, 0);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        return [$response, $httpcode];
                
    }



    /**
     * This function will check and see if we need to install the package or not
     * 
     * @return Null
     */
    public function checkForSearchsploit()
    {        
        $systemType = $this->config['system_type'];

        if($systemType == 'mac') $this->checkAndInstallForMac();
        if($systemType == 'linux') $this->checkAndInstallForLinux();
        if($systemType == 'windows') 'sucks to suck loser';        
    }

    private function checkAndInstallForMac()
    {
        return 'checking mac';
    }

    private function checkAndInstallForLinux()
    {
        return 'checking for linux';
    }
}