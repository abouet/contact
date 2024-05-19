<?php

namespace ScoRugby\Core\Repository;

use ScoRugby\Core\Entity\Traitement;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @extends ServiceEntityRepository<traitement>
 *
 * @method Traitement|null find($id, $lockMode = null, $lockVersion = null)
 * @method Traitement|null findOneBy(array $criteria, array $orderBy = null)
 * @method Traitement[]    findAll()
 * @method Traitement[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TraitementRepository extends ServiceEntityRepository {

    public function __construct(ManagerRegistry $registry) {
        parent::__construct($registry, Traitement::class);
    }

    public function getEntityManager(): EntityManagerInterface {
        return $this->getEntityManager();
    }

    public function save(Traitement $entity, bool $flush = true): void {
        $this->getEntityManager('traitement')->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Traitement $entity, bool $flush = false): void {
        $this->getEntityManager('traitement')->remove($entity);

        if ($flush) {
            $this->getEntityManager('traitement')->flush();
        }
    }

    public function findDernierTraitement(string $traitement): ?Traitement {
        return $this->createQueryBuilder('t')
                        ->andWhere('t.traitement = :traitement')
                        ->andWhere('t.debut = (SELECT max(t2.debut) FROM public.traitement t2)')
                        ->setParameter('traitement', $traitement)
                        ->getQuery()
                        ->getOneOrNullResult()
        ;
    }

//    /**
//     * @return Traitement[] Returns an array of Traitement objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }
}
