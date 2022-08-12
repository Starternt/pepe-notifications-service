<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\System;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry as RegistryInterface;

/**
 * @method null|System find($id, $lockMode = null, $lockVersion = null)
 * @method null|System findOneBy(array $criteria, array $orderBy = null)
 * @method System[]    findAll()
 * @method System[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SystemRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, System::class);
    }
}
