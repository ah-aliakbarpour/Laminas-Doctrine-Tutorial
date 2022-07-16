<?php

namespace Blog\Controller;

use Blog\Form\PostForm;
use Blog\Service\PostManager;
use Doctrine\ORM\EntityManager;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;

class PostController extends AbstractActionController
{
    /**
     * Entity manager.
     * @var EntityManager
     */
    private $entityManager;

    /**
     * Post manager.
     * @var PostManager
     */
    private $postManager;

    /**
     * Constructor is used for injecting dependencies into the controller.
     */
    public function __construct($entityManager, $postManager)
    {
        $this->entityManager = $entityManager;
        $this->postManager = $postManager;
    }

    /**
     * This action displays the "New Post" page. The page contains
     * a form allowing to enter post title, content and tags. When
     * the user clicks the Submit button, a new Post entity will
     * be created.
     */
    public function addAction()
    {
        // Create the form.
        $form = new PostForm();

        // Check whether this post is a POST request.
        if ($this->getRequest()->isPost()) {

            // Get POST data.
            $data = $this->params()->fromPost();

            // Fill form with data.
            $form->setData($data);
            if ($form->isValid()) {

                // Get validated form data.
                $data = $form->getData();

                // Use post manager service to add new post to database.
                $this->postManager->addNewPost($data);

                // Redirect the user to "blog/index" page.
                return $this->redirect()->toRoute('blog');
            }
        }

        // Render the view template.
        return new ViewModel([
            'form' => $form
        ]);
    }
}