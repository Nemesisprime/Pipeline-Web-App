<?php

namespace Pipeline\APIBundle\Tests\Controller;

use Pipeline\APIBundle\APITest;
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

}
