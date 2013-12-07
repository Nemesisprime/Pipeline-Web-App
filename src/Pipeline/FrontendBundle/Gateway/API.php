<?php 

namespace Pipeline/FrontendBundle/Gateway;

use Guzzle\Http\Client;

/**
 * API Gateway class.
 * 
 * @extends Client
 */
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
    
}
