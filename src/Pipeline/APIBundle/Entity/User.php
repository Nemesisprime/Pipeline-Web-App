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
	 * Construct (be sure to call parent construct).
	 * 
	 * @access public
	 * @return void
	 */
	public function __construct()
    {
        parent::__construct();
        
        $this->joinedAt = new \DateTime();
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
}
