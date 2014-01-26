<?php

namespace Pipeline\APIBundle\Tests\Controller;

use Pipeline\APIBundle\APITest,
    Pipeline\APIBundle\Constants,
    Pipeline\APIBundle\Tests\TestConstants;

use Symfony\Component\HttpFoundation\Response;

class TasksControllerTest extends APITest
{   
	/**
	 * Test the getTasksAction.
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
    
    public function testGetTask() 
    {   
        $crawler = $this->client->request('GET', '/api/tasks/'.TestConstants::TEST_TASK_ID);
        
        $this->assertTrue(in_array(
            $this->client->getResponse()->getStatusCode(),
            array(Response::HTTP_OK)),
            "There wasn't an OK get Task ".TestConstants::TEST_TASK_ID.", which should have been preloaded!"
        );
    }
    
    public function testPostTasks()
    { 
        $task_skeleton = array();
        $task_skeleton['name'] = "Test Task 2";
        $task_skeleton['stastus'] = Constants::STATUS_ACTIVE;
        $task_skeleton['description'] = "This is a test task meant to stimulate the post API";
        //$task_skeleton[''] = "";
        
        $crawler = $this->client->request('POST', '/api/tasks', $task_skeleton);
        
        $this->assertTrue(in_array(
            $this->client->getResponse()->getStatusCode(),
            array(Response::HTTP_CREATED)),
            "There wasn't a CREATED Task."
        );
    }

}
