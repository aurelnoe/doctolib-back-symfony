<?php

namespace App\Repository;

use App\Entity\RendezVous;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method RendezVous|null find($id, $lockMode = null, $lockVersion = null)
 * @method RendezVous|null findOneBy(array $criteria, array $orderBy = null)
 * @method RendezVous[]    findAll()
 * @method RendezVous[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RendezVousRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RendezVous::class);
    }

    // public function findRendezVousByPraticien()
    // {
    //     $allRendezVous = $this->registry->createQuery('SELECT COUNT(r) FROM App\DTO\RendezVousDTO r')->getSingleScalarResult();
    //     foreach($allRendezVous as $rdv){
    //             $doc=$this->praticienRepository->findBy('idRdv' => $rdv->getId());
    //             $docs[]= $this->praticienMapper->transformePraticienEntityToPraticienDto($doc);
    //         }
        
    //     //$praticiens = $this->registry->createQuery('SELECT COUNT(p) FROM App\DTO\PraticienDTO p')->getSingleScalarResult();
    //     //return $NbreRdv;
    // }

    // /**
    //  * @return RendezVous[] Returns an array of RendezVous objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?RendezVous
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
