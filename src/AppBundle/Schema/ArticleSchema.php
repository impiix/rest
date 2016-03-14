<?php
/**
 * Date: 2/9/16
 * Time: 12:07 PM
 */
namespace AppBundle\Schema;

use AppBundle\Entity\Article;
use Neomerx\JsonApi\Schema\Link;
use Neomerx\JsonApi\Schema\SchemaProvider;

/**
 * Class AuthorSchema
 * @package AppBundle\Schema
 */
class ArticleSchema extends SchemaProvider
{
    protected $resourceType = "articles";

    public static $isShowCustomLinks = true;

    public function getId($article)
    {
        return $article->getId();
    }

    public function getAttributes($article)
    {

        $comments = [];
        foreach ($article->getComments() as $comment) {
            $comments[] = [
                'title' => $comment->getTitle()
            ];
        }
        $i = 4;
        /**
         * @var Article $article
         */
        return [
            'name'  => $article->getName(),
            'created' => $article->getCreated()->format("Y-m-d H:i:s")

        ];
    }
    public function getRelationships($article, array $includeList = [])
    {

        $links = [
            'self' => new Link("author"),
            'related' => new Link("relationship/author")
        ];
        $commentLinks = [
            'self' => new Link("comments"),
            'related' => new Link("relationship/comments")
        ];
        /** @var Article $article */
        return [
            'author'   => [
                self::DATA => $article->getAuthor(),
                self::LINKS => $links
            ],
            'comments' => [
                self::DATA => $article->getComments()->toArray(),
                self::LINKS => $commentLinks
            ],

        ];
    }

    public function getIncludePaths()
    {
        return [
            'comments',
            'author',
        ];
    }
}
