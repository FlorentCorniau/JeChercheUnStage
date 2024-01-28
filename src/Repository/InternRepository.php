<?php

namespace App\Repository;

use App\Entity\Industry;
use App\Entity\Intern;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Intern>
 *
 * @method Intern|null find($id, $lockMode = null, $lockVersion = null)
 * @method Intern|null findOneBy(array $criteria, array $orderBy = null)
 * @method Intern[]    findAll()
 * @method Intern[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InternRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Intern::class);
    }

    /**
     * Méthode DQL qui prends en paramètres un Objet Industry et qui renvoie les Interns lié à l'Industry
     */
    public function findInternsByIndustry(Industry $industries): array
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
        return $this->createQueryBuilder('i')
            ->orderBy('i.id', 'ASC')
            ->getQuery()
        ;
    }

    /**
    * Retourne une query de Doctrine
    */
    public function paginationQueryByIndustry(Industry $industries)
    {
        return $this->createQueryBuilder('i')
            ->select('i')
            ->join('i.industries', 'ind')
            ->andWhere('ind IN (:industries)')
            ->setParameter('industries', $industries)
            ->getQuery()
        ;
    }

//    /**
//     * @return Intern[] Returns an array of Intern objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('i')
//            ->andWhere('i.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('i.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Intern
//    {
//        return $this->createQueryBuilder('i')
//            ->andWhere('i.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
