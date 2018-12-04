<?php

namespace App\Repository;

use App\Entity\Video;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Video|null find($id, $lockMode = null, $lockVersion = null)
 * @method Video|null findOneBy(array $criteria, array $orderBy = null)
 * @method Video[]    findAll()
 * @method Video[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VideoRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Video::class);
    }

    // /**
    //  * @return Video[] Returns an array of Video objects
    //  */

    public function findBySearch($search)
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.name LIKE  :search')
            ->setParameter('search', '%' . $search . '%');
    }


    public function findBySearchAndType($search = null, $type)
    {
        if ($search) {
            $qb = $this->createQueryBuilder('v')
                ->andWhere('v.name LIKE  :search')
                ->setParameter('search', '%' . $search . '%')
                ->andWhere('v.type = :type')
                ->setParameter('type', $type);
        } else {
            $qb = $this->createQueryBuilder('v')
                ->andWhere('v.type = :type')
                ->setParameter('type', $type);
        }
            return $qb;
        }

    }
