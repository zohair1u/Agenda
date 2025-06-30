<?php

namespace App\Repository;

use App\Entity\Contact;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Contact>
 */
class ContactRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Contact::class);
    }

    //    /**
    //     * @return Contact[] Returns an array of Contact objects
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

    //    public function findOneBySomeField($value): ?Contact
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }

    public function findByAge(int $param): array
    {   
        // p représente la table Product en base; c'est un alias
        // On commence par se connecter à la table Product
        $qb = $this->createQueryBuilder('c') 
        // On selectionne tous les éléments dans la colonne "price" là où les valeurs sont supérieures à :priceParam
            ->where('c.age > :ageParam')
        // On définit ce qu'est :priceParam
        // Il s'agit de la variable $param (qui est récupéré depuis les parenthèses de la méthode juste au dessus)
            ->setParameter('ageParam', $param)
        // on organise la colonne "price" par ordre ASC (croissant, du plus petit au plus grand)
            ->orderBy('c.age', 'ASC');

        // On execute la requete
        $query = $qb->getQuery();

        return $query->execute();

    }
    
}
