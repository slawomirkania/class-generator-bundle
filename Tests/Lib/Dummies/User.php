<?php

namespace SimpleEntityGeneratorBundle\Tests\Lib\Dummies;

/**
 * User dummy class for StructureResolver tests
 */
class User implements \Symfony\Component\Security\Core\User\UserInterface, \SimpleEntityGeneratorBundle\Tests\Lib\Dummies\CredentialsAwareInterface, \SimpleEntityGeneratorBundle\Tests\Lib\Dummies\UserInterface
{

    /**
     * 'full_name' property
     * @\Symfony\Component\Validator\Constraints\NotBlank()
     * @\JMS\Serializer\Annotation\Type("string")
     * @\JMS\Serializer\Annotation\SerializedName("full_name")
     * @var string
     */
    private $fullName;

    /**
     * 'email' property
     * @\Symfony\Component\Validator\Constraints\Email(message = "Invalid email!")
     * @\JMS\Serializer\Annotation\Type("string")
     * @\JMS\Serializer\Annotation\SerializedName("email")
     * @var string
     */
    private $email;

    /**
     * Wether user active
     * @\Symfony\Component\Validator\Constraints\Type(type='boolean')
     * @\Symfony\Component\Validator\Constraints\IsTrue()
     * @\JMS\Serializer\Annotation\Type("boolean")
     * @\JMS\Serializer\Annotation\SerializedName("active")
     * @var boolean
     */
    private $active;

    /**
     * User new posts
     * @\Symfony\Component\Validator\Constraints\NotNull()
     * @\Symfony\Component\Validator\Constraints\Valid()
     * @\JMS\Serializer\Annotation\Type("Doctrine\Common\Collections\ArrayCollection<AppBundle\Entity\Post>")
     * @\JMS\Serializer\Annotation\SerializedName("new_posts")
     * @var \Doctrine\Common\Collections\ArrayCollection
     */
    private $newPosts;

    /**
     * 'roles' property
     *
     *
     * @\JMS\Serializer\Annotation\Type("string")
     * @\JMS\Serializer\Annotation\SerializedName("roles")
     * @var string
     */
    private $roles;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->newPosts = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * For property "fullName"
     * @param string $fullName
     * @return $this
     */
    public function setFullName($fullName)
    {
        $this->fullName = $fullName;
        return $this;
    }

    /**
     * For property "fullName"
     * @return string
     */
    public function getFullName()
    {
        return $this->fullName;
    }

    /**
     * For property "email"
     * @param string $email
     * @return $this
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    /**
     * For property "email"
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * For property "active"
     * @return boolean
     */
    public function isActive()
    {
        return (bool) $this->active;
    }

    /**
     * For property "active"
     * @param boolean $active
     * @return $this
     */
    public function setActive($active)
    {
        $this->active = $active;
        return $this;
    }

    /**
     * For property "active"
     * @return boolean
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * For property "newPosts"
     * @param \Doctrine\Common\Collections\ArrayCollection $newPosts
     * @return $this
     */
    public function setNewPosts(\Doctrine\Common\Collections\ArrayCollection $newPosts)
    {
        $this->newPosts = $newPosts;
        return $this;
    }

    /**
     * For property "newPosts"
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getNewPosts()
    {
        return $this->newPosts;
    }

    /**
     * For property "roles"
     * @param string $roles
     * @return $this
     */
    public function setRoles($roles)
    {
        $this->roles = $roles;
        return $this;
    }

    /**
     * For property "roles"
     * @return string
     */
    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * @inheritdoc
     */
    public function getCredentials()
    {
        // TODO: Implement getCredentials() method.
    }

    /**
     * @inheritdoc
     */
    public function getPassword()
    {
        // TODO: Implement getPassword() method.
    }

    /**
     * @inheritdoc
     */
    public function getSalt()
    {
        // TODO: Implement getSalt() method.
    }

    /**
     * @inheritdoc
     */
    public function getUsername()
    {
        // TODO: Implement getUsername() method.
    }

    /**
     * @inheritdoc
     */
    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }

}
