# About

Simple Entity Generator Bundle
- Generate classes, interfaces and PHPUnit test class skeletons from YAML schema.
- Generator does not overwrites existing methods and properties, only render new elements.
- Generated entity class is compatible with JMS Serializer, every property has anotation based on property type.
- Generator allows to add Symfony constraints to property.

# Usage

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
            new JMS\SerializerBundle\JMSSerializerBundle(),
        //...
    );
    //...
}
```

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
      validators:
        - NotBlank(message = 'Login can not be empty')
        - NotNull(message = 'Login can not be null')
    -
      name: email
      type: string
      comment: "User email"
      validators:
        - NotBlank()
        - Email(message = 'Invalid email')
    -
      name: active
      type: boolean
      comment: "Wether user is active or not"
      validators:
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
      validators:
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

### Put {file_name_with_extension} YAML file into {bundle_name}\Resources\config\
### Run Symfony command ./bin/console simple_entity_generator:generate {bundle_name} {file_name_with_extension}
### Output structure namespaces:

- \AppBundle\Entity\User
- \AppBundle\Entity\UserInterface
- \AppBundle\Tests\Entity\UserTest
- \AppBundle\Entity\Post
- \AppBundle\Entity\PostInterface
- \AppBundle\Tests\Entity\PostTest


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