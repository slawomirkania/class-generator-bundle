<?php

namespace SimpleEntityGeneratorBundle\Tests\Lib\Dummies;

/**
 * User dummy interface for StructureResolver tests
 */
interface UserInterface
{

    /**
     * For property "fullName"
     * @param string $fullName
     * @return $this
     */
    public function setFullName($fullName);

    /**
     * For property "fullName"
     * @return string
     */
    public function getFullName();

    /**
     * For property "email"
     * @param string $email
     * @return $this
     */
    public function setEmail($email);

    /**
     * For property "email"
     * @return string
     */
    public function getEmail();

    /**
     * For property "active"
     * @return boolean
     */
    public function isActive();

    /**
     * For property "active"
     * @param boolean $active
     * @return $this
     */
    public function setActive($active);

    /**
     * For property "active"
     * @return boolean
     */
    public function getActive();

    /**
     * For property "newPosts"
     * @param \Doctrine\Common\Collections\ArrayCollection $newPosts
     * @return $this
     */
    public function setNewPosts(\Doctrine\Common\Collections\ArrayCollection $newPosts);

    /**
     * For property "newPosts"
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getNewPosts();

    /**
     * For property "roles"
     * @param string $roles
     * @return $this
     */
    public function setRoles($roles);

    /**
     * For property "roles"
     * @return string
     */
    public function getRoles();

}
