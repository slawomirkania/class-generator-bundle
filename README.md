# About

Class Generator Bundle
- Generate classes, interfaces and PHPUnit test classes from the YAML schema.
- Generator does not overwrite existing methods or properties, only render new elements.
- Generated entity class is compatible with JMS Serializer, each property has an annotation @Type based on a property type.
- Also each property has an annotation @SerializedName which can be adjusted like in the example below (user_setting).
- Generator allows to add Symfony constraints to a property.
- Generator allows to handle inheritance.

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
    if (in_array($this->getEnvironment(), array('dev', 'test'), true)) {
        //...
            $bundles[] = new HelloWordPl\SimpleEntityGeneratorBundle\HelloWordPlSimpleEntityGeneratorBundle();
        //...
    }
    //...
}
```

# Usage

### Create YAML structure as below

```yml
-
  namespace: \AppBundle\Api\Command\UserUpdate
  extends: \AppBundle\Api\Command\Request
  comment: "Update user data command"
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
        - Type(type = "boolean")
    -
      name: groups
      type: Doctrine\Common\Collections\ArrayCollection<AppBundle\Api\Param\Group>
      comment: User groups
    -
      # default comment
      name: user_setting
      serialized_name: userSetting
      type: AppBundle\Api\Param\Setting
-
  namespace: \AppBundle\Api\Param\Group
  # no comment
  properties:
    -
      name: name
      type: string
      comment: "Group name"
      constraints:
        - NotBlank()
    -
      name: description
      type: string
      comment: "Group description"
-
  namespace: \AppBundle\Api\Param\Setting
  # no comment
  # no properties
```

Put {file_name_with_extension} YAML file into {bundle_name}\Resources\config\

Run Symfony command

```sh
$ ./bin/console class_generator:generate {bundle_name} {file_name_with_extension}
```
Options (optional)

--no-interfaces - Switches off interfaces generating

--no-phpunit-classes - Switches off PHPUnit classes generating

```sh
$ ./bin/console class_generator:generate {bundle_name} {file_name_with_extension} --no-interfaces --no-phpunit-classes
```
After processing generated tests (if test classes generated), by command e.g.

```sh
phpunit {base_url}/src/AppBundle/Tests/
```

you should see an error because class \AppBundle\Api\Command\Request does not exist.
Append the following minimalistic code to the YAML structure {bundle_name}\Resources\config\{file_name_with_extension}

```yml
-
  namespace: \AppBundle\Api\Command\Request
  comment: "Base class for commands"
  # no properties
```
Remove code generated before, because when some class has syntax error, generator can not work properly.
Run Symfony command again.
Execute tests again and then you should see something like this:

```sh
...IIIIIIIIIII.IIII.

Time: 124 ms, Memory: 6.75Mb
```
Now you can implement missing tests cases.

### Generated files namespaces:
- AppBundle\Api\Command\Request
- AppBundle\Api\Command\RequestInterface (when no --no-interfaces option)
- AppBundle\Tests\Api\Command\RequestTest (when no --no-phpunit-classes option)

- AppBundle\Api\Command\UserUpdate
- AppBundle\Api\Command\UserUpdateInterface (when no --no-interfaces option)
- AppBundle\Tests\Api\Command\UserUpdateTest (when no --no-phpunit-classes option)

- AppBundle\Api\Param\Group
- AppBundle\Api\Param\GroupInterface (when no --no-interfaces option)
- AppBundle\Tests\Api\Param\GroupTest (when no --no-phpunit-classes option)

- AppBundle\Api\Param\Setting
- AppBundle\Api\Param\SettingInterface (when no --no-interfaces option)
- AppBundle\Tests\Api\Param\SettingTest (when no --no-phpunit-classes option)

You can check how deserialization of generated classes works.
```json
{
  "username": "slawomir",
  "email": "slawomir.kania1@gmail.com",
  "active": true,
  "groups": [
    {
      "name": "admin",
      "description": "admin group"
    },
    {
      "name": "guest",
      "description": "guest group"
    }
  ],
  "userSetting": {

  }
}
```

```php
    ...
    $json = "{...}";
    $serializer = \JMS\Serializer\SerializerBuilder::create()->build();
    $userUpdateDeserialized = $serializer->deserialize($json, "AppBundle\Api\Command\UserUpdate", "json");
    var_dump($userUpdateDeserialized);
    ...
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