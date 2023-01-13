<?php

namespace App\Repository;

use App\Entity\Document;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Document>
 *
 * @method Document|null find($id, $lockMode = null, $lockVersion = null)
 * @method Document|null findOneBy(array $criteria, array $orderBy = null)
 * @method Document[]    findAll()
 * @method Document[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DocumentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Document::class);
    }

    public function findDocumentsPaginated(String $type = '\Document', int $page = 1, int $limit = 5)
    {
        $page = abs($page);
        $limit = abs($limit);

        $result = [];
        $query = $this->getEntityManager()->createQueryBuilder()
                    ->select('d', 'e', 'g')
                    ->from('App\Entity'.$type, 'd')
                    ->leftJoin('d.genre', 'g')
                    ->leftJoin('d.exemplaire', 'e')
                    ->setMaxResults($limit)
                    ->setFirstResult($page * $limit - $limit)
                    ;

        //On veut afficher les résultats à partir de la page 5
        //on définie la limit à 2 éléments à afficher par page
        //le premier élément à afficher va s'obtenir avec le calcul suivant :
        //5*2 - 2 = 8 ceci est l'index de l'élément Dvd à afficher

        //on va indiquer à Doctrine que l'on souhaite utiliser son paginator :
        $paginator = new Paginator($query);
        $data = $paginator->getQuery()->getResult();

        //si pas de données on retourne un tableau vide
        if (empty($data)) {
            return $result;
        }

        //on calcul le nombre de page 
        //ceil permet d'obtenir l'arrondie supérieur
        //on fait la méthode count de paginatpr afin
        //d'obtenir le nombre total d'éléments concerner par notre requête
        //(sans la notion de limit)
        //du coup on divise le nombre obtenu par la limit
        //afin de connaître le nombre de pages
        $pages = ceil($paginator->count() / $limit);
        
        $result['data'] = $data;
        $result['pages'] = $pages;
        $result['currentPage'] = $page;
        $result['limit'] = $limit;

        return $result;
    }

    public function save(Document $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Document $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return Document[] Returns an array of Document objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('d.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Document
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
