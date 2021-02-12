<?php

namespace App\Repository;

use App\DTO\AdresseDTO;
use App\Entity\Adresse;
use App\DTO\PraticienDTO;
use App\Entity\Praticien;
use App\Service\ServicePraticien;
use App\Repository\AdresseRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\DBAL\Exception\DriverException;
use App\Service\Exception\PraticienServiceException;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @method Praticien|null find($id, $lockMode = null, $lockVersion = null)
 * @method Praticien|null findOneBy(array $criteria, array $orderBy = null)
 * @method Praticien[]    findAll()
 * @method Praticien[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PraticienRepository extends ServiceEntityRepository
{
    // private $praticienRepository;
    // private $servicePraticien;
    private $adresseRepository;
    private $em;

    public function __construct(EntityManagerInterface $em, ManagerRegistry $registry, AdresseRepository $adresseRepository)
    {
        parent::__construct($registry, Praticien::class);
        // $this->praticienRepository = $praticienRepository;, PraticienRepository $praticienRepository
        // $this->servicePraticien = $servicePraticien;, ServicePraticien $servicePraticien
        $this->adresseRepository = $adresseRepository;
        $this->em = $em;
    }

    // public function findByAdresse(int $idAdresse)
    // {
    //     return $this->createQueryBuilder('p')
    //         ->andWhere('p.adresse = :val')
    //         ->setParameter('val', $idAdresse)
    //         ->orderBy('p.id', 'ASC')
    //         ->setMaxResults(10)
    //         ->getQuery()
    //         ->getResult()
    //     ;
    // }

    public function findPraticiensByVille(string $ville)
    {
        $users = $this->em
        ->createQuery("SELECT p FROM App\Entity\Praticien p JOIN p.adresse a WHERE a.ville = :ville")
        ->setParameter('ville', $ville)
        ->getResult();
                    
        return $users;
        //$praticiens = $this->manager->createQuery('SELECT p FROM App\DTO\PraticienDTO p')->getResult();
        //$adresses = $this->registry->createQuery('SELECT a FROM App\DTO\AdresseDTO a')->getResult();
        //$idAdresse = $this->adresseRepository->findOneBy($ville)->getId();
        //$adresse = $this->adresseRepository->findByVille($ville);
        // $query = $this->createQueryBuilder('p')
        //     ->select('p as praticien')
        //     ->join('p.adresse_id', 'a')
        //     ->andWhere('a.ville LIKE :val')
        //     ->setParameter('val', $ville)
        //     ->orderBy('p.specialite', 'ASC')
        //     ->setMaxResults(20)
        //     ->getQuery()
        //     ->getResult()
        // ;
        // return $query[0];

        // /**
        //  * @return Docteur[] Returns an array of Docteur objects
        //  */
        // function findByExampleField($value)
        // {
        //     return $this->createQueryBuilder('d')
        //         ->andWhere('d.exampleField = :val')
        //         ->setParameter('val', $value)
        //         ->orderBy('d.id', 'ASC')
        //         ->setMaxResults(10)
        //         ->getQuery()
        //         ->getResult()
        //     ;
        // }

        // try{
        //     $adresse = $this->adresseRepository->findOneBy(["ville" => $ville]);
        //     $praticiens = $this->servicePraticien->searchAll();
        //     foreach($praticiens as $praticien){
        //         $doc=$this->praticienRepository->find($praticien->getId());
        //         $docs[]= $this->praticienMapper->transformePraticienEntityToPraticienDto($doc);
        //      }
        //     return $docs ;
        // }catch(DriverException $e){
        //     throw new PraticienServiceException("un pb technique est arrivé");
        // }

    
        // $entityManager = $this->getEntityManager();
        // $query = $entityManager->createQuery("SELECT p FROM praticien p JOIN p.adresse a WHERE a.ville = :ville");
        // $query->setParameter('ville', $ville);
        // $praticiens = $query->getResult();
        // return $praticiens;

        // return $this->createQueryBuilder('p')
        //             ->select('p as praticien')
        //             ->join('adresse', 'a')
        //             ->groupBy('p')
        //             ->orderBy('p', 'DESC')
        //             ->getQuery()
        //             ->getResult();
    }
}
