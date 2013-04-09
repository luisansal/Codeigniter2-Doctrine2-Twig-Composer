<?php
namespace models\Entity;

/**
 * @Table(name="users")
 * @Entity(repositoryClass="models\Repository\UserRepository")
 */
class User {
    /**
     * @var integer $id
     *
     * @Column(name="id", type="integer")
     * @Id
     * @GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string $name
     *
     * @Column(name="name", type="string", length=45)
     */
    private $name;
    
    /**
     * @var string $lastname
     *
     * @Column(name="lastname", type="string", length=45)
     */
    private $lastName;
    
    /**
     *
     * @var date
     * @Column(name="dateborn", type="date") 
     */
    protected $dateBorn;

    /**
     * @var string $phone
     *
     * @Column(name="phone", type="string", length=15)
     */
    private $phone;

    /**
     * @var string $phonemovil
     *
     * @Column(name="phonemovil", type="string", length=15, nullable=true)
     */
    private $phoneMovil;

    /**
     * @var string $email
     *
     * @Column(name="email", type="string", length=100)
     */
    private $email;

    /**
     * @var string $address
     *
     * @Column(name="address", type="string", length=250)
     */
    private $address;

    /**
     * @var string $code
     *
     * @Column(name="code", type="string", length=30)
     */
    private $code;

    /**
     * @var string $password
     *
     * @Column(name="password", type="string", length=300)
     */
    private $password;

    /**
     * @var string $salt
     *
     * @Column(name="salt", type="string", length=255, nullable=true)
     */
    private $salt;

    /**
     *
     * @var date
     * @Column(name="createdAt", type="datetime")
     */
    private $createdAt;

    /**
     *
     * @var date
     * @Column(name="updatedAt", type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     *
     * @var date
     * @Column(name="disabledAt", type="datetime", nullable=true)
     */
    private $disabledAt;

    /**
     * @var integer $sexType
     * 
     * @ManyToOne(targetEntity="models\Entity\Type")
     
    private $sexType;*/

    /**
     * @var integer $distritType
     *
     * @ManyToOne(targetEntity="models\Entity\Type")
     
    private $distritType;*/

    /**
     * @var integer $groupBlodType
     *
     * @ManyToOne(targetEntity="models\Entity\Type")
     
    private $groupBlodType;*/

    /**
     * @var integer $sectionType
     *
     * @ManyToOne(targetEntity="models\Entity\Type")
     
    private $sectionType;*/

    /**
     * @var integer $headquarterType
     *
     * @ManyToOne(targetEntity="models\Entity\Type")
     
    private $headquarterType;*/

    /**
     * @var string $status
     *
     * @Column(name="status", type="boolean", length=1, nullable=true)
     */
    private $status;

    /**
     * @var integer $roles
     *
     * @ManyToMany(targetEntity="models\Entity\Role", inversedBy="users");
     * @JoinTable(name="users__roles",
     *  joinColumns={@JoinColumn(name="user_id", referencedColumnName="id")},
     *  inverseJoinColumns={@JoinColumn(name="role_id", referencedColumnName="id")}
     * )
     */
    private $rolesAccess;

    public function __toString() {
        return $this->getName() . ' ' . $this->getLastname();
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
    
    public function __construct() {
        $this->rolesAccess = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fathers = new \Doctrine\Common\Collections\ArrayCollection();
        $this->students = new \Doctrine\Common\Collections\ArrayCollection();
        $this->teachers = new \Doctrine\Common\Collections\ArrayCollection();
        $this->createdAt = new \DateTime();
        $this->salt = md5(uniqid(null, true));
        $this->password = "default";
        $this->code = "default";
        $this->status = true;
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
     * @return User
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
     * Set lastName
     *
     * @param string $lastName
     * @return User
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    
        return $this;
    }

    /**
     * Get lastName
     *
     * @return string 
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set dateBorn
     *
     * @param \DateTime $dateBorn
     * @return User
     */
    public function setDateBorn($dateBorn)
    {
        $this->dateBorn = $dateBorn;
    
        return $this;
    }

    /**
     * Get dateBorn
     *
     * @return \DateTime 
     */
    public function getDateBorn()
    {
        return $this->dateBorn;
    }

    /**
     * Set phone
     *
     * @param string $phone
     * @return User
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
    
        return $this;
    }

    /**
     * Get phone
     *
     * @return string 
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set phoneMovil
     *
     * @param string $phoneMovil
     * @return User
     */
    public function setPhoneMovil($phoneMovil)
    {
        $this->phoneMovil = $phoneMovil;
    
        return $this;
    }

    /**
     * Get phoneMovil
     *
     * @return string 
     */
    public function getPhoneMovil()
    {
        return $this->phoneMovil;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;
    
        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set address
     *
     * @param string $address
     * @return User
     */
    public function setAddress($address)
    {
        $this->address = $address;
    
        return $this;
    }

    /**
     * Get address
     *
     * @return string 
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set code
     *
     * @param string $code
     * @return User
     */
    public function setCode($code)
    {
        $this->code = $code;
    
        return $this;
    }

    /**
     * Get code
     *
     * @return string 
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set password
     *
     * @param string $password
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;
    
        return $this;
    }

    /**
     * Get password
     *
     * @return string 
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set salt
     *
     * @param string $salt
     * @return User
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;
    
        return $this;
    }

    /**
     * Get salt
     *
     * @return string 
     */
    public function getSalt()
    {
        return $this->salt;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return User
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
     * @return User
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
     * @return User
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
     * Set status
     *
     * @param boolean $status
     * @return User
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
     * Add rolesAccess
     *
     * @param \models\Entity\Role $rolesAccess
     * @return User
     */
    public function addRolesAcces(\models\Entity\Role $rolesAccess)
    {
        $this->rolesAccess[] = $rolesAccess;
    
        return $this;
    }

    /**
     * Remove rolesAccess
     *
     * @param \models\Entity\Role $rolesAccess
     */
    public function removeRolesAcces(\models\Entity\Role $rolesAccess)
    {
        $this->rolesAccess->removeElement($rolesAccess);
    }

    /**
     * Get rolesAccess
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getRolesAccess()
    {
        return $this->rolesAccess;
    }
}