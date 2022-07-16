<?php

namespace Blog\Controller\Factory;

use Blog\Controller\PostController;
use Blog\Service\PostManager;
use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;

class PostControllerFactory implements FactoryInterface
{

    /**
     * @inheritDoc
     */
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        $entityManager = $container->get('doctrine.entitymanager.orm_default');
        $postManager = $container->get(PostManager::class);

        // Instantiate the controller and inject dependencies
        return new PostController($entityManager, $postManager);
    }
}