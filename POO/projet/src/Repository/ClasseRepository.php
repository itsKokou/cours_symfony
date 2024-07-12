<?php

namespace App\Repository;

use App\Entity\Classe;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Classe>
 *
 * @method Classe|null find($id, $lockMode = null, $lockVersion = null)
 * @method Classe|null findOneBy(array $criteria, array $orderBy = null)
 * @method Classe[]    findAll()
 * @method Classe[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ClasseRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Classe::class);
    }

    public function prepareQueryForpagination(array $filtre){
        $query = $this->createQueryBuilder('c')
        ->andWhere('c.isArchived =false');

        if (!empty($filtre['filiere'])) {
            $query = $query->leftJoin('c.filiere','f')
            ->andWhere('f.id =:idF')
            ->setParameter('idF', $filtre['filiere']);
           
        }

        if (!empty($filtre['niveau'])) {
            $query = $query->leftJoin('c.niveau','n')
            ->andWhere('n.id =:idN')
            ->setParameter('idN', $filtre['niveau']);
        }
        return $query;
    }

    public function findPaginateByFiltre($page,$nbrElt,array $filtre): array {

        $query = $this->prepareQueryForpagination($filtre);
        
        $offset = ($page-1)*$nbrElt;
       return  $query
       ->setFirstResult($offset)
       ->setMaxResults($nbrElt)
       ->getQuery()
       ->getResult();
    }

    public function countClasseByFiltre( array $filtre){
        $query =$this->prepareQueryForpagination($filtre);
        
        return $query
        ->select('count(c.id) as count')
        ->getQuery()
        ->getSingleScalarResult();
 
    }


//    /**
//     * @return Classe[] Returns an array of Classe objects
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

//    public function findOneBySomeField($value): ?Classe
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
