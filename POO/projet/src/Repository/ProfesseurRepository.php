<?php

namespace App\Repository;


use App\Entity\Professeur;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Professeur>
 *
 * @method Professeur|null find($id, $lockMode = null, $lockVersion = null)
 * @method Professeur|null findOneBy(array $criteria, array $orderBy = null)
 * @method Professeur[]    findAll()
 * @method Professeur[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProfesseurRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Professeur::class);
    }
    

//    /**
//     * @return Professeur[] Returns an array of Professeur objects
//     */

    public function prepareQueryForpagination(array $filtre){
        $query = $this->createQueryBuilder('p')
        ->andWhere('p.isArchived =false');

        if (!empty($filtre['classe'])) {
            $query = $query->leftJoin('p.classes','c')
            ->andWhere('c.id =:idClasse')
            ->setParameter('idClasse', $filtre['classe']);
           
        }

        if (!empty($filtre['module'])) {
            $query = $query->leftJoin('p.modules','m')
            ->andWhere('m.id =:idModule')
            ->setParameter('idModule', $filtre['module']);
        }
        return $query;
    }

    public function getGrades(){
        $results = $this->createQueryBuilder('p')
        ->select('DISTINCT p.grade ')
        ->getQuery()
        ->getScalarResult();
        $grades = [];
        // dd($results);
        foreach($results as $grade){
            $grades[$grade['grade']] = $grade['grade'];
        }
        return $grades;
    }

    // /**
    // * @return Professeur[] Returns an array of Professeur objects
    // */
    // public function findPaginateByFiltre(array $filtre): array {

    //     $query = $this->prepareQueryForpagination($filtre);
        
    //     $offset = ($page-1)*$nbrElt;
    //    return  $query
    //    ->setFirstResult($offset)
    //    ->setMaxResults($nbrElt)
    //    ->getQuery()
    //    ->getResult();
    // }

    // public function countProfesseurByFiltre( array $filtre){
    //     $query =$this->prepareQueryForpagination($filtre);
    //     return $query
    //     ->select('count(p.id) as count')
    //     ->getQuery()
    //     ->getSingleScalarResult();
 
    // }

    // public function countProfesseur() { 
    //     return $this->createQueryBuilder('p')
    //        ->select('count(p.id) as count')
    //        ->andWhere('p.isArchived =false')
    //        ->getQuery()
    //        ->getSingleScalarResult()
    //    ;
    // }


//    public function findOneBySomeField($value): ?Professeur
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
