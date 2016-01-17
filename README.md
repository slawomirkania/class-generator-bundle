# About

Class Generator Bundle
- Generate classes, interfaces and PHPUnit test classes from YAML schema.
- Generator does not overwrite existing methods or properties, only render new elements.
- Generated entity class is compatible with JMS Serializer, each property has anotation @Type based on property type.
- Generator allows to add Symfony constraints to property.

# Installation

```bash
$ php composer.phar require slawomirkania/class-generator-bundle dev-master
```

### Symfony configuration

 app/config/config.yml
```yml
 framework:
 validation: { enable_annotations: true }
```
app/AppKernel.php
```php
public function registerBundles()
{
    $bundles = array(
        //...
            new HelloWordPl\SimpleEntityGeneratorBundle\HelloWordPlSimpleEntityGeneratorBundle(),
        //...
    );
    //...
}
```

# Usage

### Create YAML structure as below

```yml
-
  namespace: \AppBundle\Entity\User
  comment: "New User entity"
  properties:
    -
      name: username
      type: string
      comment: "Username for login"
      constraints:
        - NotBlank(message = "Login can not be empty")
        - NotNull(message = "Login can not be null")
    -
      name: email
      type: string
      comment: "User email"
      constraints:
        - NotBlank()
        - Email(message = "Invalid email")
    -
      name: active
      type: boolean
      comment: "Wether user is active or not"
      constraints:
        - IsTrue()
    -
      name: posts
      type: Doctrine\Common\Collections\ArrayCollection<AppBundle\Entity\Post>
      comment: User posts
    -
      # default comment
      name: created_at
      type: DateTime
    -
      # default comment
      name: updated_at
      type: DateTime
    -
      # default comment
      name: last_post
      type: AppBundle\Entity\Post
-
  namespace: \AppBundle\Entity\Post
  # no comment
  properties:
    -
      name: content
      type: string
      comment: "Post content"
      constraints:
        - NotBlank()
    -
      # default comment
      name: created_at
      type: DateTime
    -
      # default comment
      name: updated_at
      type: DateTime
```

Put {file_name_with_extension} YAML file into {bundle_name}\Resources\config\

Run Symfony command

```sh
$ ./bin/console class_generator:generate {bundle_name} {file_name_with_extension}
```
### Output structures:

- AppBundle/Entity/User.php

```php

namespace AppBundle\Entity;

/**
 * New User entity
 */
class User implements \AppBundle\Entity\UserInterface
{

    /**
     * Username for login
     *
     * @\Symfony\Component\Validator\Constraints\NotBlank(message = "Login can not be empty")
     * @\Symfony\Component\Validator\Constraints\NotNull(message = "Login can not be null")
     * @\JMS\Serializer\Annotation\Type("string")
     * @var string
     */
    private $username;

    /**
     * User email
     *
     * @\Symfony\Component\Validator\Constraints\NotBlank()
     * @\Symfony\Component\Validator\Constraints\Email(message = "Invalid email")
     * @\JMS\Serializer\Annotation\Type("string")
     * @var string
     */
    private $email;

    /**
     * Wether user is active or not
     *
     * @\Symfony\Component\Validator\Constraints\IsTrue()
     * @\JMS\Serializer\Annotation\Type("boolean")
     * @var boolean
     */
    private $active;

    /**
     * User posts
     *
     * @\JMS\Serializer\Annotation\Type("Doctrine\Common\Collections\ArrayCollection<AppBundle\Entity\Post>")
     * @var Doctrine\Common\Collections\ArrayCollection<AppBundle\Entity\Post>
     */
    private $posts;

    /**
     * 'created_at' property
     *
     * @\JMS\Serializer\Annotation\Type("DateTime")
     * @var DateTime
     */
    private $createdAt;

    /**
     * 'updated_at' property
     *
     * @\JMS\Serializer\Annotation\Type("DateTime")
     * @var DateTime
     */
    private $updatedAt;

    /**
     * 'last_post' property
     *
     * @\JMS\Serializer\Annotation\Type("AppBundle\Entity\Post")
     * @var AppBundle\Entity\Post
     */
    private $lastPost;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->posts = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * For property "username"
     *
     * @param string $username
     * @return this
     */
    public function setUsername($username)
    {
        $this->username = $username;
        return $this;
    }

    /**
     * For property "username"
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
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
     * For property "posts"
     *
     * @param Doctrine\Common\Collections\ArrayCollection<AppBundle\Entity\Post> $posts
     * @return this
     */
    public function setPosts(\Doctrine\Common\Collections\ArrayCollection $posts)
    {
        $this->posts = $posts;
        return $this;
    }

    /**
     * For property "posts"
     *
     * @return Doctrine\Common\Collections\ArrayCollection<AppBundle\Entity\Post>
     */
    public function getPosts()
    {
        return $this->posts;
    }

    /**
     * For property "createdAt"
     *
     * @param DateTime $createdAt
     * @return this
     */
    public function setCreatedAt(\DateTime $createdAt)
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     * For property "createdAt"
     *
     * @return DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * For property "updatedAt"
     *
     * @param DateTime $updatedAt
     * @return this
     */
    public function setUpdatedAt(\DateTime $updatedAt)
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    /**
     * For property "updatedAt"
     *
     * @return DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * For property "lastPost"
     *
     * @param AppBundle\Entity\Post $lastPost
     * @return this
     */
    public function setLastPost(\AppBundle\Entity\Post $lastPost)
    {
        $this->lastPost = $lastPost;
        return $this;
    }

    /**
     * For property "lastPost"
     *
     * @return AppBundle\Entity\Post
     */
    public function getLastPost()
    {
        return $this->lastPost;
    }

}

```

- AppBundle\Entity\UserInterface.php

```php

namespace AppBundle\Entity;

/**
 * Interface for entity : \AppBundle\Entity\User
 */
interface UserInterface
{

    /**
     * For property "username"
     * @param string $username
     * @return this
     */
    public function setUsername($username);

    /**
     * For property "username"
     * @return string
     */
    public function getUsername();

    /**
     * For property "email"
     * @param string $email
     * @return this
     */
    public function setEmail($email);

    /**
     * For property "email"
     * @return string
     */
    public function getEmail();

    /**
     * For property "active"
     *
     * @return boolean
     */
    public function isActive();

    /**
     * For property "active"
     * @param boolean $active
     * @return this
     */
    public function setActive($active);

    /**
     * For property "active"
     * @return boolean
     */
    public function getActive();

    /**
     * For property "posts"
     * @param Doctrine\Common\Collections\ArrayCollection<AppBundle\Entity\Post> $posts
     * @return this
     */
    public function setPosts(\Doctrine\Common\Collections\ArrayCollection $posts);

    /**
     * For property "posts"
     * @return Doctrine\Common\Collections\ArrayCollection<AppBundle\Entity\Post>
     */
    public function getPosts();

    /**
     * For property "createdAt"
     * @param DateTime $createdAt
     * @return this
     */
    public function setCreatedAt(\DateTime $createdAt);

    /**
     * For property "createdAt"
     * @return DateTime
     */
    public function getCreatedAt();

    /**
     * For property "updatedAt"
     * @param DateTime $updatedAt
     * @return this
     */
    public function setUpdatedAt(\DateTime $updatedAt);

    /**
     * For property "updatedAt"
     * @return DateTime
     */
    public function getUpdatedAt();

    /**
     * For property "lastPost"
     * @param AppBundle\Entity\Post $lastPost
     * @return this
     */
    public function setLastPost(\AppBundle\Entity\Post $lastPost);

    /**
     * For property "lastPost"
     * @return AppBundle\Entity\Post
     */
    public function getLastPost();

}

```

- AppBundle/Tests/Entity/UserTest.php

```php

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
    private $object = null;

    public function setUp()
    {
        $this->object = new \AppBundle\Entity\User();
    }

    public function testConstructor()
    {
        $this->assertNotNull($this->object);
        $this->assertInstanceof('\AppBundle\Entity\UserInterface', $this->object);
        $this->assertInstanceof('\AppBundle\Entity\User', $this->object);
    }

    /**
     * @covers \AppBundle\Entity\User::setUsername
     */
    public function testSetUsername()
    {
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers \AppBundle\Entity\User::getUsername
     */
    public function testGetUsername()
    {
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers \AppBundle\Entity\User::setEmail
     */
    public function testSetEmail()
    {
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers \AppBundle\Entity\User::getEmail
     */
    public function testGetEmail()
    {
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers \AppBundle\Entity\User::isActive
     */
    public function testIsActive()
    {
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers \AppBundle\Entity\User::setActive
     */
    public function testSetActive()
    {
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers \AppBundle\Entity\User::getActive
     */
    public function testGetActive()
    {
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers \AppBundle\Entity\User::setPosts
     */
    public function testSetPosts()
    {
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers \AppBundle\Entity\User::getPosts
     */
    public function testGetPosts()
    {
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers \AppBundle\Entity\User::setCreatedAt
     */
    public function testSetCreatedAt()
    {
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers \AppBundle\Entity\User::getCreatedAt
     */
    public function testGetCreatedAt()
    {
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers \AppBundle\Entity\User::setUpdatedAt
     */
    public function testSetUpdatedAt()
    {
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers \AppBundle\Entity\User::getUpdatedAt
     */
    public function testGetUpdatedAt()
    {
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers \AppBundle\Entity\User::setLastPost
     */
    public function testSetLastPost()
    {
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers \AppBundle\Entity\User::getLastPost
     */
    public function testGetLastPost()
    {
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

}

```

- AppBundle/Entity/Post.php

```php

namespace AppBundle\Entity;

/**
 *
 */
class Post implements \AppBundle\Entity\PostInterface
{

    /**
     * Post content
     *
     * @\Symfony\Component\Validator\Constraints\NotBlank()
     * @\JMS\Serializer\Annotation\Type("string")
     * @var string
     */
    private $content;

    /**
     * 'created_at' property
     *
     * @\JMS\Serializer\Annotation\Type("DateTime")
     * @var DateTime
     */
    private $createdAt;

    /**
     * 'updated_at' property
     *
     * @\JMS\Serializer\Annotation\Type("DateTime")
     * @var DateTime
     */
    private $updatedAt;

    /**
     * Constructor.
     */
    public function __construct()
    {
    }

    /**
     * For property "content"
     *
     * @param string $content
     * @return this
     */
    public function setContent($content)
    {
        $this->content = $content;
        return $this;
    }

    /**
     * For property "content"
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * For property "createdAt"
     *
     * @param DateTime $createdAt
     * @return this
     */
    public function setCreatedAt(\DateTime $createdAt)
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     * For property "createdAt"
     *
     * @return DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * For property "updatedAt"
     *
     * @param DateTime $updatedAt
     * @return this
     */
    public function setUpdatedAt(\DateTime $updatedAt)
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    /**
     * For property "updatedAt"
     *
     * @return DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

}

```

- AppBundle/Entity/PostInterface.php

```php

namespace AppBundle\Entity;

/**
 * Interface for entity : \AppBundle\Entity\Post
 */
interface PostInterface
{

    /**
     * For property "content"
     * @param string $content
     * @return this
     */
    public function setContent($content);

    /**
     * For property "content"
     * @return string
     */
    public function getContent();

    /**
     * For property "createdAt"
     * @param DateTime $createdAt
     * @return this
     */
    public function setCreatedAt(\DateTime $createdAt);

    /**
     * For property "createdAt"
     * @return DateTime
     */
    public function getCreatedAt();

    /**
     * For property "updatedAt"
     * @param DateTime $updatedAt
     * @return this
     */
    public function setUpdatedAt(\DateTime $updatedAt);

    /**
     * For property "updatedAt"
     * @return DateTime
     */
    public function getUpdatedAt();

}

```

- AppBundle/Tests/Entity/PostTest.php

```php

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
    private $object = null;

    public function setUp()
    {
        $this->object = new \AppBundle\Entity\Post();
    }

    public function testConstructor()
    {
        $this->assertNotNull($this->object);
        $this->assertInstanceof('\AppBundle\Entity\PostInterface', $this->object);
        $this->assertInstanceof('\AppBundle\Entity\Post', $this->object);
    }

    /**
     * @covers \AppBundle\Entity\Post::setContent
     */
    public function testSetContent()
    {
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers \AppBundle\Entity\Post::getContent
     */
    public function testGetContent()
    {
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers \AppBundle\Entity\Post::setCreatedAt
     */
    public function testSetCreatedAt()
    {
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers \AppBundle\Entity\Post::getCreatedAt
     */
    public function testGetCreatedAt()
    {
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers \AppBundle\Entity\Post::setUpdatedAt
     */
    public function testSetUpdatedAt()
    {
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers \AppBundle\Entity\Post::getUpdatedAt
     */
    public function testGetUpdatedAt()
    {
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

}

```


License
----

The MIT License (MIT)

Copyright (c) 2016 Sławomir Kania

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.