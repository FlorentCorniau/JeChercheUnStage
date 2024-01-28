<?php

namespace App\Repository;

use App\Entity\Company;
use App\Entity\Industry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Company>
 *
 * @method Company|null find($id, $lockMode = null, $lockVersion = null)
 * @method Company|null findOneBy(array $criteria, array $orderBy = null)
 * @method Company[]    findAll()
 * @method Company[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CompanyRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Company::class);
    }

    public function findCompanyBySiret(int $siret_number): array
    {
        // automatically knows to select Products
        // the "p" is an alias you'll use in the rest of the query
        $qb = $this->createQueryBuilder('c')
            ->where('c.siret_number = :siret')
            ->setParameter('siret', $siret_number);
            //->orderBy('p.price', 'ASC');

        $query = $qb->getQuery();

        return $query->execute();

        // to get just one result:
        // $product = $query->setMaxResults(1)->getOneOrNullResult();
    }

    /**
     * DQL method that takes an Industry Object as parameters and returns the companies linked to the Industry
     */
    public function findCompaniesByIndustry(Industry $industries): array
    {
        $qb = $this->createQueryBuilder('i')
            ->select('i')
            ->join('i.industries', 'ind')
            ->andWhere('ind IN (:industries)')
            ->setParameter('industries', $industries);

        return $qb->getQuery()->getResult();
    }

    /**
    * Retourne une query de Doctrine
    */
    public function paginationQueryAll()
    {
        return $this->createQueryBuilder('c')
            ->orderBy('c.id', 'ASC')
            ->getQuery()
        ;
    }

    /**
    * Retourne une query de Doctrine
    */
    public function paginationQueryByIndustry(Industry $industries)
    {
        return $this->createQueryBuilder('c')
            ->select('c')
            ->join('c.industries', 'ind')
            ->andWhere('ind IN (:industries)')
            ->setParameter('industries', $industries)
            ->getQuery()
        ;
    }

    /**
    * Returns a random movie
    */
   public function findRandomCompanyByThree()
   {
        return $this->createQueryBuilder('c')
            ->orderBy('RAND()')
            ->setMaxResults(3)
            ->getQuery()
            ->getResult()
           ;
    }


//    /**
//     * @return Company[] Returns an array of Company objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Company
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
