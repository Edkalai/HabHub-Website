<?php

namespace App\Repository;

use App\Entity\Message;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Messages|null find($id, $lockMode = null, $lockVersion = null)
 * @method Messages|null findOneBy(array $criteria, array $orderBy = null)
 * @method Messages[]    findAll()
 * @method Messages[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MessageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Message::class);
    }


    public function countSentMessages(int $sender){
        $entityManager=$this->getEntityManager();
        $query= $entityManager
            ->createQuery("SELECT count(m) FROM App\Entity\Message m join m.sender u where u.idutilisateur=:sender")
            ->setParameters('sender',$sender);
        return $query->getSingleScalarResult();
    }

    public function sentMessages(int $id){
        $query = $this->createQueryBuilder('m')->
        Where( 'm.sender =:id')
                ->setParameter('id',$id );
        
        $query->orderBy('m.createdAt');
        
        
        return $query->getQuery()->getResult();
    }

    public function receivedMessages(int $id){
        $query = $this->createQueryBuilder('m')->
        Where( 'm.recipient =:id')
                ->setParameter('id',$id );
        
        $query->orderBy('m.createdAt');
        
        

        
        return $query->getQuery()->getResult();
    }
    

    public function countReceivedMessages($recepient){
        $entityManager=$this->getEntityManager();
        $query= $entityManager
            ->createQuery("SELECT count(m) FROM App\Entity\Message m where m.recepient=:recepient")
            ->setParameters('recepient',$recepient);
        return $query->getSingleScalarResult();
    }


    // /**
    //  * @return Messages[] Returns an array of Message objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Message
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}