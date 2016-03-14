<?php
/**
 * Date: 2/10/16
 * Time: 4:44 PM
 */
namespace AppBundle\Service;
use AppBundle\Entity\Article;
use AppBundle\Entity\Author;
use AppBundle\Entity\Comment;
use AppBundle\Schema\ArticleSchema;
use AppBundle\Schema\AuthorSchema;
use AppBundle\Schema\CommentSchema;
use Neomerx\JsonApi\Encoder\Encoder;
use Neomerx\JsonApi\Encoder\EncoderOptions;


/**
 * Class EncoderService
 * @package AppBundle\Service
 */
class EncoderService
{
    public static function create($url)
    {
        $schemas = [
                Article::class => ArticleSchema::class,
                Author::class =>AuthorSchema::class,
                Comment::class =>CommentSchema::class
            ];

        $encoder = Encoder::instance(
            $schemas,
            new EncoderOptions(JSON_PRETTY_PRINT, $url)
        );

        return $encoder;
    }
}
