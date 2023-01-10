<?php

namespace App\Repository;

use App\Entity\Author;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Author>
 *
 * @method Author|null find($id, $lockMode = null, $lockVersion = null)
 * @method Author|null findOneBy(array $criteria, array $orderBy = null)
 * @method Author[]    findAll()
 * @method Author[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AuthorRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Author::class);
    }

    public function findAuthorByPrenom($prenom)
    {
        /*
        //requête en écriture DQL
        $entityManager = $this->getEntityManager();
        //$query = $entityManager->createQuery('SELECT a FROM App\Entity\Author a WHERE a.prenom = :prenom ');
        $query = $entityManager->createQuery('SELECT a, c FROM App\Entity\Author a LEFT JOIN a.country AS c WHERE a.prenom = :prenom ');
        $query = $entityManager->createQuery('SELECT a, c FROM App\Entity\Author a LEFT JOIN a.country AS c WITH a.prenom = :prenom ');
        //$query = $entityManager->createQuery('SELECT a FROM App\EntityAuthor a WHERE a.country INSTANCE OF App\Entity\Country ');
        //tester le délais entre deux dates ici 10 jours
        // DATE_DIFF(a.date_naissance, :datesoumise) > 10
        //tester qu'une valeur est une instance d'une entitité en particulier
        // a.country INSTANCE OF App\Entity\Country
        //tester qu'une valeur n'est pas une instance d'une entitité en particulier
        // a.country NOT INSTANCE OF App\Entity\Country
        $query->setParameter('prenom', $prenom);
        $result = $query->getResult();
        //$result = $query->getSingleResult(); //permet de récupérer un seul résultat
        //$result = $query->getOneOrNullResult(); //permet de récupérer le résultat sous forme d'objet et c'est impossible renvoie une exception
        //$result = $query->getArrayResult(); //permet de récupérer les résultats sous forme de tableau (array)
        //$result = $query->getScalarResult(); //permet de récupérer les résultats sous forme de tableau scalaire
        //$result = $query->getSingleScalarResult(); permet de récupérer les résultats sous une valeur scalaire unique, si jamais la requête trouve plus d'un résultat ou zéro résultat alors déclenche une exception 

        //approche requête SQL classique
        $entityManager = $this->getEntityManager();
        $query = $entityManager->createNativeQuery("SELECT * FROM author a WHERE prenom = ? AND nom = ? ", $dh);
        $query->setParameter(1, 'William');
        $query->setParameter(2, 'Shakespear');

        //3ème façon avec le design patern fluent
        $query = $this->createQueryBuilder()
                    ->select('a.nom', 'a.prenom')
                    ->select('a.nom')
                    ->addSelect('a.prenom')
                    //->from('') // facultatif car symfony se débrouille pour retrouver de quel from il s'agit
                    ->join('a.country', 'c')
                    ->where('WHERE a.id = 2 AND c.nom = ?1')
                    //->groupBy()
                    //->orderBy()
                    ->setParameter(1, 'Royaume-Unis')

        //debug les résultats de la requête
        dd($result);

        return $result;
        */
    }

    public function save(Author $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Author $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return Author[] Returns an array of Author objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('a.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Author
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
