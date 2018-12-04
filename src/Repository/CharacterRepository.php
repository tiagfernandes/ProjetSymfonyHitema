<?php

namespace App\Repository;

use App\Entity\Character;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Character|null find($id, $lockMode = null, $lockVersion = null)
 * @method Character|null findOneBy(array $criteria, array $orderBy = null)
 * @method Character[]    findAll()
 * @method Character[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CharacterRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Character::class);
    }

    public function findBySearch($search)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.firstname LIKE  :search')
            ->setParameter('search', '%' . $search . '%')
            ->orWhere('c.lastname LIKE  :search')
            ->setParameter('search', '%' . $search . '%');
    }

}
