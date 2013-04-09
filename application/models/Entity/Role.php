<?php

namespace models\Entity;

/**
 *
 * @Table(name="roles")
 * @Entity(repositoryClass="models\Repository\RoleRepository")
 * @HasLifecycleCallbacks
 */
class Role {

    /**
     * @var integer $id
     *
     * @Column(name="id", type="integer")
     * @Id
     * @GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    /**
     * @var integer $role
     *
     * @OneToOne(targetEntity="models\Entity\Type")
     */
    private $roleType;
    
    /**
     * This is the status
     * @var type 
     * @Column(name="status", type="boolean")
     */
    protected $status;

    /**
     * @var integer $users
     *
     * @ManyToMany(targetEntity="models\Entity\User", mappedBy="rolesaccess")
     */
    private $users;
    
    /**
     *
     * @var date
     * @Column(name="createdAt", type="datetime")
     */
    protected $createdAt;
    
    /**
     *
     * @var date
     * @Column(name="updatedAt", type="datetime", nullable=true)
     */
    protected $updatedAt;
    
    /**
     *
     * @var date
     * @Column(name="disabledAt", type="datetime", nullable=true)
     */
    protected $disabledAt;
    
    public function __toString() {
        return $this->getRoleType()->getName();
    }
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->status = true;
        $this->users = new \Doctrine\Common\Collections\ArrayCollection();
        $this->createdAt = new \DateTime();
    }
    
    /**
     * @PreUpdate()
     */
    public function preUpdatedAt() {
        $this->updatedAt = new \DateTime();
        if (!$this->getStatus()) {
            $this->disabledAt = new \DateTime();
        }
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
     * Set status
     *
     * @param boolean $status
     * @return Role
     */
    public function setStatus($status)
    {
        $this->status = $status;
    
        return $this;
    }

    /**
     * Get status
     *
     * @return boolean 
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Role
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
     * @return Role
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
     * Set disabledAt
     *
     * @param \DateTime $disabledAt
     * @return Role
     */
    public function setDisabledAt($disabledAt)
    {
        $this->disabledAt = $disabledAt;
    
        return $this;
    }

    /**
     * Get disabledAt
     *
     * @return \DateTime 
     */
    public function getDisabledAt()
    {
        return $this->disabledAt;
    }

    /**
     * Set roleType
     *
     * @param \models\Entity\Type $roleType
     * @return Role
     */
    public function setRoleType(\models\Entity\Type $roleType = null)
    {
        $this->roleType = $roleType;
    
        return $this;
    }

    /**
     * Get roleType
     *
     * @return \models\Entity\Type 
     */
    public function getRoleType()
    {
        return $this->roleType;
    }

    /**
     * Add users
     *
     * @param \models\Entity\User $users
     * @return Role
     */
    public function addUser(\models\Entity\User $users)
    {
        $this->users[] = $users;
    
        return $this;
    }

    /**
     * Remove users
     *
     * @param \models\Entity\User $users
     */
    public function removeUser(\models\Entity\User $users)
    {
        $this->users->removeElement($users);
    }

    /**
     * Get users
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getUsers()
    {
        return $this->users;
    }
}