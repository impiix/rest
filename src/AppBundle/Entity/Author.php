<?php
/**
 * Date: 2/9/16
 * Time: 12:01 PM
 */
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Author
 * @package AppBundle\Entity
 * @ORM\Entity
 */
class Author
{
    /**
     * @var
     * @ORM\Id
     * @ORM\GeneratedValue("UUID")
     * @ORM\Column(name="id", type="string")
     */
    protected $id;

    /**
     * @var
     * @ORM\Column(name="name", type="string")
     */
    protected $name;

    public function __construct($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }
}
