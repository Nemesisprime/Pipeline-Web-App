<?php

namespace Pipeline\APIBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations\RouteResource;
use FOS\RestBundle\Routing\ClassResourceInterface;


/**
 * TasksController class.
 * @RouteResource("Task")
 */
class TasksController extends FOSRestController implements ClassResourceInterface
{
    /**
     * [GET] /tasks
     * 
     * @access public
     * @return void
     */
    public function cgetAction()
    {
        $user = $this->get("security.context")->getToken()->getUser();
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
    public function getAction($slug)
    {
    
    }
}
