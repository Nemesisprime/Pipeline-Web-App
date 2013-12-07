<?php

namespace Pipeline\APIBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations\RouteResource;
use FOS\RestBundle\Routing\ClassResourceInterface;

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
     * @return void
     */
    public function getTasksAction()
    {
        $user = $this->getUser();
        $tasks = $this->getDoctrine()->getRepository("APIBundle:Task")->findTasksFor($user);
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

    }
    
    /**
     * [POST] /tasks
     * 
     * @access public
     * @return void
     */
    public function postTasksAction()
    {
        $request = $this->getRequest();
        $user = $this->getUser();
        $task = new Task();
        $task->setOwner($user);
        
        $form = $this->createForm(new TaskType(), $task);
        $form->handleRequest($request);
        
        if($form->isValid()) 
        { 
            throw new HttpException("Yolo1");
        } else { 
            throw new HttpException("Yolo2");
        }
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
