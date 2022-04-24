<?php

namespace App\Repository;

use App\Entity\Chien;
use App\Entity\Likes    ;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Chien|null find($id, $lockMode = null, $lockVersion = null)
 * @method Chien|null findOneBy(array $criteria, array $orderBy = null)
 * @method Chien[]    findAll()
 * @method Chien[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ChienRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Chien::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Chien $entity, bool $flush = true): void
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
    public function remove(Chien $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    public function findDogsNextDoor(){
        $entityManager=$this->getEntityManager();
        $query= $entityManager
                ->createQuery("SELECT c.image,c.sexe,c.nom,c.age,c.idchien,c.playwithme,(SELECT count(l) FROM App\Entity\Likes l where l.idchien=c.idchien and l.idindividu=:userid) as liked FROM APP\Entity\Chien c JOIN c.idindividu i join i.idutilisateur u where i.adresse= :userlocation and c.idindividu!= :userid")
                ->setParameters(array('userlocation'=>'Borj Louzir','userid'=>'2'));
        return $query->getResult();
    }

    public function myDogs(){
        $entityManager=$this->getEntityManager();
        $query= $entityManager
            ->createQuery("SELECT c.image,c.sexe,c.nom,c.age,c.idchien,(SELECT count(l) FROM App\Entity\Likes l where l.idchien=c.idchien) as nb FROM App\Entity\Chien c JOIN c.idindividu i join i.idutilisateur u where c.idindividu=:userid Order by nb desc")
            ->setParameters(array('userid'=>'2'));
        return $query->getResult();
    }


    // /**
    //  * @return Chien[] Returns an array of Chien objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Chien
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
