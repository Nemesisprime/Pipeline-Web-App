<?php

namespace Pipeline\APIBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller,
	Symfony\Component\HttpFoundation\Request;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route,
	Sensio\Bundle\FrameworkExtraBundle\Configuration\Template,
	Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

use FOS\RestBundle\Controller\FOSRestController,
	FOS\RestBundle\Controller\Annotations\RouteResource,
	FOS\RestBundle\Routing\ClassResourceInterface;

use Pipeline\APIBundle\Entity\Task,
	Pipeline\APIBundle\Form\TaskType;

/**
 * TasksController class.
 */
class TasksController extends FOSRestController
{

	public function isOwn($task, $user) 
	{ 
		return ($task->getOwner()->getId() == $user->getId() ? true : false);
	}


    /**
     * [GET] /api/tasks
     * 
     * @access public
     * @return View Object
     *
     * @Security("has_role('ROLE_USER')")
     */
    public function getTasksAction(Request $request)
    {
        $user = $this->getUser();
        
        $offset = $request->query->getInt('offset', 0);
        $limit = $request->query->getInt('limit', 100);
        
        /* We just select all tasks, which is the preferred #dev way  */
        $tasks = $this->getDoctrine()->getRepository("APIBundle:Task")->findTasksFor($user);
        
        /* Hand the tasks to the View and say OK */
        return $this->handleView($this->view($tasks, 200));
    }

    /**
     * [GET] /tasks/{id}
     * 
     * @access public
     * @param mixed $id - individual task ID, this won't be called very often so we'll heavily cache
     * that shit.
     * @return View Object
     *
     * @Security("has_role('ROLE_USER')")
     */
    public function getTaskAction($id)
    {
	    $user = $this->getUser();
	    $task = $this->getDoctrine()->getRepository("APIBundle:Task")->find($id);
	    
	    if(!$task || !$this->isOwn($task, $user)) { 
		    throw $this->createNotFoundException("No task ID $id is available.");
	    }
	    
	    $view = $this->view();
        $view->setData($task);
        $view->setStatusCode(200);
        
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
