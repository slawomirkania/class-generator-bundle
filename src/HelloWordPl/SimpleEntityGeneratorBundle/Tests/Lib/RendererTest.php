<?php

namespace HelloWordPl\SimpleEntityGeneratorBundle\Tests\Lib;

use Doctrine\Common\Collections\ArrayCollection;
use HelloWordPl\SimpleEntityGeneratorBundle\Lib\Items\ClassConstructorManager;
use HelloWordPl\SimpleEntityGeneratorBundle\Lib\Items\ClassManager;
use HelloWordPl\SimpleEntityGeneratorBundle\Lib\Items\InitPropertyManager;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use HelloWordPl\SimpleEntityGeneratorBundle\Lib\ClassConfig;

/**
 * Renderer Test
 *
 * @author Sławomir Kania <slawomir.kania1@gmail.com>
 */
class RendererTest extends KernelTestCase
{

    /**
     * @var string
     */
    protected $postClassWithUpdatedConstructor = <<<EOT
<?php

namespace AppBundle\Entity;

/**
 * 
 * 
 */
class Post implements \AppBundle\Entity\PostInterface
{
    
    /**
     * Post content
     * 
     * @\Symfony\Component\Validator\Constraints\NotBlank()
     * @\JMS\Serializer\Annotation\Type("string")
     * @\JMS\Serializer\Annotation\SerializedName("content")
     * @var string
     */
    private \$content;

    /**
     * 'created_at' property
     * 
     * 
     * @\JMS\Serializer\Annotation\Type("DateTime")
     * @\JMS\Serializer\Annotation\SerializedName("created_at")
     * @var DateTime
     */
    private \$createdAt;

    /**
     * 'updated_at' property
     * 
     * 
     * @\JMS\Serializer\Annotation\Type("DateTime")
     * @\JMS\Serializer\Annotation\SerializedName("updated_at")
     * @var DateTime
     */
    private \$updatedAt;

    
    /**
     * Constructor.
     */
    public function __construct()
    {
        \$this->collection = new \Doctrine\Common\Collections\ArrayCollection();
        \$this->collection2 = new \Doctrine\Common\Collections\ArrayCollection();
        
    }

    
    /**
     * For property "content"
     * @param string \$content
     * @return this
     */
    public function setContent(\$content)
    {
        \$this->content = \$content;
        return \$this;
    }

    /**
     * For property "content"
     * @return string
     */
    public function getContent()
    {
        return \$this->content;
    }

    /**
     * For property "createdAt"
     * @param DateTime \$createdAt
     * @return this
     */
    public function setCreatedAt(\DateTime \$createdAt)
    {
        \$this->createdAt = \$createdAt;
        return \$this;
    }

    /**
     * For property "createdAt"
     * @return DateTime
     */
    public function getCreatedAt()
    {
        return \$this->createdAt;
    }

    /**
     * For property "updatedAt"
     * @param DateTime \$updatedAt
     * @return this
     */
    public function setUpdatedAt(\DateTime \$updatedAt)
    {
        \$this->updatedAt = \$updatedAt;
        return \$this;
    }

    /**
     * For property "updatedAt"
     * @return DateTime
     */
    public function getUpdatedAt()
    {
        return \$this->updatedAt;
    }

}

EOT;

    /**
     * @var string
     */
    protected $postClassWithNewPropertyExpected = <<<EOT
<?php

namespace AppBundle\Entity;

/**
 * 
 * 
 */
class Post implements \AppBundle\Entity\PostInterface
{
    
    /**
     * Post content
     * 
     * @\Symfony\Component\Validator\Constraints\NotBlank()
     * @\JMS\Serializer\Annotation\Type("string")
     * @\JMS\Serializer\Annotation\SerializedName("content")
     * @var string
     */
    private \$content;

    /**
     * 'created_at' property
     * 
     * 
     * @\JMS\Serializer\Annotation\Type("DateTime")
     * @\JMS\Serializer\Annotation\SerializedName("created_at")
     * @var DateTime
     */
    private \$createdAt;

    /**
     * 'updated_at' property
     * 
     * 
     * @\JMS\Serializer\Annotation\Type("DateTime")
     * @\JMS\Serializer\Annotation\SerializedName("updated_at")
     * @var DateTime
     */
    private \$updatedAt;

    /**
     * is post active
     * 
     * @\Symfony\Component\Validator\Constraints\IsTrue()
     * @\JMS\Serializer\Annotation\Type("boolean")
     * @\JMS\Serializer\Annotation\SerializedName("active")
     * @var boolean
     */
    private \$active;

    
    /**
     * Constructor.
     */
    public function __construct()
    {
        
    }

    
    /**
     * For property "content"
     * @param string \$content
     * @return this
     */
    public function setContent(\$content)
    {
        \$this->content = \$content;
        return \$this;
    }

    /**
     * For property "content"
     * @return string
     */
    public function getContent()
    {
        return \$this->content;
    }

    /**
     * For property "createdAt"
     * @param DateTime \$createdAt
     * @return this
     */
    public function setCreatedAt(\DateTime \$createdAt)
    {
        \$this->createdAt = \$createdAt;
        return \$this;
    }

    /**
     * For property "createdAt"
     * @return DateTime
     */
    public function getCreatedAt()
    {
        return \$this->createdAt;
    }

    /**
     * For property "updatedAt"
     * @param DateTime \$updatedAt
     * @return this
     */
    public function setUpdatedAt(\DateTime \$updatedAt)
    {
        \$this->updatedAt = \$updatedAt;
        return \$this;
    }

    /**
     * For property "updatedAt"
     * @return DateTime
     */
    public function getUpdatedAt()
    {
        return \$this->updatedAt;
    }

}

EOT;

    /**
     * @var string
     */
    protected $postClassExpected = <<<EOT
<?php

namespace AppBundle\Entity;

/**
 * 
 * 
 */
class Post implements \AppBundle\Entity\PostInterface
{
    
    /**
     * Post content
     * 
     * @\Symfony\Component\Validator\Constraints\NotBlank()
     * @\JMS\Serializer\Annotation\Type("string")
     * @\JMS\Serializer\Annotation\SerializedName("content")
     * @var string
     */
    private \$content;

    /**
     * 'created_at' property
     * 
     * 
     * @\JMS\Serializer\Annotation\Type("DateTime")
     * @\JMS\Serializer\Annotation\SerializedName("created_at")
     * @var DateTime
     */
    private \$createdAt;

    /**
     * 'updated_at' property
     * 
     * 
     * @\JMS\Serializer\Annotation\Type("DateTime")
     * @\JMS\Serializer\Annotation\SerializedName("updated_at")
     * @var DateTime
     */
    private \$updatedAt;

    
    /**
     * Constructor.
     */
    public function __construct()
    {
        
    }

    
    /**
     * For property "content"
     * @param string \$content
     * @return this
     */
    public function setContent(\$content)
    {
        \$this->content = \$content;
        return \$this;
    }

    /**
     * For property "content"
     * @return string
     */
    public function getContent()
    {
        return \$this->content;
    }

    /**
     * For property "createdAt"
     * @param DateTime \$createdAt
     * @return this
     */
    public function setCreatedAt(\DateTime \$createdAt)
    {
        \$this->createdAt = \$createdAt;
        return \$this;
    }

    /**
     * For property "createdAt"
     * @return DateTime
     */
    public function getCreatedAt()
    {
        return \$this->createdAt;
    }

    /**
     * For property "updatedAt"
     * @param DateTime \$updatedAt
     * @return this
     */
    public function setUpdatedAt(\DateTime \$updatedAt)
    {
        \$this->updatedAt = \$updatedAt;
        return \$this;
    }

    /**
     * For property "updatedAt"
     * @return DateTime
     */
    public function getUpdatedAt()
    {
        return \$this->updatedAt;
    }

}

EOT;

    /**
     * @var string
     */
    protected $userClassExpected = <<<EOT
<?php

namespace AppBundle\Entity;

/**
 * New User entity
 * lorem ipsum
 * second row
 * @\Doctrine\Common\Annotations\Entity()
 */
class User extends \AppBundle\Entity\Base implements \AppBundle\Entity\UserInterface
{
    
    /**
     * Username for login
     * 
     * @\Symfony\Component\Validator\Constraints\NotBlank(message = "Login can not be empty")
     * @\Symfony\Component\Validator\Constraints\NotNull(message = "Login can not be null")
     * @\JMS\Serializer\Annotation\Type("string")
     * @\JMS\Serializer\Annotation\SerializedName("username")
     * @var string
     */
    private \$username;

    /**
     * User email
     * @\Doctrine\Common\Annotations\Column()
     * lorem ipsum
     * third row
     * @\Symfony\Component\Validator\Constraints\NotBlank()
     * @\Symfony\Component\Validator\Constraints\Email(message = "Invalid email")
     * @\JMS\Serializer\Annotation\Type("string")
     * @\JMS\Serializer\Annotation\SerializedName("email")
     * @var string
     */
    private \$email;

    /**
     * Wether user is active or not
     * 
     * @\Symfony\Component\Validator\Constraints\IsTrue()
     * @\JMS\Serializer\Annotation\Type("boolean")
     * @\JMS\Serializer\Annotation\SerializedName("active")
     * @var boolean
     */
    private \$active;

    /**
     * User posts
     * 
     * 
     * @\JMS\Serializer\Annotation\Type("Doctrine\Common\Collections\ArrayCollection<AppBundle\Entity\Post>")
     * @\JMS\Serializer\Annotation\SerializedName("posts")
     * @var Doctrine\Common\Collections\ArrayCollection<AppBundle\Entity\Post>
     */
    private \$posts;

    /**
     * 'created_at' property
     * 
     * 
     * @\JMS\Serializer\Annotation\Type("DateTime")
     * @\JMS\Serializer\Annotation\SerializedName("created_at")
     * @var DateTime
     */
    private \$createdAt;

    /**
     * 'updated_at' property
     * 
     * 
     * @\JMS\Serializer\Annotation\Type("DateTime")
     * @\JMS\Serializer\Annotation\SerializedName("updated_at")
     * @var DateTime
     */
    private \$updatedAt;

    /**
     * 'last_post' property
     * 
     * 
     * @\JMS\Serializer\Annotation\Type("AppBundle\Entity\Post")
     * @\JMS\Serializer\Annotation\SerializedName("lastPost")
     * @var AppBundle\Entity\Post
     */
    private \$lastPost;

    
    /**
     * Constructor.
     */
    public function __construct()
    {
        \$this->posts = new \Doctrine\Common\Collections\ArrayCollection();
    }

    
    /**
     * For property "username"
     * @param string \$username
     * @return this
     */
    public function setUsername(\$username)
    {
        \$this->username = \$username;
        return \$this;
    }

    /**
     * For property "username"
     * @return string
     */
    public function getUsername()
    {
        return \$this->username;
    }

    /**
     * For property "email"
     * @param string \$email
     * @return this
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
     * @return this
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
     * For property "posts"
     * @param Doctrine\Common\Collections\ArrayCollection<AppBundle\Entity\Post> \$posts
     * @return this
     */
    public function setPosts(\Doctrine\Common\Collections\ArrayCollection \$posts)
    {
        \$this->posts = \$posts;
        return \$this;
    }

    /**
     * For property "posts"
     * @return Doctrine\Common\Collections\ArrayCollection<AppBundle\Entity\Post>
     */
    public function getPosts()
    {
        return \$this->posts;
    }

    /**
     * For property "createdAt"
     * @param DateTime \$createdAt
     * @return this
     */
    public function setCreatedAt(\DateTime \$createdAt)
    {
        \$this->createdAt = \$createdAt;
        return \$this;
    }

    /**
     * For property "createdAt"
     * @return DateTime
     */
    public function getCreatedAt()
    {
        return \$this->createdAt;
    }

    /**
     * For property "updatedAt"
     * @param DateTime \$updatedAt
     * @return this
     */
    public function setUpdatedAt(\DateTime \$updatedAt)
    {
        \$this->updatedAt = \$updatedAt;
        return \$this;
    }

    /**
     * For property "updatedAt"
     * @return DateTime
     */
    public function getUpdatedAt()
    {
        return \$this->updatedAt;
    }

    /**
     * For property "lastPost"
     * @param AppBundle\Entity\Post \$lastPost
     * @return this
     */
    public function setLastPost(\AppBundle\Entity\Post \$lastPost = null)
    {
        \$this->lastPost = \$lastPost;
        return \$this;
    }

    /**
     * For property "lastPost"
     * @return AppBundle\Entity\Post
     */
    public function getLastPost()
    {
        return \$this->lastPost;
    }

}

EOT;

    /**
     * @var string
     */
    protected $userInterfaceExpected = <<<EOT
<?php

namespace AppBundle\Entity;

/**
 * Interface for entity : \AppBundle\Entity\User
 */
interface UserInterface
{
    
    /**
     * For property "username"
     * @param string \$username
     * @return this
     */
    public function setUsername(\$username);

    /**
     * For property "username"
     * @return string
     */
    public function getUsername();

    /**
     * For property "email"
     * @param string \$email
     * @return this
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
     * @return this
     */
    public function setActive(\$active);

    /**
     * For property "active"
     * @return boolean
     */
    public function getActive();

    /**
     * For property "posts"
     * @param Doctrine\Common\Collections\ArrayCollection<AppBundle\Entity\Post> \$posts
     * @return this
     */
    public function setPosts(\Doctrine\Common\Collections\ArrayCollection \$posts);

    /**
     * For property "posts"
     * @return Doctrine\Common\Collections\ArrayCollection<AppBundle\Entity\Post>
     */
    public function getPosts();

    /**
     * For property "createdAt"
     * @param DateTime \$createdAt
     * @return this
     */
    public function setCreatedAt(\DateTime \$createdAt);

    /**
     * For property "createdAt"
     * @return DateTime
     */
    public function getCreatedAt();

    /**
     * For property "updatedAt"
     * @param DateTime \$updatedAt
     * @return this
     */
    public function setUpdatedAt(\DateTime \$updatedAt);

    /**
     * For property "updatedAt"
     * @return DateTime
     */
    public function getUpdatedAt();

    /**
     * For property "lastPost"
     * @param AppBundle\Entity\Post \$lastPost
     * @return this
     */
    public function setLastPost(\AppBundle\Entity\Post \$lastPost = null);

    /**
     * For property "lastPost"
     * @return AppBundle\Entity\Post
     */
    public function getLastPost();

}

EOT;

    /**
     * @var string
     */
    protected $postInterfaceExpected = <<<EOT
<?php

namespace AppBundle\Entity;

/**
 * Interface for entity : \AppBundle\Entity\Post
 */
interface PostInterface
{
    
    /**
     * For property "content"
     * @param string \$content
     * @return this
     */
    public function setContent(\$content);

    /**
     * For property "content"
     * @return string
     */
    public function getContent();

    /**
     * For property "createdAt"
     * @param DateTime \$createdAt
     * @return this
     */
    public function setCreatedAt(\DateTime \$createdAt);

    /**
     * For property "createdAt"
     * @return DateTime
     */
    public function getCreatedAt();

    /**
     * For property "updatedAt"
     * @param DateTime \$updatedAt
     * @return this
     */
    public function setUpdatedAt(\DateTime \$updatedAt);

    /**
     * For property "updatedAt"
     * @return DateTime
     */
    public function getUpdatedAt();

}

EOT;

    /**
     * @var string
     */
    protected $userTestClassExpected = <<<EOT
<?php

namespace AppBundle\Tests\Entity;

/**
 * Test for \AppBundle\Entity\User
 */
class UserTest extends \PHPUnit_Framework_TestCase
{
    
    /**
     * Entity to test
     * @var \AppBundle\Entity\UserInterface
     */
    private \$object = null;

    public function setUp()
    {
        \$this->object = new \AppBundle\Entity\User();
    }

    public function testConstructor()
    {
        \$this->assertNotNull(\$this->object);
        \$this->assertInstanceof('\AppBundle\Entity\UserInterface', \$this->object);
        \$this->assertInstanceof('\AppBundle\Entity\User', \$this->object);
        \$this->assertInstanceof('\AppBundle\Entity\Base', \$this->object);
    }

    
    /**
     * @covers \AppBundle\Entity\User::setUsername
     */
    public function testSetUsername()
    {
        \$this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers \AppBundle\Entity\User::getUsername
     */
    public function testGetUsername()
    {
        \$this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers \AppBundle\Entity\User::setEmail
     */
    public function testSetEmail()
    {
        \$this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers \AppBundle\Entity\User::getEmail
     */
    public function testGetEmail()
    {
        \$this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers \AppBundle\Entity\User::isActive
     */
    public function testIsActive()
    {
        \$this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers \AppBundle\Entity\User::setActive
     */
    public function testSetActive()
    {
        \$this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers \AppBundle\Entity\User::getActive
     */
    public function testGetActive()
    {
        \$this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers \AppBundle\Entity\User::setPosts
     */
    public function testSetPosts()
    {
        \$this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers \AppBundle\Entity\User::getPosts
     */
    public function testGetPosts()
    {
        \$this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers \AppBundle\Entity\User::setCreatedAt
     */
    public function testSetCreatedAt()
    {
        \$this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers \AppBundle\Entity\User::getCreatedAt
     */
    public function testGetCreatedAt()
    {
        \$this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers \AppBundle\Entity\User::setUpdatedAt
     */
    public function testSetUpdatedAt()
    {
        \$this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers \AppBundle\Entity\User::getUpdatedAt
     */
    public function testGetUpdatedAt()
    {
        \$this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers \AppBundle\Entity\User::setLastPost
     */
    public function testSetLastPost()
    {
        \$this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers \AppBundle\Entity\User::getLastPost
     */
    public function testGetLastPost()
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
    protected $postTestClassExpected = <<<EOT
<?php

namespace AppBundle\Tests\Entity;

/**
 * Test for \AppBundle\Entity\Post
 */
class PostTest extends \PHPUnit_Framework_TestCase
{
    
    /**
     * Entity to test
     * @var \AppBundle\Entity\PostInterface
     */
    private \$object = null;

    public function setUp()
    {
        \$this->object = new \AppBundle\Entity\Post();
    }

    public function testConstructor()
    {
        \$this->assertNotNull(\$this->object);
        \$this->assertInstanceof('\AppBundle\Entity\PostInterface', \$this->object);
        \$this->assertInstanceof('\AppBundle\Entity\Post', \$this->object);
    }

    
    /**
     * @covers \AppBundle\Entity\Post::setContent
     */
    public function testSetContent()
    {
        \$this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers \AppBundle\Entity\Post::getContent
     */
    public function testGetContent()
    {
        \$this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers \AppBundle\Entity\Post::setCreatedAt
     */
    public function testSetCreatedAt()
    {
        \$this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers \AppBundle\Entity\Post::getCreatedAt
     */
    public function testGetCreatedAt()
    {
        \$this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers \AppBundle\Entity\Post::setUpdatedAt
     */
    public function testSetUpdatedAt()
    {
        \$this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers \AppBundle\Entity\Post::getUpdatedAt
     */
    public function testGetUpdatedAt()
    {
        \$this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

}

EOT;
    protected $postClassWithoutInterface = <<<EOT
<?php

namespace AppBundle\Entity;

/**
 * 
 * 
 */
class Post
{
    
    /**
     * Post content
     * 
     * @\Symfony\Component\Validator\Constraints\NotBlank()
     * @\JMS\Serializer\Annotation\Type("string")
     * @\JMS\Serializer\Annotation\SerializedName("content")
     * @var string
     */
    private \$content;

    /**
     * 'created_at' property
     * 
     * 
     * @\JMS\Serializer\Annotation\Type("DateTime")
     * @\JMS\Serializer\Annotation\SerializedName("created_at")
     * @var DateTime
     */
    private \$createdAt;

    /**
     * 'updated_at' property
     * 
     * 
     * @\JMS\Serializer\Annotation\Type("DateTime")
     * @\JMS\Serializer\Annotation\SerializedName("updated_at")
     * @var DateTime
     */
    private \$updatedAt;

    
    /**
     * Constructor.
     */
    public function __construct()
    {
        
    }

    
    /**
     * For property "content"
     * @param string \$content
     * @return this
     */
    public function setContent(\$content)
    {
        \$this->content = \$content;
        return \$this;
    }

    /**
     * For property "content"
     * @return string
     */
    public function getContent()
    {
        return \$this->content;
    }

    /**
     * For property "createdAt"
     * @param DateTime \$createdAt
     * @return this
     */
    public function setCreatedAt(\DateTime \$createdAt)
    {
        \$this->createdAt = \$createdAt;
        return \$this;
    }

    /**
     * For property "createdAt"
     * @return DateTime
     */
    public function getCreatedAt()
    {
        return \$this->createdAt;
    }

    /**
     * For property "updatedAt"
     * @param DateTime \$updatedAt
     * @return this
     */
    public function setUpdatedAt(\DateTime \$updatedAt)
    {
        \$this->updatedAt = \$updatedAt;
        return \$this;
    }

    /**
     * For property "updatedAt"
     * @return DateTime
     */
    public function getUpdatedAt()
    {
        return \$this->updatedAt;
    }

}

EOT;

    /**
     * @var string
     */
    protected $postTestClassWithoutInterface = <<<EOT
<?php

namespace AppBundle\Tests\Entity;

/**
 * Test for \AppBundle\Entity\Post
 */
class PostTest extends \PHPUnit_Framework_TestCase
{
    
    /**
     * Entity to test
     * @var \AppBundle\Entity\Post
     */
    private \$object = null;

    public function setUp()
    {
        \$this->object = new \AppBundle\Entity\Post();
    }

    public function testConstructor()
    {
        \$this->assertNotNull(\$this->object);
        \$this->assertInstanceof('\AppBundle\Entity\Post', \$this->object);
    }

    
    /**
     * @covers \AppBundle\Entity\Post::setContent
     */
    public function testSetContent()
    {
        \$this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers \AppBundle\Entity\Post::getContent
     */
    public function testGetContent()
    {
        \$this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers \AppBundle\Entity\Post::setCreatedAt
     */
    public function testSetCreatedAt()
    {
        \$this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers \AppBundle\Entity\Post::getCreatedAt
     */
    public function testGetCreatedAt()
    {
        \$this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers \AppBundle\Entity\Post::setUpdatedAt
     */
    public function testSetUpdatedAt()
    {
        \$this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers \AppBundle\Entity\Post::getUpdatedAt
     */
    public function testGetUpdatedAt()
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
    protected $userClassWithTemplatesSetExpected = <<<EOT
<?php

namespace AppBundle\Entity;

/**
 * My own class template
 * New User entity
 * lorem ipsum
 * second row
 * @\Doctrine\Common\Annotations\Entity()
 */
class User extends \AppBundle\Entity\Base implements \AppBundle\Entity\UserInterface
{
    
    /**
     * My own protected property
     * 'id' property
     * 
     * 
     * @\JMS\Serializer\Annotation\Type("integer")
     * @\JMS\Serializer\Annotation\SerializedName("id")
     * @var integer
     */
    protected \$id;

    /**
     * Username for login
     * 
     * @\Symfony\Component\Validator\Constraints\NotBlank(message = "Login can not be empty")
     * @\Symfony\Component\Validator\Constraints\NotNull(message = "Login can not be null")
     * @\JMS\Serializer\Annotation\Type("string")
     * @\JMS\Serializer\Annotation\SerializedName("username")
     * @var string
     */
    private \$username;

    /**
     * User posts
     * 
     * 
     * @\JMS\Serializer\Annotation\Type("Doctrine\Common\Collections\ArrayCollection<AppBundle\Entity\Post>")
     * @\JMS\Serializer\Annotation\SerializedName("posts")
     * @var Doctrine\Common\Collections\ArrayCollection<AppBundle\Entity\Post>
     */
    private \$posts;

    /**
     * Wether user is active or not
     * 
     * @\Symfony\Component\Validator\Constraints\IsTrue()
     * @\JMS\Serializer\Annotation\Type("boolean")
     * @\JMS\Serializer\Annotation\SerializedName("active")
     * @var boolean
     */
    private \$active;

    
    /**
     * Constructor.
     * My own CONSTRUCT with parameter
     */
    public function __construct(\$zm)
    {
        \$zm1 = \$zm;
        \$this->posts = new \Doctrine\Common\Collections\ArrayCollection();
    }

    
    /**
     * For property "id"
     * @param integer \$id
     * @return this
     */
    final public function setId(\$id)
    {
        // this is final setter
        \$this->id = \$id;
        return \$this;
    }

    /**
     * For property "id"
     * My own getter template, I can do everything
     * @return integer
     */
    public function getId(\$defaultValue = "default")
    {
        if (empty(\$this->id)) {
            return \$defaultValue;
        }
    
        return \$this->id;
    }

    /**
     * For property "username"
     * @param string \$username
     * @return this
     */
    public function setUsername(\$username)
    {
        \$this->username = \$username;
        return \$this;
    }

    /**
     * For property "username"
     * @return string
     */
    public function getUsername()
    {
        return \$this->username;
    }

    /**
     * For property "posts"
     * @param Doctrine\Common\Collections\ArrayCollection<AppBundle\Entity\Post> \$posts
     * @return this
     */
    public function setPosts(\Doctrine\Common\Collections\ArrayCollection \$posts)
    {
        \$this->posts = \$posts;
        return \$this;
    }

    /**
     * For property "posts"
     * @return Doctrine\Common\Collections\ArrayCollection<AppBundle\Entity\Post>
     */
    public function getPosts()
    {
        return \$this->posts;
    }

    /**
     * For property "active" My own getter boolean template
     * @return boolean
     */
    public function isActive()
    {
        return (bool) \$this->active;
    }

    /**
     * For property "active"
     * @param boolean \$active
     * @return this
     */
    public function setActive(\$active)
    {
        \$this->active = \$active;
        return \$this;
    }

    


    /**
     * nothing to do
     */
    public function __toString()
    {
        return sprintf("class: %s", __CLASS__);
    }
}

EOT;

    /**
     * @var string 
     */
    protected $userInterfaceWithTemplatesSetExpected = <<<EOT
<?php

namespace AppBundle\Entity;

/**
 * My own interface template
 * Interface for entity : \AppBundle\Entity\User
 */
interface UserInterface
{
    
    /**
     * For property "id"
     * @param integer \$id
     * @return this
     * My own setter interface, I do not want type hinting and optional part!
     */
    public function setId(\$id);

    /**
     * For property "id" My own protected getter interface template
     * @return integer
     */
    protected function getId();

    /**
     * For property "username"
     * @param string \$username
     * @return this
     */
    public function setUsername(\$username);

    /**
     * For property "username"
     * @return string
     */
    public function getUsername();

    /**
     * For property "posts"
     * @param Doctrine\Common\Collections\ArrayCollection<AppBundle\Entity\Post> \$posts
     * @return this
     */
    public function setPosts(\Doctrine\Common\Collections\ArrayCollection \$posts);

    /**
     * For property "posts"
     * @return Doctrine\Common\Collections\ArrayCollection<AppBundle\Entity\Post>
     */
    public function getPosts();

    /**
     * For property "active"
     * @return boolean
     */
    public function isActiveMyOwn();

    /**
     * For property "active"
     * @param boolean \$active
     * @return this
     */
    public function setActive(\$active);

    /**
     * For property "active"
     * @return boolean
     */
    public function getActive();

}

EOT;

    /**
     * @var string 
     */
    protected $userTestClassWithTemplatesSetExpected = <<<EOT
<?php

namespace AppBundle\Tests\Entity;

/**
 * I do not want to init object!
 */
class UserTest extends \PHPUnit_Framework_TestCase
{
    
    /**
     * @covers \AppBundle\Entity\User::setId
     */
    public function testSetId()
    {
        \$this->markTestIncomplete(
            'This test has not been implemented yet. Some.'
        );
        // My own test method!!
    }

    /**
     * @covers \AppBundle\Entity\User::getId
     */
    public function testGetId()
    {
        \$this->markTestIncomplete(
            'This test has not been implemented yet. Some.'
        );
        // My own test method!!
    }

    /**
     * @covers \AppBundle\Entity\User::setUsername
     */
    public function testSetUsername()
    {
        \$this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers \AppBundle\Entity\User::getUsername
     */
    public function testGetUsername()
    {
        \$this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers \AppBundle\Entity\User::setPosts
     */
    public function testSetPosts()
    {
        \$this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers \AppBundle\Entity\User::getPosts
     */
    public function testGetPosts()
    {
        \$this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers \AppBundle\Entity\User::isActive
     */
    public function testIsActive()
    {
        \$this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers \AppBundle\Entity\User::setActive
     */
    public function testSetActive()
    {
        \$this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers \AppBundle\Entity\User::getActive
     */
    public function testGetActive()
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
    protected $postClassWithoutInterfaceExpected = <<<EOT
<?php

namespace AppBundle\Entity;

/**
 * 
 * 
 */
class Post
{
    
    /**
     * 'id' property
     * 
     * 
     * @\JMS\Serializer\Annotation\Type("integer")
     * @\JMS\Serializer\Annotation\SerializedName("id")
     * @var integer
     */
    private \$id;

    
    /**
     * Constructor.
     */
    public function __construct()
    {
        
    }

    
    /**
     * For property "id"
     * @param integer \$id
     * @return this
     */
    public function setId(\$id)
    {
        \$this->id = \$id;
        return \$this;
    }

    /**
     * For property "id"
     * @return integer
     */
    public function getId()
    {
        return \$this->id;
    }

}

EOT;

    /**
     * @dataProvider dataForTestRender
     */
    public function testRender($item, $expectedOutput)
    {
        $result = $this->getRenderer()->render($item);
        $this->assertEquals($expectedOutput, $result);
    }

    public function dataForTestRender()
    {
        $classManagers = $this->generateDataFromYamlHelper();
        $anotherClassManagers = $this->generateClassManagersFromYaml(Helper::getStructureYamlForTemplateChangeTest());
        $classManagersWithInlineConfiguration = $this->generateClassManagersFromYaml(Helper::getStructureYamlForTestInlineClassConfuration());

        return [
            [$classManagers[0], $this->userClassExpected],
            [$classManagers[1], $this->postClassExpected],
            [$classManagers[0]->getInterface(), $this->userInterfaceExpected],
            [$classManagers[1]->getInterface(), $this->postInterfaceExpected],
            [$classManagers[0]->getTestClass(), $this->userTestClassExpected],
            [$classManagers[1]->getTestClass(), $this->postTestClassExpected],
            [$anotherClassManagers[0], $this->userClassWithTemplatesSetExpected],
            [$anotherClassManagers[0]->getInterface(), $this->userInterfaceWithTemplatesSetExpected],
            [$anotherClassManagers[0]->getTestClass(), $this->userTestClassWithTemplatesSetExpected],
            [$classManagersWithInlineConfiguration[0], $this->postClassWithoutInterfaceExpected],
        ];
    }

    public function testRenderAndPutItemsToContent()
    {
        $itemsToRender = new ArrayCollection();
        $itemsToRender->add(Helper::prepareProperty("active", "boolean", "is post active", ["IsTrue()"]));
        $result = $this->getRenderer()->renderAndPutItemsToContent($this->postClassExpected, $itemsToRender, 41);
        $this->assertEquals($this->postClassWithNewPropertyExpected, $result);
    }

    public function testRenderAndPutConstructorBodyToContent()
    {
        $constructorManager = new ClassConstructorManager(new ClassManager());
        $initProperties = new ArrayCollection();
        $initProperty = new InitPropertyManager();
        $initProperty->setProperty(Helper::prepareProperty("collection", "Doctrine\Common\Collections\ArrayCollection", "items collection", ["Valid(message = \"Collection has to be valid!\")"]));
        $initProperty2 = new InitPropertyManager();
        $initProperty2->setProperty(Helper::prepareProperty("collection2", "Doctrine\Common\Collections\ArrayCollection", "items collection 2", ["Valid(message = \"Collection has to be valid!\")"]));
        $initProperties->add($initProperty2);
        $initProperties->add($initProperty);
        $constructorManager->setInitProperties($initProperties);
        $result = $this->getRenderer()->renderAndPutConstructorBodyToContent($this->postClassExpected, $constructorManager, 47);
        $this->assertEquals($this->postClassWithUpdatedConstructor, $result);
    }

    public function testRenderClassWithoutInterface()
    {
        $class = $this->initDataFromYamlAndGetSecondClassWithoutInterface();
        $result = $this->getRenderer()->render($class);
        $this->assertEquals($this->postClassWithoutInterface, $result);
    }

    public function testRenderTestClassForClassWithoutInterface()
    {
        $class = $this->initDataFromYamlAndGetSecondClassWithoutInterface();
        $result = $this->getRenderer()->render($class->getTestClass());
        $this->assertEquals($this->postTestClassWithoutInterface, $result);
    }

    /**
     * @return ClassManager
     */
    protected function initDataFromYamlAndGetSecondClassWithoutInterface()
    {
        $classConfig = new ClassConfig();
        $classConfig->setNoInterface(true);
        $classManagers = $this->generateDataFromYamlHelper($classConfig);
        return $classManagers[1];
    }

    protected function generateDataFromYamlHelper(ClassConfig $classConfig = null)
    {
        return $this->generateClassManagersFromYaml(Helper::getStructureYaml(), $classConfig);
    }

    protected function generateClassManagersFromYaml($yaml, ClassConfig $classConfig = null)
    {
        self::bootKernel();
        $structureGenerator = self::$kernel->getContainer()->get('seg.structure_generator');
        return $structureGenerator->buildEntitiesClassStructure($structureGenerator->parseToArray($yaml), $classConfig);
    }

    protected function getRenderer()
    {
        self::bootKernel();
        return self::$kernel->getContainer()->get('seg.renderer');
    }
}
