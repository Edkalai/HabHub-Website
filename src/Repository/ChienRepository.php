<?php

namespace App\Repository;

use App\Entity\Chien;
use App\Entity\Individu;
use App\Entity\Likes    ;
use App\Entity\Utilisateur;
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

    public function myDogs(int $id){
        $entityManager=$this->getEntityManager();


        $query= $entityManager
            ->createQuery("SELECT c.image,c.sexe,c.nom,c.age,c.idchien,(SELECT count(l) FROM App\Entity\Likes l where l.idchien=c.idchien) as nb,(SELECT count(a) FROM App\Entity\AnnonceProprietaireChien a where a.idchien=c.idchien and a.type='P') as missing,(SELECT count(am) FROM App\Entity\AnnonceProprietaireChien am where am.idchien=c.idchien and am.type='A') as mating FROM App\Entity\Chien c JOIN c.idindividu i join i.idutilisateur u where c.idindividu=:userid Order by nb desc")
            ->setParameters(array('userid'=>$id));
        return $query->getResult();
    }
    public function myDogsMobile(int $loggedin){
        $entityManager=$this->getEntityManager();
        $query= $entityManager
            ->createQuery("SELECT c.image,c.sexe,c.nom,c.age,c.idchien,(SELECT count(l) FROM App\Entity\Likes l where l.idchien=c.idchien) as nb,(SELECT count(a) FROM App\Entity\AnnonceProprietaireChien a where a.idchien=c.idchien and a.type='P') as missing,(SELECT count(am) FROM App\Entity\AnnonceProprietaireChien am where am.idchien=c.idchien and am.type='A') as mating FROM App\Entity\Chien c JOIN c.idindividu i join i.idutilisateur u where c.idindividu=:userid Order by nb desc")
            ->setParameters(array('userid'=>$loggedin));
        return $query->getResult();
    }


    public function findDogsNextDoor(int $id,string $adresse){
        $entityManager=$this->getEntityManager();
        $query= $entityManager
                ->createQuery("SELECT c.image,c.sexe,c.nom,c.age,c.idchien,c.playwithme,(SELECT count(l) FROM App\Entity\Likes l where l.idchien=c.idchien and l.idindividu=:userid) as liked FROM APP\Entity\Chien c JOIN c.idindividu i join i.idutilisateur u where i.adresse= :userlocation and c.idindividu!= :userid")
                ->setParameters(array('userlocation'=>$adresse,'userid'=>$id));
        return $query->getResult();
    }

    public function findDogsNextDoorMobile(int $loggedin){
        $entityManager=$this->getEntityManager();
        $query= $entityManager
            ->createQuery("SELECT c.image,c.sexe,c.nom,c.age,c.idchien,c.playwithme,(SELECT count(l) FROM App\Entity\Likes l where l.idchien=c.idchien and l.idindividu=:userid) as liked FROM APP\Entity\Chien c JOIN c.idindividu i join i.idutilisateur u where i.adresse= :userlocation and c.idindividu!= :userid")
            ->setParameters(array('userlocation'=>'Borj Louzir','userid'=>$loggedin));
        return $query->getResult();
    }

    public function searchFilterDogsNextDoor($filters=null,$search=null,int $id,string $adresse)
    {
        $entityManager=$this->getEntityManager();

        if ( ($filters!=null) && ($search!=null))
        {
            $query= $entityManager
                ->createQuery("SELECT c.image,c.sexe,c.nom,c.age,c.idchien,c.playwithme,(SELECT count(l) FROM App\Entity\Likes l where l.idchien=c.idchien and l.idindividu=:userid) as liked FROM APP\Entity\Chien c JOIN c.idindividu i join i.idutilisateur u where i.adresse= :userlocation and c.idindividu!= :userid and (c.nom LIKE :search or c.race LIKE :search or i.nom LIKE :search) and c.sexe IN(:genders)")
                ->setParameters(array('userlocation'=>$adresse,'userid'=>$id,'genders'=> array_values($filters),'search'=> $search.'%'));
        }
        elseif ($filters!=null){
            $query= $entityManager
                ->createQuery("SELECT c.image,c.sexe,c.nom,c.age,c.idchien,c.playwithme,(SELECT count(l) FROM App\Entity\Likes l where l.idchien=c.idchien and l.idindividu=:userid) as liked FROM APP\Entity\Chien c JOIN c.idindividu i join i.idutilisateur u where i.adresse= :userlocation and c.idindividu!= :userid and c.sexe IN(:genders)")
                ->setParameters(array('userlocation'=>$adresse,'userid'=>$id,'genders'=> array_values($filters)));
        }
       elseif ($search!=null){
            $query= $entityManager
                ->createQuery("SELECT c.image,c.sexe,c.nom,c.age,c.idchien,c.playwithme,(SELECT count(l) FROM App\Entity\Likes l where l.idchien=c.idchien and l.idindividu=:userid) as liked FROM APP\Entity\Chien c JOIN c.idindividu i join i.idutilisateur u where i.adresse= :userlocation and c.idindividu!= :userid and (c.nom LIKE :search or c.race LIKE :search or i.nom LIKE :search)")
                ->setParameters(array('userlocation'=>$adresse,'userid'=>$id,'search'=> $search.'%'));

       }
        else {
            $query= $entityManager
                ->createQuery("SELECT c.image,c.sexe,c.nom,c.age,c.idchien,c.playwithme,(SELECT count(l) FROM App\Entity\Likes l where l.idchien=c.idchien and l.idindividu=:userid) as liked FROM APP\Entity\Chien c JOIN c.idindividu i join i.idutilisateur u where i.adresse= :userlocation and c.idindividu!= :userid")
                ->setParameters(array('userlocation'=>$adresse,'userid'=>$id));
        }

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
