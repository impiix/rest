<?php
/**
 * Date: 2/9/16
 * Time: 12:07 PM
 */
namespace AppBundle\Schema;

use AppBundle\Entity\Author;
use Neomerx\JsonApi\Schema\SchemaProvider;

/**
 * Class AuthorSchema
 * @package AppBundle\Schema
 */
class AuthorSchema extends SchemaProvider
{
    protected $resourceType = "people";

    public function getId($author)
    {
        return $author->getId();
    }

    public function getAttributes($author)
    {
        /**
         * @var Author $author
         */
        return [
            'name'  => $author->getName()
        ];
    }


}
