<?php

namespace SimpleEntityGeneratorBundle\Tests\Lib;

use Doctrine\Common\Collections\ArrayCollection;
use SimpleEntityGeneratorBundle\Lib\Items\ClassManager;
use SimpleEntityGeneratorBundle\Lib\Items\PropertyManager;

/**
 * @author Sławomir Kania <slawomir.kania1@gmail.com>
 */
class Helper
{

    /**
     * @param string $name
     * @param string $type
     * @param string $comment
     * @param array $constraintsParts
     * @return PropertyManager
     */
    public static function prepareProperty($name, $type, $comment = "", array $constraintsParts = [])
    {
        $propertyManager = new PropertyManager();
        $propertyManager->setName($name);
        $propertyManager->setType($type);
        $propertyManager->setComment($comment);

        $constraintCollection = new ArrayCollection();
        foreach ($constraintsParts as $constraintPart) {
            $constraintCollection->add($constraintPart);
        }

        $propertyManager->setConstraints($constraintCollection);

        return $propertyManager;
    }

    /**
     * @param string $namespace
     * @return ClassManager
     */
    public static function prepareBasicClassManager($namespace = "\AppBundle\Entity\User")
    {
        $classManager = new ClassManager();
        $classManager->setNamespace($namespace);
        $classManager->setComment("User entity for tests");

        $propertiesCollection = new ArrayCollection();
        $propertiesCollection->add(self::prepareProperty("full_name", "string", "", ["NotBlank()"]));
        $propertiesCollection->add(self::prepareProperty("email", "string", "", ["Email(message = \"Invalid email!\")"]));
        $propertiesCollection->add(self::prepareProperty("active", "boolean", "Wether user active", ["Type(type='boolean')", "IsTrue()"]));
        $propertiesCollection->add(self::prepareProperty("new_posts", "Doctrine\Common\Collections\ArrayCollection<AppBundle\Entity\Post>", "User new posts", ["NotNull()", "Valid()"]));
        $classManager->setProperties($propertiesCollection);

        $implementsCollection = new ArrayCollection();
        $implementsCollection->add('\Symfony\Component\Security\Core\User\UserInterface');
        $implementsCollection->add('\SimpleEntityGeneratorBundle\Tests\Lib\Dummies\CredentialsAwareInterface');
        $classManager->setImplements($implementsCollection);

        return $classManager;
    }

    /**
     * @return string
     */
    public static function getStructureYaml()
    {
        return '
-
  namespace: \AppBundle\Entity\User
  extends: \AppBundle\Entity\Base
  comment: "New User entity"
  multiline_comment:
      - \'lorem ipsum\'
      - \'second row\'
      - \'@\Doctrine\Common\Annotations\Entity()\'
  implements:
      - \Symfony\Component\Security\Core\User\UserInterface
      - \SimpleEntityGeneratorBundle\Tests\Lib\Dummies\CredentialsAwareInterface
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
      multiline_comment:
        - \'@\Doctrine\Common\Annotations\Column()\'
        - \'lorem ipsum\'
        - \'third row\'
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
      serialized_name: lastPost
      type: AppBundle\Entity\Post
      optional: true
    -
      # default comment
      name: roles
      type: string
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
      type: DateTime';
    }

    /**
     * @return string
     */
    public static function getStructureYamlForTemplateChangeTest()
    {
        return '
-
  namespace: \AppBundle\Entity\User
  extends: \AppBundle\Entity\Base
  comment: "New User entity"
  configuration:
    no_interface: false
    no_phpunit_class: false
  multiline_comment:
      - \'lorem ipsum\'
      - \'second row\'
      - \'@\Doctrine\Common\Annotations\Entity()\'
  class_manager_template_path: AppBundle/Resources/templates_for_test/ClassTemplate.txt
  class_constructor_manager_template_path: AppBundle/Resources/templates_for_test/ClassConstructorTemplate.txt
  interface_manager_template_path: AppBundle/Resources/templates_for_test/InterfaceTemplate.txt
  test_class_manager_template_path: AppBundle/Resources/templates_for_test/TestClassTemplate.txt
  properties:
    -
      name: id
      type: integer
      method_setter_interface_manager_template_path: AppBundle/Resources/templates_for_test/MethodSetterInterfaceTemplate.txt
      method_setter_manager_template_path: AppBundle/Resources/templates_for_test/MethodSetterTemplate.txt
      property_manager_template_path: AppBundle/Resources/templates_for_test/PropertyTemplate.txt
      test_class_method_manager_template_path: AppBundle/Resources/templates_for_test/TestMethodTemplate.txt
      method_getter_interface_manager_template_path: AppBundle/Resources/templates_for_test/MethodGetterInterfaceTemplate.txt
      method_getter_manager_template_path: AppBundle/Resources/templates_for_test/MethodGetterTemplate.txt
    -
      name: username
      type: string
      comment: "Username for login"
      constraints:
        - NotBlank(message = "Login can not be empty")
        - NotNull(message = "Login can not be null")
    -
      name: posts
      type: Doctrine\Common\Collections\ArrayCollection<AppBundle\Entity\Post>
      comment: User posts
    -
      name: active
      type: boolean
      comment: "Wether user is active or not"
      constraints:
        - IsTrue()
      method_getter_boolean_interface_manager_template_path: AppBundle/Resources/templates_for_test/MethodGetterBooleanInterfaceTemplate.txt
      method_getter_boolean_manager_template_path: AppBundle/Resources/templates_for_test/MethodGetterBooleanTemplate.txt
      method_getter_manager_template_path: AppBundle/Resources/templates_for_test/EmptyTemplate.txt';
    }

    public static function getStructureYamlForTestInlineClassConfuration()
    {
        return '
-
  namespace: \AppBundle\Entity\Post
  configuration:
    no_interface: true
    no_phpunit_class: true
  properties:
    -
      name: id
      type: integer';
    }
}
