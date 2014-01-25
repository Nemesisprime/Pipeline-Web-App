<?php 

namespace Pipeline\APIBundle\Tests;

use Liip\FunctionalTestBundle\Test\WebTestCase;

use Pipeline\APIBundle\Tests\ConstantsTest;

/**
 * APITest class.
 * 
 * @extends WebTestCase
 */
class APITest extends WebTestCase
{ 
	/**
	 * Set up and load the fixtures.
	 * 
	 * @access public
	 * @return void
	 */
	public function setUp()
    {
        $classes = array(
            'Pipeline\APIBundle\DataFixtures\ORM\LoadUserData',
            'Pipeline\APIBundle\DataFixtures\ORM\LoadTaskData'
        );
        $this->loadFixtures($classes);
        
		$this->login(ConstantsTest::TEST_USER_USERNAME, ConstantsTest::TEST_USER_PASSWORD);
    }
    
    public function doLogin($username, $password) 
    {
		$crawler = $this->client->request('GET', '/login');
		$form = $crawler->selectButton('_submit')->form(array(
			'_username'  => $username,
			'_password'  => $password,
			));     
		$this->client->submit($form);
		
		$this->assertTrue($this->client->getResponse()->isRedirect());
		
		$crawler = $this->client->followRedirect();
	}
}