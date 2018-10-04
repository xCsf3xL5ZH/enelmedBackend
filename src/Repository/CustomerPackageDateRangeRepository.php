<?php

namespace App\Repository;

use App\Entity\CustomerPackageDateRange;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method CustomerPackageDateRange|null find($id, $lockMode = null, $lockVersion = null)
 * @method CustomerPackageDateRange|null findOneBy(array $criteria, array $orderBy = null)
 * @method CustomerPackageDateRange[]    findAll()
 * @method CustomerPackageDateRange[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CustomerPackageDateRangeRepository extends ServiceEntityRepository
{
    private $em;

    public function __construct(RegistryInterface $registry, EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
        parent::__construct($registry, CustomerPackageDateRange::class);
    }

    public function save(CustomerPackageDateRange $customerPackageDateRange)
    {
        $this->em->persist($customerPackageDateRange);

        $this->em->flush();
    }

    public function findAllCustomersDistinct()
    {

        $qb = $this->em->createQueryBuilder();

        $result =  $qb
            ->select('(cpdr.customerId)')
            ->from('App:CustomerPackageDateRange', 'cpdr')
            ->groupBy('cpdr.customerId')
            ->getQuery()
            ->getArrayResult();

        if (empty($result)) {
            return array();
        }

        $dataToGet = array();

        foreach ($result as $key => $id) {
            array_push($dataToGet, $id[1]);
        }

        return $dataToGet;
    }


}
