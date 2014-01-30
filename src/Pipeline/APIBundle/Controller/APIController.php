<?php 

namespace Pipeline\APIBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller,
	Symfony\Component\HttpFoundation\Request,
	Symfony\Component\HttpFoundation\Response;
	
use FOS\RestBundle\Controller\FOSRestController,
	FOS\RestBundle\Controller\Annotations\RouteResource,
	FOS\RestBundle\Routing\ClassResourceInterface;
	
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
	
/**
 * APIController base class.
 */
class APIController extends FOSRestController
{ 
	/**
	 * Compares an object's owner to the user.
	 * 
	 * @access public
	 * @param mixed $object Object with getOwner
	 * @param mixed $user Security User Object
	 * @return boolean
	 */
	public function isOwn($object, $user) 
	{ 
		return ($object->getOwner()->getId() == $user->getId() ? true : false);
	}
    
    /**
     * Returns a REST ready form.
     * Meaning it doesn't have a name and can accept
     * basic parameters. e.g., name instead of form[name]
     * 
     * @access public
     * @param mixed $type
     * @param mixed $object
     * @return void
     */
    public function getRestForm($type, $object) 
    { 
        return $this->get('form.factory')->createNamed(null, $type, $object);
    }
}