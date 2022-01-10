<?php

namespace Mason\Millypress;

class Scan
{
    private $outputFile = 'wpscanOutput.json';

    
    /**
     * This function will return the output of ```wpscan --url example.com vp --output outputFile.json --format json ```
     * in JSON format
     * 
     * @return Json
     */
    public function scan($url)
    {         
        $command = exec('wpscan --url '.$url.' vp --output '.$this->outputFile.' --format json');
        $jsonData = file_get_contents($this->outputFile);
        $returnJson = json_decode($jsonData, true);
        exec('rm '.$this->outputFile);

        return $returnJson;
    }

    /**
     * This is an optional function that will update the model based the $data provided
     *  The data should be formated like so:
     * 
     * @return update $Model
     */
    public function updateModel($model, $data)
    {

    }

    /**
     * This function takes in a list of websites and will run the following command ```wpscan --url example.com vp --output outputFile.json --format json ```
     * on each item in the array and then update their associative model
     * 
     * @return update $model
     */
    public function scanMany($websiteList)
    {
        for($i = 0; $i < count($websiteList); $i++){
            // $command = exec('wpscan --url '.$url.' vp --output '.$outputFile.' --format json');            
        }
    }

    
}