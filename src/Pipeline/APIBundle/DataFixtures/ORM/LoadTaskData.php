<?php
namespace Pipeline\APIBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture,
	Doctrine\Common\DataFixtures\FixtureInterface,
	Doctrine\Common\DataFixtures\OrderedFixtureInterface,
	Symfony\Component\DependencyInjection\ContainerAwareInterface;

use Symfony\Component\DependencyInjection\ContainerInterface;
	
use Doctrine\Common\Persistence\ObjectManager;

use Pipeline\APIBundle\Constants;
use Pipeline\APIBundle\Entity\User,
	Pipeline\APIBunle\Entity\Task;

/**
 * LoadUserData class.
 * 
 * @implements FixtureInterface
 */
class LoadTaskData extends AbstractFixture implements FixtureInterface, ContainerAwareInterface, OrderedFixtureInterface
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
        $task = new Task();
        $task->setName("Test 1");
        $task->setOwner($this->getReference('test-user-one'));
        $task->setStatus(Constants::STATUS_ACTIVE);
        $task->setDescription("This is a test Task, friends");

        $manager->persist($task);
        $manager->flush();
    }
    
    /**
     * Order this fixture second in line.
     * 
     * @access public
     * @return integer
     */
    public function getOrder()
    {
        return 2;
    }
}