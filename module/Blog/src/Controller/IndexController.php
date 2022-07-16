<?php

namespace Blog\Controller;

use Blog\Entity\Post;
use Doctrine\ORM\EntityManager;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;

class IndexController extends AbstractActionController
{
    /**
     * Entity manager.
     * @var EntityManager
     */
    private $entityManager;

    // Constructor method is used to inject dependencies to the controller.
    public function __construct($entityManager)
    {
        $this->entityManager = $entityManager;
    }

    // This is the default "index" action of the controller. It displays the
    // Posts page containing the recent blog posts.
    public function indexAction()
    {
        // Get recent posts
        $posts = $this->entityManager->getRepository(Post::class)
            ->findBy(['status'=>Post::STATUS_PUBLISHED],
                ['dateCreated'=>'DESC']);

        // Render the view template
        return new ViewModel([
            'posts' => $posts
        ]);
    }
}