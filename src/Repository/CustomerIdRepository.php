<?php

namespace App\Repository;

use App\Entity\CustomerId;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method CustomerId|null find($id, $lockMode = null, $lockVersion = null)
 * @method CustomerId|null findOneBy(array $criteria, array $orderBy = null)
 * @method CustomerId[]    findAll()
 * @method CustomerId[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CustomerIdRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, CustomerId::class);
    }

}
