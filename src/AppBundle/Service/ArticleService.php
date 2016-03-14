<?php
/**
 * Date: 2/8/16
 * Time: 12:08 AM
 */
namespace AppBundle\Service;

use AppBundle\Entity\Article;
use AppBundle\Exception\NotFoundException;
use Doctrine\ORM\EntityManager;

/**
 * Class ArticleService
 * @package AppBundle\Service
 */
class ArticleService
{
    protected $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getAll(array $criteria)
    {
        /*$article = new Article("tt");
        $article->setAdditional(['test'=> 'val', 'test2' => 'val2']);
        $this->entityManager->persist($article);
        $this->entityManager->flush();
        $a = $this->entityManager->getRepository("AppBundle:Article")->find("c9d08ab3-cf17-11e5-a92c-74e54391bf1a");
        /**
         * @var Article $a
         *
        $a->setAdditional(['test'=> 't']);
        $this->entityManager->persist($a);
        $this->entityManager->flush();*/
        //return $this->entityManager->getRepository("AppBundle:Article")->findAll();
        $qb = $this->entityManager->createQueryBuilder();
        $qb->select("a", "au", "c")
            ->from('AppBundle:Article', "a")
            ->leftJoin("a.author", "au")
            ->leftJoin("a.comments", "c")
        ;
        foreach ($criteria as $sort => $order) {
            $qb->orderBy("a." . $sort, $order);
        }
        $query = $qb->getQuery();
        $result = $query->getResult();

        return $result;
    }

    public function get($id)
    {
        $article = $this->entityManager->getRepository("AppBundle:Article")->find($id);
        if (!$article) {
            throw new NotFoundException("Not found");
        }
        return $article;
    }

    public function getAuthor($id)
    {
        return $this->entityManager->getRepository("AppBundle:Author")->find($id);
    }

    public function getComment($id)
    {
        return $this->entityManager->getRepository("AppBundle:Comment")->find($id);
    }
}
