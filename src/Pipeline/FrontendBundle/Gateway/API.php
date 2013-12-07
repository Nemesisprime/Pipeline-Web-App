<?php 

namespace Pipeline/FrontendBundle/Gateway;

use Guzzle\Http\Client;

/**
 * API Gateway class.
 * 
 * @extends Client
 */
<<<<<<< HEAD
class API extends Client 
{ 
    protected $container;
    protected $profiler;

    public function __construct($container, $host, $prefix, $profiler=null) {
        /*$this->profiler = $profiler;
        $this->container = $container;
        $base = $host.$prefix;
        parent::__construct($base);*/
    }
=======
class API extends Client { 
    
     public function __construct() { 
         
     }
>>>>>>> 6052b2cec8ccd816bec38689db0fd0c817ebaddc
    
}
