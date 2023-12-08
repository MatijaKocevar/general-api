<?php

namespace App\Repository;

use App\Entity\Task;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class TaskRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Task::class);
    }

    public function findByDescriptionStartsWith($searchTerm)
    {
        $queryBuilder = $this->createQueryBuilder('t');
        $queryBuilder->where('t.description LIKE :searchTerm')
            ->setParameter('searchTerm', $searchTerm . '%');

        return $queryBuilder->getQuery()->getResult();
    }
}
