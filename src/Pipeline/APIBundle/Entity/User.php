<?php

namespace Pipeline\APIBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * User
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Pipeline\APIBundle\Entity\UserRepository")
 * @ORM\Table(name="pl_user")
 */
class User extends BaseUser
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="joined_at", type="datetime")
     */
    private $joinedAt;
    
    /**
     * Collections!
     */
     
     /**
      * @param \Doctrine\Common\Collections\Collection $tasks
      * @ORM\OneToMany(targetEntity="Task", mappedBy="owner")
      */
     private $tasks;

	/**
	 * Construct (be sure to call parent construct).
	 * 
	 * @access public
	 * @return void
	 */
	public function __construct()
    {
        parent::__construct();
        
        $this->joinedAt = new \DateTime();
        $this->tasks = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set joinedAt
     *
     * @param \DateTime $joinedAt
     * @return User
     */
    public function setJoinedAt($joinedAt)
    {
        $this->joinedAt = $joinedAt;

        return $this;
    }

    /**
     * Get joinedAt
     *
     * @return \DateTime 
     */
    public function getJoinedAt()
    {
        return $this->joinedAt;
    }

    /**
     * Add tasks
     *
     * @param \Pipeline\APIBundle\Entity\Task $tasks
     * @return User
     */
    public function addTask(\Pipeline\APIBundle\Entity\Task $tasks)
    {
        $this->tasks[] = $tasks;

        return $this;
    }

    /**
     * Remove tasks
     *
     * @param \Pipeline\APIBundle\Entity\Task $tasks
     */
    public function removeTask(\Pipeline\APIBundle\Entity\Task $tasks)
    {
        $this->tasks->removeElement($tasks);
    }

    /**
     * Get tasks
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTasks()
    {
        return $this->tasks;
    }
}
