<?php 

namespace Pipeline\APIBundle;

use Liip\FunctionalTestBundle\Test\WebTestCase;

use Pipeline\APIBundle\Tests\TestConstants;

/**
 * APITest class.
 * 
 * @extends WebTestCase
 */
class APITest extends WebTestCase
{ 
    public $client;

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
        
        $this->client = static::createClient();
        
		$this->login(TestConstants::TEST_USER_USERNAME, TestConstants::TEST_USER_PASSWORD);
    }
    
    public function login($username, $password) 
    {
		$crawler = $this->client->request('GET', '/login');
		$form = $crawler->selectButton('_submit')->form(array(
			'_username'  => $username,
			'_password'  => $password,
			));     
		$this->client->submit($form);
		
		$this->assertTrue($this->client->getResponse()->isRedirect(), "Login failed");
		
		$this->client->followRedirects();
	}
}