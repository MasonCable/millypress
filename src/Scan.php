<?php

namespace Mason\Millypress;

class Scan
{
    public function __construct(string $url, $websiteList = false)
    {   
        $this->url = $url;        
        $this->websiteList = $websiteList;
        $this->outputFile = 'wpscanOutput.json';        
    }

    public function scan()
    { 
        if($this->websiteList) $this->scanMany();

        $command = exec('wpscan --url '.$this->url.' vp --output '.$this->outputFile.' --format json');
        $jsonData = file_get_contents($this->outputFile);
        $returnJson = json_decode($jsonData, true);
        exec('rm '.$this->outputFile);

        return $returnJson;
    }

    private function scanMany()
    {
        for($i = 0; $i < count($this->websiteList); $i++){
            $command = exec('wpscan --url '.$this->url.' vp --output '.$this->outputFile.' --format json');            
        }
    }
}