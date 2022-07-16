<?php

namespace Blog\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * This class represents a tag.
 * @ORM\Entity
 * @ORM\Table(name="tag")
 */
class Tag
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(name="id")
     */
    protected $id;

    /**
     * @ORM\Column(name="name")
     */
    protected $name;

    // Returns ID of this tag.
    public function getId()
    {
        return $this->id;
    }

    // Sets ID of this tag.
    public function setId($id)
    {
        $this->id = $id;
    }

    // Returns name.
    public function getName()
    {
        return $this->name;
    }

    // Sets name.
    public function setName($name)
    {
        $this->name = $name;
    }
}