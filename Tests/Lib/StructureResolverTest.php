<?php

namespace SimpleEntityGeneratorBundle\Tests\Lib;

use SimpleEntityGeneratorBundle\Lib\FilesManager;
use SimpleEntityGeneratorBundle\Lib\Interfaces\DumpableInterface;
use SimpleEntityGeneratorBundle\Lib\Items\ClassManager;
use SimpleEntityGeneratorBundle\Lib\StructureResolver;
use SimpleEntityGeneratorBundle\Lib\Tools;
use ReflectionClass;
use SimpleEntityGeneratorBundle\Tests\Lib\Dummies\UserTestDummy;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Exception;

/**
 * StructureResolver Test
 *
 * @author Sławomir Kania <slawomir.kania1@gmail.com>
 */
class StructureResolverTest extends KernelTestCase
{

    /**
     * @var \Symfony\Component\DependencyInjection\ContainerInterface
     */
    protected $container;

    public function setUp()
    {
        self::bootKernel();
        $this->container = self::$kernel->getContainer();
    }

    /**
     * @var string
     */
    protected $classContentBeforeUpdate = <<<EOT
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
    private \$fullName;

    /**
     * 'email' property
     * @\Symfony\Component\Validator\Constraints\Email(message = "Invalid email!")
     * @\JMS\Serializer\Annotation\Type("string")
     * @\JMS\Serializer\Annotation\SerializedName("email")
     * @var string
     */
    private \$email;

    /**
     * Wether user active
     * @\Symfony\Component\Validator\Constraints\Type(type='boolean')
     * @\Symfony\Component\Validator\Constraints\IsTrue()
     * @\JMS\Serializer\Annotation\Type("boolean")
     * @\JMS\Serializer\Annotation\SerializedName("active")
     * @var boolean
     */
    private \$active;

    /**
     * User new posts
     * @\Symfony\Component\Validator\Constraints\NotNull()
     * @\Symfony\Component\Validator\Constraints\Valid()
     * @\JMS\Serializer\Annotation\Type("Doctrine\Common\Collections\ArrayCollection<AppBundle\Entity\Post>")
     * @\JMS\Serializer\Annotation\SerializedName("new_posts")
     * @var \Doctrine\Common\Collections\ArrayCollection
     */
    private \$newPosts;

    /**
     * 'roles' property
     *
     *
     * @\JMS\Serializer\Annotation\Type("string")
     * @\JMS\Serializer\Annotation\SerializedName("roles")
     * @var string
     */
    private \$roles;

    /**
     * Constructor.
     */
    public function __construct()
    {
        \$this->newPosts = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * For property "fullName"
     * @param string \$fullName
     * @return \$this
     */
    public function setFullName(\$fullName)
    {
        \$this->fullName = \$fullName;
        return \$this;
    }

    /**
     * For property "fullName"
     * @return string
     */
    public function getFullName()
    {
        return \$this->fullName;
    }

    /**
     * For property "email"
     * @param string \$email
     * @return \$this
     */
    public function setEmail(\$email)
    {
        \$this->email = \$email;
        return \$this;
    }

    /**
     * For property "email"
     * @return string
     */
    public function getEmail()
    {
        return \$this->email;
    }

    /**
     * For property "active"
     * @return boolean
     */
    public function isActive()
    {
        return (bool) \$this->active;
    }

    /**
     * For property "active"
     * @param boolean \$active
     * @return \$this
     */
    public function setActive(\$active)
    {
        \$this->active = \$active;
        return \$this;
    }

    /**
     * For property "active"
     * @return boolean
     */
    public function getActive()
    {
        return \$this->active;
    }

    /**
     * For property "newPosts"
     * @param \Doctrine\Common\Collections\ArrayCollection \$newPosts
     * @return \$this
     */
    public function setNewPosts(\Doctrine\Common\Collections\ArrayCollection \$newPosts)
    {
        \$this->newPosts = \$newPosts;
        return \$this;
    }

    /**
     * For property "newPosts"
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getNewPosts()
    {
        return \$this->newPosts;
    }

    /**
     * For property "roles"
     * @param string \$roles
     * @return \$this
     */
    public function setRoles(\$roles)
    {
        \$this->roles = \$roles;
        return \$this;
    }

    /**
     * For property "roles"
     * @return string
     */
    public function getRoles()
    {
        return \$this->roles;
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

EOT;

    /**
     * @var string
     */
    protected $classContentAfterUpdate = <<<EOT
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
    private \$fullName;

    /**
     * 'email' property
     * @\Symfony\Component\Validator\Constraints\Email(message = "Invalid email!")
     * @\JMS\Serializer\Annotation\Type("string")
     * @\JMS\Serializer\Annotation\SerializedName("email")
     * @var string
     */
    private \$email;

    /**
     * Wether user active
     * @\Symfony\Component\Validator\Constraints\Type(type='boolean')
     * @\Symfony\Component\Validator\Constraints\IsTrue()
     * @\JMS\Serializer\Annotation\Type("boolean")
     * @\JMS\Serializer\Annotation\SerializedName("active")
     * @var boolean
     */
    private \$active;

    /**
     * User new posts
     * @\Symfony\Component\Validator\Constraints\NotNull()
     * @\Symfony\Component\Validator\Constraints\Valid()
     * @\JMS\Serializer\Annotation\Type("Doctrine\Common\Collections\ArrayCollection<AppBundle\Entity\Post>")
     * @\JMS\Serializer\Annotation\SerializedName("new_posts")
     * @var \Doctrine\Common\Collections\ArrayCollection
     */
    private \$newPosts;

    /**
     * 'roles' property
     *
     *
     * @\JMS\Serializer\Annotation\Type("string")
     * @\JMS\Serializer\Annotation\SerializedName("roles")
     * @var string
     */
    private \$roles;

    /**
     * new collection property
     * 
     * @\Symfony\Component\Validator\Constraints\Valid()
     * @\JMS\Serializer\Annotation\Type("Doctrine\Common\Collections\ArrayCollection")
     * @\JMS\Serializer\Annotation\SerializedName("test_collection")
     * @var \Doctrine\Common\Collections\ArrayCollection
     */
    private \$testCollection;

    /**
     * new boolean property
     * 
     * @\Symfony\Component\Validator\Constraints\IsTrue()
     * @\JMS\Serializer\Annotation\Type("boolean")
     * @\JMS\Serializer\Annotation\SerializedName("test_boolean")
     * @var boolean
     */
    private \$testBoolean;

    /**
     * Constructor.
     */
    public function __construct()
    {
        \$this->newPosts = new \Doctrine\Common\Collections\ArrayCollection();
        \$this->testCollection = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * For property "fullName"
     * @param string \$fullName
     * @return \$this
     */
    public function setFullName(\$fullName)
    {
        \$this->fullName = \$fullName;
        return \$this;
    }

    /**
     * For property "fullName"
     * @return string
     */
    public function getFullName()
    {
        return \$this->fullName;
    }

    /**
     * For property "email"
     * @param string \$email
     * @return \$this
     */
    public function setEmail(\$email)
    {
        \$this->email = \$email;
        return \$this;
    }

    /**
     * For property "email"
     * @return string
     */
    public function getEmail()
    {
        return \$this->email;
    }

    /**
     * For property "active"
     * @return boolean
     */
    public function isActive()
    {
        return (bool) \$this->active;
    }

    /**
     * For property "active"
     * @param boolean \$active
     * @return \$this
     */
    public function setActive(\$active)
    {
        \$this->active = \$active;
        return \$this;
    }

    /**
     * For property "active"
     * @return boolean
     */
    public function getActive()
    {
        return \$this->active;
    }

    /**
     * For property "newPosts"
     * @param \Doctrine\Common\Collections\ArrayCollection \$newPosts
     * @return \$this
     */
    public function setNewPosts(\Doctrine\Common\Collections\ArrayCollection \$newPosts)
    {
        \$this->newPosts = \$newPosts;
        return \$this;
    }

    /**
     * For property "newPosts"
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getNewPosts()
    {
        return \$this->newPosts;
    }

    /**
     * For property "roles"
     * @param string \$roles
     * @return \$this
     */
    public function setRoles(\$roles)
    {
        \$this->roles = \$roles;
        return \$this;
    }

    /**
     * For property "roles"
     * @return string
     */
    public function getRoles()
    {
        return \$this->roles;
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

    /**
     * For property "testCollection"
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getTestCollection()
    {
        return \$this->testCollection;
    }

    /**
     * For property "testCollection"
     * @param \Doctrine\Common\Collections\ArrayCollection \$testCollection
     * @return \$this
     */
    public function setTestCollection(\Doctrine\Common\Collections\ArrayCollection \$testCollection)
    {
        \$this->testCollection = \$testCollection;
        return \$this;
    }

    /**
     * For property "testBoolean"
     * @return boolean
     */
    public function getTestBoolean()
    {
        return \$this->testBoolean;
    }

    /**
     * For property "testBoolean"
     * @param boolean \$testBoolean
     * @return \$this
     */
    public function setTestBoolean(\$testBoolean)
    {
        \$this->testBoolean = \$testBoolean;
        return \$this;
    }

    /**
     * For property "testBoolean"
     * @return boolean
     */
    public function isTestBoolean()
    {
        return (bool) \$this->testBoolean;
    }

}

EOT;

    /**
     * @var string
     */
    protected $interfaceContentBeforeUpdate = <<<EOT
<?php

namespace SimpleEntityGeneratorBundle\Tests\Lib\Dummies;

/**
 * User dummy interface for StructureResolver tests
 */
interface UserInterface
{

    /**
     * For property "fullName"
     * @param string \$fullName
     * @return \$this
     */
    public function setFullName(\$fullName);

    /**
     * For property "fullName"
     * @return string
     */
    public function getFullName();

    /**
     * For property "email"
     * @param string \$email
     * @return \$this
     */
    public function setEmail(\$email);

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
     * @param boolean \$active
     * @return \$this
     */
    public function setActive(\$active);

    /**
     * For property "active"
     * @return boolean
     */
    public function getActive();

    /**
     * For property "newPosts"
     * @param \Doctrine\Common\Collections\ArrayCollection \$newPosts
     * @return \$this
     */
    public function setNewPosts(\Doctrine\Common\Collections\ArrayCollection \$newPosts);

    /**
     * For property "newPosts"
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getNewPosts();

    /**
     * For property "roles"
     * @param string \$roles
     * @return \$this
     */
    public function setRoles(\$roles);

    /**
     * For property "roles"
     * @return string
     */
    public function getRoles();

}

EOT;
    protected $interfaceContentAfterUpdate = <<<EOT
<?php

namespace SimpleEntityGeneratorBundle\Tests\Lib\Dummies;

/**
 * User dummy interface for StructureResolver tests
 */
interface UserInterface
{

    /**
     * For property "fullName"
     * @param string \$fullName
     * @return \$this
     */
    public function setFullName(\$fullName);

    /**
     * For property "fullName"
     * @return string
     */
    public function getFullName();

    /**
     * For property "email"
     * @param string \$email
     * @return \$this
     */
    public function setEmail(\$email);

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
     * @param boolean \$active
     * @return \$this
     */
    public function setActive(\$active);

    /**
     * For property "active"
     * @return boolean
     */
    public function getActive();

    /**
     * For property "newPosts"
     * @param \Doctrine\Common\Collections\ArrayCollection \$newPosts
     * @return \$this
     */
    public function setNewPosts(\Doctrine\Common\Collections\ArrayCollection \$newPosts);

    /**
     * For property "newPosts"
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getNewPosts();

    /**
     * For property "roles"
     * @param string \$roles
     * @return \$this
     */
    public function setRoles(\$roles);

    /**
     * For property "roles"
     * @return string
     */
    public function getRoles();

    /**
     * For property "testCollection"
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getTestCollection();

    /**
     * For property "testCollection"
     * @param \Doctrine\Common\Collections\ArrayCollection \$testCollection
     * @return \$this
     */
    public function setTestCollection(\Doctrine\Common\Collections\ArrayCollection \$testCollection);

    /**
     * For property "testBoolean"
     * @return boolean
     */
    public function getTestBoolean();

    /**
     * For property "testBoolean"
     * @param boolean \$testBoolean
     * @return \$this
     */
    public function setTestBoolean(\$testBoolean);

    /**
     * For property "testBoolean"
     * @return boolean
     */
    public function isTestBoolean();

}

EOT;

    /**
     * @var string
     */
    protected $testClassContentBeforeUpdate = <<<EOT
<?php

namespace SimpleEntityGeneratorBundle\Tests\Lib\Dummies;

/**
 * User dummy test class for StructureResolver tests
 */
class UserTestDummy extends \PHPUnit_Framework_TestCase
{

    /**
     * Entity to test
     * @var \SimpleEntityGeneratorBundle\Tests\Lib\Dummies\UserInterface
     */
    private \$object = null;

    public function setUp()
    {
        \$this->object = new \SimpleEntityGeneratorBundle\Tests\Lib\Dummies\User();
    }

    public function testConstructor()
    {
        \$this->assertNotNull(\$this->object);
        \$this->assertInstanceof('\SimpleEntityGeneratorBundle\Tests\Lib\Dummies\UserInterface', \$this->object);
        \$this->assertInstanceof('\SimpleEntityGeneratorBundle\Tests\Lib\Dummies\User', \$this->object);
    }

    /**
     * @covers \SimpleEntityGeneratorBundle\Tests\Lib\Dummies\User::setFullName
     */
    public function testSetFullName()
    {
        \$this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers \SimpleEntityGeneratorBundle\Tests\Lib\Dummies\User::getFullName
     */
    public function testGetFullName()
    {
        \$this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers \SimpleEntityGeneratorBundle\Tests\Lib\Dummies\User::setEmail
     */
    public function testSetEmail()
    {
        \$this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers \SimpleEntityGeneratorBundle\Tests\Lib\Dummies\User::getEmail
     */
    public function testGetEmail()
    {
        \$this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers \SimpleEntityGeneratorBundle\Tests\Lib\Dummies\User::isActive
     */
    public function testIsActive()
    {
        \$this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers \SimpleEntityGeneratorBundle\Tests\Lib\Dummies\User::setActive
     */
    public function testSetActive()
    {
        \$this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers \SimpleEntityGeneratorBundle\Tests\Lib\Dummies\User::getActive
     */
    public function testGetActive()
    {
        \$this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers \SimpleEntityGeneratorBundle\Tests\Lib\Dummies\User::setNewPosts
     */
    public function testSetNewPosts()
    {
        \$this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers \SimpleEntityGeneratorBundle\Tests\Lib\Dummies\User::getNewPosts
     */
    public function testGetNewPosts()
    {
        \$this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers \AppBundle\Entity\User::setRoles
     */
    public function testSetRoles()
    {
        \$this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers \AppBundle\Entity\User::getRoles
     */
    public function testGetRoles()
    {
        \$this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

}

EOT;

    /**
     * @var string
     */
    protected $testClassContentAfterUpdate = <<<EOT
<?php

namespace SimpleEntityGeneratorBundle\Tests\Lib\Dummies;

/**
 * User dummy test class for StructureResolver tests
 */
class UserTestDummy extends \PHPUnit_Framework_TestCase
{

    /**
     * Entity to test
     * @var \SimpleEntityGeneratorBundle\Tests\Lib\Dummies\UserInterface
     */
    private \$object = null;

    public function setUp()
    {
        \$this->object = new \SimpleEntityGeneratorBundle\Tests\Lib\Dummies\User();
    }

    public function testConstructor()
    {
        \$this->assertNotNull(\$this->object);
        \$this->assertInstanceof('\SimpleEntityGeneratorBundle\Tests\Lib\Dummies\UserInterface', \$this->object);
        \$this->assertInstanceof('\SimpleEntityGeneratorBundle\Tests\Lib\Dummies\User', \$this->object);
    }

    /**
     * @covers \SimpleEntityGeneratorBundle\Tests\Lib\Dummies\User::setFullName
     */
    public function testSetFullName()
    {
        \$this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers \SimpleEntityGeneratorBundle\Tests\Lib\Dummies\User::getFullName
     */
    public function testGetFullName()
    {
        \$this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers \SimpleEntityGeneratorBundle\Tests\Lib\Dummies\User::setEmail
     */
    public function testSetEmail()
    {
        \$this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers \SimpleEntityGeneratorBundle\Tests\Lib\Dummies\User::getEmail
     */
    public function testGetEmail()
    {
        \$this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers \SimpleEntityGeneratorBundle\Tests\Lib\Dummies\User::isActive
     */
    public function testIsActive()
    {
        \$this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers \SimpleEntityGeneratorBundle\Tests\Lib\Dummies\User::setActive
     */
    public function testSetActive()
    {
        \$this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers \SimpleEntityGeneratorBundle\Tests\Lib\Dummies\User::getActive
     */
    public function testGetActive()
    {
        \$this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers \SimpleEntityGeneratorBundle\Tests\Lib\Dummies\User::setNewPosts
     */
    public function testSetNewPosts()
    {
        \$this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers \SimpleEntityGeneratorBundle\Tests\Lib\Dummies\User::getNewPosts
     */
    public function testGetNewPosts()
    {
        \$this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers \AppBundle\Entity\User::setRoles
     */
    public function testSetRoles()
    {
        \$this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers \AppBundle\Entity\User::getRoles
     */
    public function testGetRoles()
    {
        \$this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers \SimpleEntityGeneratorBundle\Tests\Lib\Dummies\User::getTestCollection
     */
    public function testGetTestCollection()
    {
        \$this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers \SimpleEntityGeneratorBundle\Tests\Lib\Dummies\User::setTestCollection
     */
    public function testSetTestCollection()
    {
        \$this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers \SimpleEntityGeneratorBundle\Tests\Lib\Dummies\User::getTestBoolean
     */
    public function testGetTestBoolean()
    {
        \$this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers \SimpleEntityGeneratorBundle\Tests\Lib\Dummies\User::setTestBoolean
     */
    public function testSetTestBoolean()
    {
        \$this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers \SimpleEntityGeneratorBundle\Tests\Lib\Dummies\User::isTestBoolean
     */
    public function testIsTestBoolean()
    {
        \$this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

}

EOT;

    public function testGetUpdatedItemSourceContentForClassManager()
    {
        $classManager = $this->prepareClassManager();
        $existingClassReflection = $this->getReflectionClass($classManager);
        $existingFileContent = $this->getContentFile($existingClassReflection->getFileName());

        $this->assertEquals($this->classContentBeforeUpdate, $existingFileContent);
        $updatedContent = $this->getStructureResolver()->getUpdatedItemSourceContent($existingFileContent, $classManager, $existingClassReflection);
        $this->assertEquals($this->classContentAfterUpdate, $updatedContent);
    }

    public function testGetUpdatedItemSourceContentForInterfaceManager()
    {
        $classManager = $this->prepareClassManager();
        $interfaceManager = $classManager->getInterface();
        $existingClassReflection = $this->getReflectionClass($interfaceManager);
        $existingFileContent = $this->getContentFile($existingClassReflection->getFileName());

        $this->assertEquals($this->interfaceContentBeforeUpdate, $existingFileContent);
        $updatedContent = $this->getStructureResolver()->getUpdatedItemSourceContent($existingFileContent, $interfaceManager, $existingClassReflection);
        $this->assertEquals($this->interfaceContentAfterUpdate, $updatedContent);
    }

    public function testGetUpdatedItemSourceContentForTestClassManager()
    {
        $classManager = $this->prepareClassManager();
        $testClassManager = $classManager->getTestClass();

        $existingClassReflection = $this->getReflectionClass(UserTestDummy::class);
        $existingFileContent = $this->getContentFile($existingClassReflection->getFileName());

        $this->assertEquals($this->testClassContentBeforeUpdate, $existingFileContent);
        $updatedContent = $this->getStructureResolver()->getUpdatedItemSourceContent($existingFileContent, $testClassManager, $existingClassReflection);
        $this->assertEquals($this->testClassContentAfterUpdate, $updatedContent);
    }

    /**
     * Prepare correct ClassManager
     * @return ClassManager
     * @internal param ArrayCollection $newProperties
     */
    protected function prepareClassManager()
    {
        $pureClassManager = Helper::prepareBasicClassManager("\SimpleEntityGeneratorBundle\Tests\Lib\Dummies\User");
        $properties = $pureClassManager->getProperties();

        $properties->add(Helper::prepareProperty('test_boolean', "boolean", "new boolean property", ["IsTrue()"]));
        $properties->add(Helper::prepareProperty('test_collection', "Doctrine\Common\Collections\ArrayCollection", "new collection property", ["Valid()"]));

        $classManager = $this->container->get('seg.structure_generator')->prepareClassManager($pureClassManager);
        $errors = $this->container->get('validator')->validate($classManager);
        $this->assertFalse($errors->count() > 0);
        return $classManager;
    }

    /**
     * @param mixed $itemOrDirectory
     * @return string
     * @throws Exception
     */
    protected function getContentFile($itemOrDirectory)
    {
        $filesManager = $this->getFilesManager();
        if ($itemOrDirectory instanceof DumpableInterface) {
            return $filesManager->getContentFromItemFile($itemOrDirectory);
        }

        if (false == file_exists($itemOrDirectory)) {
            throw new Exception(sprintf("File does not exist: %s", $itemOrDirectory));
        }

        return file_get_contents($itemOrDirectory);
    }

    /**
     * @param mixed $itemOrNamespace
     * @return ReflectionClass
     * @throws Exception
     */
    protected function getReflectionClass($itemOrNamespace)
    {
        $filesManager = $this->getFilesManager();
        if ($itemOrNamespace instanceof DumpableInterface) {
            return $filesManager->getReflectionClassForItem($itemOrNamespace);
        }

        if (false == class_exists($itemOrNamespace)) {
            throw new Exception(sprintf("Class does not exist: %s", $itemOrNamespace));
        }

        return new ReflectionClass($itemOrNamespace);
    }

    /**
     * @return FilesManager
     */
    protected function getFilesManager()
    {
        return $this->container->get('seg.files_manager');
    }

    /**
     * @return StructureResolver
     */
    protected function getStructureResolver()
    {
        return $this->container->get('seg.structure_resolver');
    }

    /**
     * @return \Symfony\Component\HttpKernel\KernelInterface
     */
    protected function getKernel()
    {
        return $this->container->get('kernel');
    }
}
