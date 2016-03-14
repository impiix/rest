<?php
/**
 * Date: 2/15/16
 * Time: 3:47 PM
 */
namespace AppBundle\Criteria;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class BaseCriteria
 * @package AppBundle\Criteria
 */
class BaseCriteria
{
    /**
     * @var
     * @Assert\All({
     *     @Assert\Choice(choices={"created"}, message="Invalid sort field")
     *     })
     */
    protected $sort;

    public function setSort($sort)
    {
        $this->sort = $sort;
    }
}
