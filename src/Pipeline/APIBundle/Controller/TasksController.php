<?php

namespace Pipeline\APIBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller,
	Symfony\Component\HttpFoundation\Request,
	Symfony\Component\HttpFoundation\Response,
    Symfony\Component\HttpKernel\Exception\HttpException;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route,
	Sensio\Bundle\FrameworkExtraBundle\Configuration\Template,
	Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

use Pipeline\APIBundle\Controller\APIController;
use FOS\RestBundle\Controller\Annotations\RouteResource,
	FOS\RestBundle\Routing\ClassResourceInterface;

use Pipeline\APIBundle\Entity\Task,
	Pipeline\APIBundle\Form\TaskType;

/**
 * TasksController class.
 */
class TasksController extends APIController
{
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
        return $this->handleView($this->view($tasks, Response::HTTP_OK));
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
        $view->setStatusCode(Response::HTTP_OK);
        
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
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $view = $this->view();
        $request = $this->getRequest();
        
        $taskrepo = $em->getRepository("APIBundle:Task")->register($user);
        
        $task = new Task();
        
        /* For future file support */
        $form = $this->getRestForm('task', $task);
        $form->handleRequest($request);
        if($form->isValid()) 
        { 
            $taskrepo->rebind($task);
            $em->persist($task);
            $em->flush();
        
        	$view->setData($task);
            $view->setStatusCode(Response::HTTP_CREATED, "Task created");
        } else { 
            throw new HttpException(Response::HTTP_BAD_REQUEST, $form->getErrorsAsString());
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
        $view->setStatusCode(Response::HTTP_NOT_IMPLEMENTED); //Not Implemented, yet. When the API becomes open...
        
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
