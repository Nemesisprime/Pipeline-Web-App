<?php

namespace Pipeline\APIBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route,
	Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use FOS\RestBundle\Controller\FOSRestController,
	FOS\RestBundle\Controller\Annotations\RouteResource,
	FOS\RestBundle\Routing\ClassResourceInterface;

use FOS\RestBundle\Request\ParamFetcher,
    FOS\RestBundle\Controller\Annotations\QueryParam,
    FOS\RestBundle\Request\ParamFetcherInterface,
    FOS\RestBundle\Controller\Annotations\RequestParam;

use Pipeline\APIBundle\Entity\Task;
use Pipeline\APIBundle\Form\TaskType;

/**
 * TasksController class.
 */
class TasksController extends FOSRestController
{
    /**
     * [GET] /tasks
     * 
     * @access public
     * @return View Object
     *
     * @Secure("ROLE_USER")
     * @QueryParam(name="offset", requirements="\d+", default="0", description="Offset to fetch results from.")
     * @QueryParam(name="limit", requirements="\d+", default="100", description="Limit result amounts.")
     */
    public function getTasksAction(ParamFetcher $paramFetcher)
    {
        $user = $this->getUser();
        
        $offset = $paramFetcher->get('offset');
        $limit = $paramFetcher->get('limit');
        
        /* We just select all tasks, which is the preferred way  */
        $tasks = $this->getDoctrine()->getRepository("APIBundle:Task")->findTasksFor($user);
        
        /* Hand the tasks to the View and say OK */
        return $this->handleView($this->view($tasks, 200));
    }

    /**
     * [GET] /tasks/{id}
     * 
     * @access public
     * @param mixed $slug
     * @return void
     */
    public function getTaskAction($slug)
    {
	    $user = $this->getUser();
	    $task = $this->getDoctrine()->getRepository("APIBundle:Task")->find($slug);
	    
	    $view = $this->view();
        $view->setStatusCode(501); //Not Implemented, yet. When the API becomes open...
        
        return $this->get('fos_rest.view_handler')->handle($view);
    }
    
    /**
     * [POST] /tasks
     * 
     * @access public
     * @return View Object
     */
    public function postTasksAction()
    {
        $request = $this->getRequest();
        $user = $this->getUser();
        $task = new Task();
        $task->setOwner($user);
        
        $form = $this->createForm(new TaskType(), $task);
        $form->handleRequest($request);
        
        $view = $this->view();
        
        if($form->isValid()) 
        { 
        	$view->setData($task);
            $view->setStatusCode(201, "Task created");
        } else { 
            throw new HttpException(400, $form->getErrorsAsString());
        }
        
        return $this->get('fos_rest.view_handler')->handle($view);
    }
    
    /**
     * [PUT] /tasks/{id}
     * 
     * @access public
     * @param mixed $slug
     * @return View Object
     */
    public function putTasksAction($slug) 
    { 
	    $view = $this->view();
        $view->setStatusCode(501); //Not Implemented, yet. When the API becomes open...
        
        return $this->get('fos_rest.view_handler')->handle($view);
    }
    
    /**
     * [OPTIONS] /tasks=
     * 
     * @access public
     * @return void
     */
    public function optionsTasksAction() 
    { 
        return $this->handleView($this->view(array("status" => array(0 => "STATUS_ACTIVE", 
                                                                     1 => "STATUS_COMPLETE", 
                                                                     2 => "STATUS_PENDING", 
                                                                     3 => "STATUS_REJECTED", 
                                                                     4 => "STATUS_REQUEST"))));
    }
}
