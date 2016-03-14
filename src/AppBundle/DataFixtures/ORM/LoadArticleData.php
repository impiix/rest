<?php
/**
 * Date: 2/9/16
 * Time: 5:28 PM
 */
namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Article;
use AppBundle\Entity\Author;
use AppBundle\Entity\Comment;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class LoadArticleData
 * @package AppBundle\DataFixtures
 */
class LoadArticleData implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < 100; $i++) {
            $author = new Author("author" . $i);
            $article = new Article("article" . $i);
            $article->setAuthor($author);
            $comment = new Comment("title" . $i, "content" . $i, $article);
            $article->addComment($comment);
            $manager->persist($article);
            $manager->persist($comment);
            $manager->persist($author);
            if ($i == 50) {
                sleep(3);
            }

        }
        $manager->flush();
    }
}
