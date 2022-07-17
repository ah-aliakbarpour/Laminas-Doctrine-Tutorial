<?php

namespace Blog\Controller;

use Blog\Entity\Post;
use Blog\Form\CommentForm;
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
     * This is the default "index" action of the controller. It displays the
     * Posts page containing the recent blog posts.
     */
    public function indexAction()
    {
        $tagFilter = $this->params()->fromQuery('tag', null);

        if ($tagFilter) {

            // Filter posts by tag
            $posts = $this->entityManager->getRepository(Post::class)
                ->findPostsByTag($tagFilter);

        } else {
            // Get recent posts
            $posts = $this->entityManager->getRepository(Post::class)
                ->findBy(['status'=>Post::STATUS_PUBLISHED],
                    ['dateCreated'=>'DESC']);
        }

        // Get popular tags.
        $tagCloud = $this->postManager->getTagCloud();

        // Render the view template.
        return new ViewModel([
            'posts' => $posts,
            'postManager' => $this->postManager,
            'tagCloud' => $tagCloud
        ]);
    }

    /**
     * This action displays the "View Post" page allowing to see the post title
     * and content. The page also contains a form allowing
     * to add a comment to post.
     */
    public function viewAction()
    {
        $postId = $this->params()->fromRoute('id', -1);

        $post = $this->entityManager->getRepository(Post::class)
            ->findOneById($postId);

        if ($post == null) {
            $this->getResponse()->setStatusCode(404);
            return;
        }

        // Create the form.
        $form = new CommentForm();

        // Check whether this post is a POST request.
        if($this->getRequest()->isPost()) {

            // Get POST data.
            $data = $this->params()->fromPost();

            // Fill form with data.
            $form->setData($data);
            if($form->isValid()) {

                // Get validated form data.
                $data = $form->getData();

                // Use post manager service to add new comment to post.
                $this->postManager->addCommentToPost($post, $data);

                // Redirect the user to current page.
                return $this->redirect()->refresh();
            }
        }

        // Render the view template.
        return new ViewModel([
            'post' => $post,
            'form' => $form,
            'postManager' => $this->postManager
        ]);
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

                // Redirect the user to posts list page.
                return $this->redirect()->toRoute('post');
            }
        }

        // Render the view template.
        return new ViewModel([
            'form' => $form
        ]);
    }

    // This action displays the page allowing to edit a post.
    public function editAction()
    {
        // Create the form.
        $form = new PostForm();

        // Get post ID.
        $postId = $this->params()->fromRoute('id', -1);

        // Find existing post in the database.
        $post = $this->entityManager->getRepository(Post::class)
            ->findOneById($postId);
        if ($post == null) {
            $this->getResponse()->setStatusCode(404);
            return;
        }

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
                $this->postManager->updatePost($post, $data);

                // Redirect the user to posts list page.
                return $this->redirect()->toRoute('post');
            }
        } else {
            $data = [
                'title' => $post->getTitle(),
                'content' => $post->getContent(),
                'tags' => $this->postManager->convertTagsToString($post),
                'status' => $post->getStatus()
            ];

            $form->setData($data);
        }

        // Render the view template.
        return new ViewModel([
            'form' => $form,
            'post' => $post
        ]);
    }

    // This "delete" action Delete the Post.
    public function deleteAction()
    {
        $postId = $this->params()->fromRoute('id', -1);

        $post = $this->entityManager->getRepository(Post::class)
            ->findOneById($postId);
        if ($post == null) {
            $this->getResponse()->setStatusCode(404);
            return;
        }

        $this->postManager->removePost($post);

        // Redirect the user to posts list page.
        return $this->redirect()->toRoute('post');
    }

    /**
     * This "admin" action displays the Manage Posts page. This page contains
     * the list of posts with an ability to edit/delete any post.
     */
    public function adminAction()
    {
        // Get posts
        $posts = $this->entityManager->getRepository(Post::class)
            ->findBy([], ['dateCreated'=>'DESC']);

        // Render the view template
        return new ViewModel([
            'posts' => $posts,
            'postManager' => $this->postManager
        ]);
    }
}