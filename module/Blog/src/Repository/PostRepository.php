<?php

namespace Blog\Repository;

use Blog\Entity\Post;
use Doctrine\ORM\EntityRepository;

class PostRepository extends EntityRepository
{
    // Finds all published posts having any tag.
    public function findPostsHavingAnyTag()
    {
        $entityManager = $this->getEntityManager();

        $queryBuilder = $entityManager->createQueryBuilder();

        $queryBuilder->select('p')
            ->from(Post::class, 'p')
            ->join('p.tags', 't')
            ->where('p.status = ?1')
            ->orderBy('p.dateCreated', 'DESC')
            ->setParameter('1', Post::STATUS_PUBLISHED);

        $posts = $queryBuilder->getQuery()->getResult();

        return $posts;
    }

    // Finds all published posts having the given tag.
    public function findPostsByTag($tagName)
    {
        $entityManager = $this->getEntityManager();

        $queryBuilder = $entityManager->createQueryBuilder();

        $queryBuilder->select('p')
            ->from(Post::class, 'p')
            ->join('p.tags', 't')
            ->where('p.status = ?1')
            ->andWhere('t.name = ?2')
            ->orderBy('p.dateCreated', 'DESC')
            ->setParameter('1', Post::STATUS_PUBLISHED)
            ->setParameter('2', $tagName);

        return $queryBuilder->getQuery();
    }

    public function findPublishedPosts()
    {
        $entityManager = $this->getEntityManager();

        $queryBuilder = $entityManager->createQueryBuilder();

        $queryBuilder->select('p')
            ->from(Post::class, 'p')
            ->where('p.status = ?1')
            ->orderBy('p.dateCreated', 'DESC')
            ->setParameter('1', Post::STATUS_PUBLISHED);

        return $queryBuilder->getQuery();
    }
}