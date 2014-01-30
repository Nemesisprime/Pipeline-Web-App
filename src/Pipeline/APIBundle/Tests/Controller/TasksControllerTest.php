<?php

namespace Pipeline\APIBundle\Tests\Controller;

use Pipeline\APIBundle\APITest,
    Pipeline\APIBundle\Constants,
    Pipeline\APIBundle\Tests\TestConstants;

use Symfony\Component\HttpFoundation\Response;

use Pipeline\APIBundle\Entity\Task;

class TasksControllerTest extends APITest
{   
	/**
	 * Test for getTasksAction.
	 * 
	 * @access public
	 * @return void
	 */
	public function testGetTasks()
    {
        $crawler = $this->client->request('GET', '/api/tasks');

        $this->assertTrue(in_array(
            $this->client->getResponse()->getStatusCode(),
            array(Response::HTTP_OK)),
            "There wasn't an OK get Tasks response!"
        );
    }
    
    /**
     * Test for getTaskAction.
     * 
     * @access public
     * @return void
     */
    public function testGetTask() 
    {   
        $crawler = $this->client->request('GET', '/api/tasks/'.TestConstants::TEST_TASK_ID);
        
        $this->assertTrue(in_array(
            $this->client->getResponse()->getStatusCode(),
            array(Response::HTTP_OK)),
            "There wasn't an OK get Task ".TestConstants::TEST_TASK_ID.", which should have been preloaded!"
        );
    }
    
    /**
     * Test for postTasksAction.
     * 
     * @access public
     * @return void
     */
    public function testPostTasks()
    { 
        /* We to set a timezone for this text (more of a fallback for my PHP config). */
        date_default_timezone_set('America/Chicago');

        $task_skeleton = array();
        $task_skeleton['name'] = "Test Task 2";
        $task_skeleton['status'] = Constants::STATUS_ACTIVE;
        $task_skeleton['description'] = "This is a test task meant to stimulate the post API";
        
        $crawler = $this->client->request('POST', '/api/tasks', $task_skeleton);
        
        $this->assertTrue(in_array(
            $this->client->getResponse()->getStatusCode(),
            array(Response::HTTP_CREATED)),
            "There wasn't a CREATED Task - ".$this->client->getResponse()->getContent()." returned."
        );
    }

}
