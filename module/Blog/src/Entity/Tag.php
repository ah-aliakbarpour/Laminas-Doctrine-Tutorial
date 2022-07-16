<?php

namespace Blog\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * This class represents a tag.
 * @ORM\Entity
 * @ORM\Table(name="tag")
 */
class Tag
{
    // Constructor.
    public function __construct()
    {
        $this->posts = new ArrayCollection();
    }

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

    /**
     * @ORM\ManyToMany(targetEntity="\Blog\Entity\Post", mappedBy="tags")
     */
    protected $posts;

    /**
     * Returns posts for this tag.
     * @return ArrayCollection
     */
    public function getPosts()
    {
        return $this->posts;
    }

    /**
     * Adds a new post to this tag.
     * @param $post
     */
    public function addPost($post)
    {
        $this->posts[] = $post;
    }
}