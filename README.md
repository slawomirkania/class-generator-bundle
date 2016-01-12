## About

Simple Entity Generator Bundle
Generate classes, interfaces and PHPUnit test class skeletons from YAML schema.
Generator does not overwrites existing methods and properties, only render new elements.
Generated entity class is compatible with JMS Serializer, every property has anotation based on property type. 
Generator allows to add Symfony constraints to property.

## Usage

1. Enable validation by annotations
 app/config/config.yml

 framework:
 validation: { enable_annotations: true }

2. Create YAML structure as below

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

3. Put {file_name_with_extension} YAML file into {bundle_name}\Resources\config\
4. Run Symfony command ./bin/console simple_entity_generator:generate {bundle_name} {file_name_with_extension}
5. Output structure namespaces:
    \AppBundle\Entity\User
    \AppBundle\Entity\UserInterface
    \AppBundle\Tests\Entity\UserTest
    \AppBundle\Entity\Post
    \AppBundle\Entity\PostInterface
    \AppBundle\Tests\Entity\PostTest