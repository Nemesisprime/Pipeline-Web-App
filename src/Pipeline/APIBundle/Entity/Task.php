<?php

namespace Pipeline\APIBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use Pipline\APIBundle\Constants;

use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;


/**
 * Task
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Pipeline\APIBundle\Entity\TaskRepository")
 *
 * @ExclusionPolicy("all")
 */
class Task
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     * @Expose
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=150, nullable=true)
     *
     * @Expose
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="integer")
     *
     * @Expose
     */
    private $status;

    /**
     * @var integer
     *
     * @ORM\ManyToOne(targetEntity="User", inversedBy="tasks")
     */
    private $owner;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     *
     * @Expose
     */
    private $description;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     *
     * @Expose
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="scheduled_at", type="datetime", nullable=true)
     *
     * @Expose
     */
    private $scheduledAt;
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="due_at", type="datetime", nullable=true)
     *
     * @Expose
     */
    private $dueAt;

    /**
     * @var integer
     *
     * @ORM\Column(name="priority", type="integer", nullable=true)
     */
    private $priority;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="completed_at", type="datetime", nullable=true)
     *
     * @Expose
     */
    private $completedAt;

    /**
     * @ORM\OneToMany(targetEntity="Task", mappedBy="parentTask")
     *
     * @Expose
     */
    private $subtasks;

	/**
     * @ORM\ManyToOne(targetEntity="Task", inversedBy="subtasks")
     *
     * @Expose  
     */
    private $parentTask;


    /**
     * Constructor
     */
    public function __construct()
    {
    	$this->createdAt = new \DateTime();
    	$this->owner = 1;
    	$this->status = Constants::STATUS_PENDING;
    
        $this->subtasks = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set name
     *
     * @param string $name
     * @return Task
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set status
     *
     * @param integer $status
     * @return Task
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return integer 
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Task
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Task
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime 
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     * @return Task
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime 
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set scheduledAt
     *
     * @param \DateTime $scheduledAt
     * @return Task
     */
    public function setScheduledAt($scheduledAt)
    {
        $this->scheduledAt = $scheduledAt;

        return $this;
    }

    /**
     * Get scheduledAt
     *
     * @return \DateTime 
     */
    public function getScheduledAt()
    {
        return $this->scheduledAt;
    }

    /**
     * Set dueAt
     *
     * @param \DateTime $dueAt
     * @return Task
     */
    public function setDueAt($dueAt)
    {
        $this->dueAt = $dueAt;

        return $this;
    }

    /**
     * Get dueAt
     *
     * @return \DateTime 
     */
    public function getDueAt()
    {
        return $this->dueAt;
    }

    /**
     * Set priority
     *
     * @param integer $priority
     * @return Task
     */
    public function setPriority($priority)
    {
        $this->priority = $priority;

        return $this;
    }

    /**
     * Get priority
     *
     * @return integer 
     */
    public function getPriority()
    {
        return $this->priority;
    }

    /**
     * Set completedAt
     *
     * @param \DateTime $completedAt
     * @return Task
     */
    public function setCompletedAt($completedAt)
    {
        $this->completedAt = $completedAt;

        return $this;
    }

    /**
     * Get completedAt
     *
     * @return \DateTime 
     */
    public function getCompletedAt()
    {
        return $this->completedAt;
    }

    /**
     * Add subtasks
     *
     * @param \Pipeline\APIBundle\Entity\Task $subtasks
     * @return Task
     */
    public function addSubtask(\Pipeline\APIBundle\Entity\Task $subtasks)
    {
        $this->subtasks[] = $subtasks;

        return $this;
    }

    /**
     * Remove subtasks
     *
     * @param \Pipeline\APIBundle\Entity\Task $subtasks
     */
    public function removeSubtask(\Pipeline\APIBundle\Entity\Task $subtasks)
    {
        $this->subtasks->removeElement($subtasks);
    }

    /**
     * Get subtasks
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getSubtasks()
    {
        return $this->subtasks;
    }

    /**
     * Set parentTask
     *
     * @param \Pipeline\APIBundle\Entity\Task $parentTask
     * @return Task
     */
    public function setParentTask(\Pipeline\APIBundle\Entity\Task $parentTask = null)
    {
        $this->parentTask = $parentTask;

        return $this;
    }

    /**
     * Get parentTask
     *
     * @return \Pipeline\APIBundle\Entity\Task 
     */
    public function getParentTask()
    {
        return $this->parentTask;
    }

    /**
     * Set owner
     *
     * @param \Pipeline\APIBundle\Entity\User $owner
     * @return Task
     */
    public function setOwner(\Pipeline\APIBundle\Entity\User $owner = null)
    {
        $this->owner = $owner;

        return $this;
    }

    /**
     * Get owner
     *
     * @return \Pipeline\APIBundle\Entity\User 
     */
    public function getOwner()
    {
        return $this->owner;
    }
}
