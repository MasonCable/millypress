<?php

namespace Mason\Millypress;

class MultiSearch
{
    public function __construct($searchArr)
    {
        /**
         * 
         *  [
    	 *           {"name":"easy-digital-downloads1","version":"1.0.0","type":"plugin","exists":true},
	     *           {"name":"wordpress","version":"3.0.0","type":"wordpress","exists":true}
          *  ]
         */
        $this->searchArr = $searchArr; 
    }

    public function searchPatchstack()
    {
        
    }
}
