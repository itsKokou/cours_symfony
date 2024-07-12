<?php

namespace App\Repository;

use App\Entity\Secteur;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Secteur>
 *
 * @method Secteur|null find($id, $lockMode = null, $lockVersion = null)
 * @method Secteur|null findOneBy(array $criteria, array $orderBy = null)
 * @method Secteur[]    findAll()
 * @method Secteur[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SecteurRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Secteur::class);
    }

   /**
    * @return Secteur[] Returns an array of Secteur objects
    */
   public function findSecteursByDirectionAndAgent(array $filtre): array
   {
        $query = $this->createQueryBuilder('s');
       
        if(!empty($filtre["direction"])){
            $query ->leftJoin('s.direction','d')
            ->andWhere('d.id = :idD')
            ->setParameter('idD',$filtre["direction"]);
        }

        if(!empty($filtre["agent"])){
            $query ->leftJoin('s.agents','a')
            ->andWhere('a.id = :idA')
            ->setParameter('idA',$filtre["agent"]);
        }

        return $query->getQuery()->getResult();
   }

//    public function findOneBySomeField($value): ?Secteur
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
