<?php

namespace ScoRugby\Contact\Repository;

use ScoRugby\Contact\Entity\Contact;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Contact>
 *
 * @method Contact|null find($id, $lockMode = null, $lockVersion = null)
 * @method Contact|null findOneBy(array $criteria, array $orderBy = null)
 * @method Contact[]    findAll()
 * @method Contact[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ContactRepository extends ServiceEntityRepository implements ImportableRepositoryInferface {

    public function __construct(ManagerRegistry $registry) {
        parent::__construct($registry, Contact::class);
    }

    public function save(Contact $entity, bool $flush = false): void {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Contact $entity, bool $flush = false): void {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @return Contact[] Returns an array of Contact objects
     */
    public function findAllForSearch(): array {
        return $this->getEntityManager()
                        ->createQuery(
                                'SELECT c, UPPER(c.nom) canonized_nom, UPPER(c.prenom) canonized_prenom FROM ScoRugby\Contact\Entity\Contact c order by c.nom ASC, c.prenom ASC'
                        )
                        ->getScalarResult();
    }

    protected function findContactByDoB(string $nom, string $prenom, \DateTimeInterface $dob): ?Contact {
        return $this->getEntityManager()
                        ->createQuery("SELECT c FROM App\Entity\Affilie\Affilie a JOIN a.contact c  WHERE a.date_naissance = :dob and canonized_nom=:nom and canonized_prenom=:prenom")
                        ->setParameter('nom', $nom)
                        ->setParameter('prenom', $prenom)
                        ->setParameter('dob', $dob)
                        ->getQuery()
                        ->getSingleResult();
    }

    protected function findContactByEmail(string $email): ?Contact {
        return $this->getEntityManager()
                        ->createQuery("SELECT c FROM ScoRugby\Contact\Entity\ContactEmail e JOIN e.contact c WHERE e.email = :email")
                        ->setParameter('email', $email)
                        ->getQuery()
                        ->getSingleResult();
    }

    protected function findContactByPhone(string $phone): ?Contact {
        return $this->getEntityManager()
                        ->createQuery("SELECT c FROM ScoRugby\Contact\Entity\ContactTelephone p JOIN p.contact c WHERE p.numero = :phone")
                        ->setParameter('phone', $phone)
                        ->getQuery()
                        ->getSingleResult();
    }

    public function findByExternalId(string $externalId): ?ImportableInterface {
        return $this->findBy(['externalId' => $externalId]);
    }

    public function findByAppliMaitre(string $appliMaitre): array {
        return $this->findBy(['appliMaitre' => $appliMaitre]);
    }

    public function findByImportedDate(\DateTimeInterface $date): array {
        return $this->findBy(['importedAt' => $date]);
    }
}
