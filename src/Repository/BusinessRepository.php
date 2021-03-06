<?php

namespace App\Repository;

use App\Entity\Business;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Business|null find($id, $lockMode = null, $lockVersion = null)
 * @method Business|null findOneBy(array $criteria, array $orderBy = null)
 * @method Business[]    findAll()
 * @method Business[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BusinessRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Business::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Business $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(Business $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }/*
    public function findBusinessByName(string $query)
    {
        $qb = $this->createQueryBuilder('b');
        $qb
            ->where(
                $qb->expr()->andX(
                    $qb->expr()->orX(
                        $qb->expr()->like('b.titre', ':query'),
                       // $qb->expr()->like('b.idbusiness.idbusinessservices.nomservice', ':query'),
                     )

                )
            )
            ->setParameter('query', '%' . $query . '%')
        ;
        return $qb
            ->getQuery()
            ->getResult();
    }*/
    public function findBusinessByName(string $query)
    {
        $qb = $this->createQueryBuilder('b');

        $qb->leftJoin('App\Entity\BusinessServices', 'bs', 'WITH', 'b.idbusiness = bs.idbusiness')

            ->where(
                $qb->expr()->andX(
                    $qb->expr()->orX(

                        $qb->expr()->like('b.titre', ':query'),
                        $qb->expr()->like('b.ville', ':query'),
                        $qb->expr()->like('bs.nomservice', ':query'),
                    )

                )
            )
            ->setParameter('query', '%' . $query . '%')
        ;
        return $qb
            ->getQuery()
            ->getResult();
    }

    public function findBusinessWithRating(string $type){
        $entityManager=$this->getEntityManager();
        $query= $entityManager
            ->createQuery("select b.idbusiness,b.titre,b.description,b.horaire,b.ville,b.experience,b.image,b.lat,b.lng,(select avg(r.nbetoiles) from App\Entity\Revue r where r.idbusiness=b.idbusiness) as nb from App\Entity\Business b where b.type=:type")
            ->setParameter('type', $type);
        return $query->getResult();
    }

    public function getBusinessWithType($filters=null){

        $query = $this->createQueryBuilder('b');
        if($filters!=null){
            $query->where('b.type IN(:types)')
                ->setParameter(':types', array_values($filters));
        }else{
            $query->where('b.type IN(:types)')
                ->setParameter(':types', array('vet','grooming','dogsitting','park'));
        }

        return $query->getQuery()->getResult();

    }
    // /**
    //  * @return Business[] Returns an array of Business objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Business
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
