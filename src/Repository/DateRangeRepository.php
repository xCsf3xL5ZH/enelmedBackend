<?php

namespace App\Repository;

use App\Entity\DateRange;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method DateRange|null find($id, $lockMode = null, $lockVersion = null)
 * @method DateRange|null findOneBy(array $criteria, array $orderBy = null)
 * @method DateRange[]    findAll()
 * @method DateRange[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DateRangeRepository extends ServiceEntityRepository
{

    private $em;

    public function __construct(RegistryInterface $registry, EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
        parent::__construct($registry, DateRange::class);
    }

    public function save(DateRange $dateRange)
    {
        $this->em->persist($dateRange);

        $this->em->flush();
    }

    public function refreshEntity(DateRange $dateRange)
    {
        $this->em->refresh($dateRange);

        return $dateRange;
    }
}
