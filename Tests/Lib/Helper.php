<?php

namespace HelloWordPl\SimpleEntityGeneratorBundle\Tests\Lib;

use Doctrine\Common\Collections\ArrayCollection;
use HelloWordPl\SimpleEntityGeneratorBundle\Lib\Items\PropertyManager;

/**
 * @author Sławomir Kania <slawomir.kania1@gmail.com>
 */
class Helper
{

    /**
     * @param string $name
     * @param string $type
     * @param string $comment
     * @param array $validators
     * @return PropertyManager
     */
    public static function prepareProperty($name, $type, $comment = "", array $validators = [])
    {
        $propertyManager = new PropertyManager();
        $propertyManager->setName($name);
        $propertyManager->setType($type);
        $propertyManager->setComment($comment);

        $validatorsCollection = new ArrayCollection();
        foreach ($validators as $validator) {
            $validatorsCollection->add($validator);
        }

        $propertyManager->setValidators($validatorsCollection);

        return $propertyManager;
    }

    /**
     * @return string
     */
    public static function getStructureYaml()
    {
        return '
-
  namespace: \AppBundle\Entity\User
  comment: "New User entity"
  properties:
    -
      name: username
      type: string
      comment: "Username for login"
      validators:
        - NotBlank(message = \'Login can not be empty\')
        - NotNull(message = \'Login can not be null\')
    -
      name: email
      type: string
      comment: "User email"
      validators:
        - NotBlank()
        - Email(message = \'Invalid email\')
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
      type: DateTime';
        ;
    }
}
