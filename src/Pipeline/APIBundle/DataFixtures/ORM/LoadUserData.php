<?php
namespace Pipeline\APIBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture,
	Doctrine\Common\DataFixtures\FixtureInterface,
	Doctrine\Common\DataFixtures\OrderedFixtureInterface,
	Symfony\Component\DependencyInjection\ContainerAwareInterface;

use Symfony\Component\DependencyInjection\ContainerInterface;
	
use Doctrine\Common\Persistence\ObjectManager;

use Pipeline\APIBundle\Entity\User;

use Pipeline\APIBundle\Tests\TestConstants;

/**
 * LoadUserData class.
 * 
 * @implements FixtureInterface
 */
class LoadUserData extends AbstractFixture implements FixtureInterface, ContainerAwareInterface, OrderedFixtureInterface
{
	/**
	 * @var ContainerInterface
	 */
	private $container;

	/**
	 * {@inheritDoc}
	 */
	public function setContainer(ContainerInterface $container = null)
	{
	    $this->container = $container;
	}

    /**
     * Set the test users into the database
     * 
     * @access public
     * @param ObjectManager $manager
     * @return void
     */
    public function load(ObjectManager $manager)
    {
        $userManager = $this->container->get('fos_user.user_manager');
        //make some users
        $user = $userManager->createUser();
        $user->setUsername(TestConstants::TEST_USER_USERNAME);
        $user->setEmail(TestConstants::TEST_USER_EMAIL);
        $user->setPlainPassword(TestConstants::TEST_USER_PASSWORD);
        $userManager->updateUser($user);
        
        $this->addReference('test-user-one', $user);
    }
    
    /**
     * Order this fixture first in line.
     * 
     * @access public
     * @return integer
     */
    public function getOrder()
    {
        return 1;
    }
}