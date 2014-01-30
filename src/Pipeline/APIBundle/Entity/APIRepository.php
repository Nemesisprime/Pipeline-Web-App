<?php

namespace Pipeline\APIBundle\Entity;

use Doctrine\ORM\EntityRepository;

use Pipeline\APIBundle\API\BindInterface;

use Pipeline\APIBundle\Entity\User;

/**
 * APIRepository base class.
 */
class APIRepository extends EntityRepository
{
    /**
     * user
     * 
     * (default value: false)
     * 
     * @var bool
     * @access protected
     */
    protected $_user = false;

    /**
     * Utility that fixes the vital data striped from a form
     * via the API. Prefilled data is cleared if not supplied.
     * 
     * @access public
     * @param mixed $object
     * @return void
     */
    public function rebind($object) 
    { 
        if(!($object instanceof BindInterface))
        { 
            throw new \Exception("Your object must implement Pipeline\APIBundle\API\BindInterface");
        }
        
        $object->setCreatedAt(new \DateTime());
        $object->setOwner($this->getUser());
    }

    /**
     * register function.
     * 
     * @access public
     * @param Pipeline\APIBundle\Entity\User $user
     * @return $this
     */
    public function register($user) 
    { 
        $this->setViewingUser($user);
        return $this;
    }
    
    /**
     * Used to internally set the user.
     * 
     * @access public
     * @param Pipeline\APIBundle\Entity\User $user
     * @return void
     */
    public function setViewingUser($user) 
    { 
        $this->_user = $user;
    }

    /**
     * Used to internally get the user for queries.
     * 
     * @access public
     * @return Pipeline\APIBundle\Entity\User
     */
    protected function getUser() 
    { 
        if($this->_user === false)
        { 
            throw new \Exception("No Viewing user has been set for this entity.");
        } else { 
            return $this->_user;
        }
    }
}
