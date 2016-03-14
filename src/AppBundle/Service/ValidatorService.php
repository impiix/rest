<?php
/**
 * Date: 2/15/16
 * Time: 4:26 PM
 */
namespace AppBundle\Service;

use AppBundle\Criteria\BaseCriteria;
use AppBundle\Exception\ValidationException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class ValidatorService
 * @package AppBundle\Service
 */
class ValidatorService
{
    protected $validator;

    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }
    public function validate($sort, BaseCriteria $criteria)
    {
        $sort = explode(",", $sort);
        $order = [];
        $sort = array_map(function ($el) use (&$order) {
            if (strpos($el, '-') !== false) {
                $el = substr($el, 1);
                $order[] = "desc";
            } else {
                $order[] = "asc";
            }
            return $el;
        }, $sort);

        $criteria->setSort($sort);

        $result = $this->validator->validate($criteria);
        if (count($result)) {
            throw new ValidationException((string)$result);
        }

        return array_combine($sort, $order);
    }
}
