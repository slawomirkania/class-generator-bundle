<?php

namespace HelloWordPl\SimpleEntityGeneratorBundle\Tests\Lib\Dummies;

/**
 * User dummy class for StructureResolver tests
 */
class User implements \HelloWordPl\SimpleEntityGeneratorBundle\Tests\Lib\Dummies\UserInterface
{

    /**
     * 'full_name' property
     *
     * @\Symfony\Component\Validator\Constraints\NotBlank()
     * @\JMS\Serializer\Annotation\Type("string")
     * @\JMS\Serializer\Annotation\SerializedName("full_name")
     * @var string
     */
    private $fullName;

    /**
     * 'email' property
     *
     * @\Symfony\Component\Validator\Constraints\Email(message = "Invalid email!")
     * @\JMS\Serializer\Annotation\Type("string")
     * @\JMS\Serializer\Annotation\SerializedName("email")
     * @var string
     */
    private $email;

    /**
     * Wether user active
     *
     * @\Symfony\Component\Validator\Constraints\Type(type='boolean')
     * @\Symfony\Component\Validator\Constraints\IsTrue()
     * @\JMS\Serializer\Annotation\Type("boolean")
     * @\JMS\Serializer\Annotation\SerializedName("active")
     * @var boolean
     */
    private $active;

    /**
     * User new posts
     *
     * @\Symfony\Component\Validator\Constraints\NotNull()
     * @\Symfony\Component\Validator\Constraints\Valid()
     * @\JMS\Serializer\Annotation\Type("Doctrine\Common\Collections\ArrayCollection<AppBundle\Entity\Post>")
     * @\JMS\Serializer\Annotation\SerializedName("new_posts")
     * @var Doctrine\Common\Collections\ArrayCollection<AppBundle\Entity\Post>
     */
    private $newPosts;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->newPosts = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * For property "fullName"
     *
     * @param string $fullName
     * @return this
     */
    public function setFullName($fullName)
    {
        $this->fullName = $fullName;
        return $this;
    }

    /**
     * For property "fullName"
     *
     * @return string
     */
    public function getFullName()
    {
        return $this->fullName;
    }

    /**
     * For property "email"
     *
     * @param string $email
     * @return this
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    /**
     * For property "email"
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * For property "active"
     *
     * @return boolean
     */
    public function isActive()
    {
        return (bool) $this->active;
    }

    /**
     * For property "active"
     *
     * @param boolean $active
     * @return this
     */
    public function setActive($active)
    {
        $this->active = $active;
        return $this;
    }

    /**
     * For property "active"
     *
     * @return boolean
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * For property "newPosts"
     *
     * @param Doctrine\Common\Collections\ArrayCollection<AppBundle\Entity\Post> $newPosts
     * @return this
     */
    public function setNewPosts(\Doctrine\Common\Collections\ArrayCollection $newPosts)
    {
        $this->newPosts = $newPosts;
        return $this;
    }

    /**
     * For property "newPosts"
     *
     * @return Doctrine\Common\Collections\ArrayCollection<AppBundle\Entity\Post>
     */
    public function getNewPosts()
    {
        return $this->newPosts;
    }

}
