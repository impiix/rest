<?php
/**
 * Date: 2/9/16
 * Time: 12:07 PM
 */
namespace AppBundle\Schema;

use AppBundle\Entity\Comment;
use Neomerx\JsonApi\Schema\SchemaProvider;

/**
 * Class CommentSchema
 * @package AppBundle\Schema
 */
class CommentSchema extends SchemaProvider
{
    protected $resourceType = "comments";

    public function getId($comment)
    {
        return $comment->getId();
    }

    public function getAttributes($comment)
    {
        /**
         * @var Comment $comment
         */
        return [
            'title'  => $comment->getTitle(),
            'content'  => $comment->getContent()
        ];
    }

    public function getRelationships($comment, array $includeList = [])
    {
        /** @var Comment $comment */
        return [
            'article' => [self::DATA => $comment->getArticle()],
        ];
    }
}
