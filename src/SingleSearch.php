<?php

namespace Mason\Millypress;

class SingleSearch
{
    private $baseApiUrl = 'https://patchstack.com/database/api/v2/';

    public function __construct($type, $name, $version, $exists = true,$returnJsonStr = false)
    {        
        $this->type = $type; // Type = theme, plugin, wordpress
        $this->name = $name; // Name = Slug of the theme, slug of the plugin, or "wordpress" in case type is set to wordpress
        $this->returnJsonStr = $returnJsonStr; // By default we return a php array
        $this->version = $version; // Version will check for specific vulnerabilities
        $this->exists = $exists; // Optional flag that will no return all vulnerabiliteis, but only a boolean response whether or not there are vulnerabilites. This flag will reult in a faster response.
        $this->baseStr = 'searchsploit';
        $this->config = require __DIR__.'/../config/index.php';        
    }

    /**
     * This function takes in the init variables and creates a command to run on the host machine. 
     *  The user will recieve a json 
     */
    public function searchExploitDb()
    {        
        
    }

    public function searchPatchstack()
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

    public function test()
    {
        return "The test worked";
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