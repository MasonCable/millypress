<?php

namespace Mason\Millypress;
use Mason\Millypress\Response;


class ScanComposer
{
    private $output_file = 'composer-output.json';
    
    public function __construct()
    {
        $this->config = require __DIR__.'/../config/index.php';
    }

    /**
     * Checks composer package for past and current vulberabilities
     */
    public function checkForVulnerabilities(String $name)
    {                
        $url = 'https://repo.packagist.org/p2/'.$name.'.json';

        # Check and see if the package exists in packagist
        $firstCall = @file_get_contents($url);
        if($firstCall === FALSE) return "Not Found";        
        $data = json_decode($firstCall, true);        
        for($i = 0; $i < count($data['packages'][$name]); $i++){
            $version = $data['packages'][$name][$i]['version'];
            if(!strpos($version, 'beta')){
                return $version;
            }                        
        }
                    
    }
}