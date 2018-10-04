<?php

namespace App\Repository;

use App\Entity\MedicalPackage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @method MedicalPackage|null find($id, $lockMode = null, $lockVersion = null)
 * @method MedicalPackage|null findOneBy(array $criteria, array $orderBy = null)
 * @method MedicalPackage[]    findAll()
 * @method MedicalPackage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MedicalPackageRepository extends ServiceEntityRepository
{
    private $em;

    public function __construct(RegistryInterface $registry, EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
        parent::__construct($registry, MedicalPackage::class);
    }


    public function getAllActive()
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.isActive = :isActive')
            ->setParameter('isActive', true)
            ->getQuery()
            ->getResult()
            ;
    }

    public function refreshEntity(MedicalPackage $dateRange)
    {
        $this->em->refresh($dateRange);

        return $dateRange;
    }

//    /**
//     * @return MedicalPackage[] Returns an array of MedicalPackage objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?MedicalPackage
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
