<?php

namespace Blog\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Blog\Entity\Comment;
use Doctrine\ORM\Mapping as ORM;

/**
 * This class represents a single post in a blog.
 * @ORM\Entity(repositoryClass="\Blog\Repository\PostRepository")
 * @ORM\Table(name="post")
 */
class Post
{
    public function __construct()
    {
        $this->comments = new ArrayCollection();
        $this->tags = new ArrayCollection();
    }

    // Post status constants.
    const STATUS_DRAFT       = 1; // Draft.
    const STATUS_PUBLISHED   = 2; // Published.

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(name="id")
     */
    protected $id;

    /**
     * @ORM\Column(name="title")
     */
    protected $title;

    /**
     * @ORM\Column(name="content")
     */
    protected $content;

    /**
     * @ORM\Column(name="status")
     */
    protected $status;

    /**
     * @ORM\Column(name="date_created")
     */
    protected $dateCreated;

    // Returns ID of this post.
    public function getId()
    {
        return $this->id;
    }

    // Sets ID of this post.
    public function setId($id)
    {
        $this->id = $id;
    }

    // Returns title.
    public function getTitle()
    {
        return $this->title;
    }

    // Sets title.
    public function setTitle($title)
    {
        $this->title = $title;
    }

    // Returns status.
    public function getStatus()
    {
        return $this->status;
    }

    // Sets status.
    public function setStatus($status)
    {
        $this->status = $status;
    }

    // Returns post content.
    public function getContent()
    {
        return $this->content;
    }

    // Sets post content.
    public function setContent($content)
    {
        $this->content = $content;
    }

    // Returns the date when this post was created.
    public function getDateCreated()
    {
        return $this->dateCreated;
    }

    // Sets the date when this post was created.
    public function setDateCreated($dateCreated)
    {
        $this->dateCreated = $dateCreated;
    }

    /**
     * @ORM\OneToMany(targetEntity="\Blog\Entity\Comment", mappedBy="post")
     * @ORM\JoinColumn(name="id", referencedColumnName="post_id")
     */
    protected $comments;

    /**
     * Returns comments for this post.
     * @return ArrayCollection
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * Adds a new comment to this post.
     * @param $comment
     */
    public function addComment($comment)
    {
        $this->comments[] = $comment;
    }

    /**
     * @ORM\ManyToMany(targetEntity="\Blog\Entity\Tag", inversedBy="posts")
     * @ORM\JoinTable(name="post_tag",
     *      joinColumns={@ORM\JoinColumn(name="post_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="tag_id", referencedColumnName="id")}
     *      )
     */
    protected $tags;

    /**
     * Returns tags for this post.
     * @return ArrayCollection
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * Adds a new tag to this post.
     * @param $tag
     */
    public function addTag($tag)
    {
        $this->tags[] = $tag;
    }

    /**
     * Removes association between this post and the given tag.
     * @param $tag
     */
    public function removeTagAssociation($tag)
    {
        $this->tags->removeElement($tag);
    }
}