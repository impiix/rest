<?php
/**
 * Date: 2/8/16
 * Time: 12:04 AM
 */
namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Article
 * @package AppBundle\Entity
 * @ORM\Entity
 * @ORM\Table(name="article")
 */
class Article
{
    /**
     * @var
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="UUID")
     * @ORM\Column(name="id", type="string")
     */
    protected $id;

    /**
     * @var
     * @ORM\Column(name="name", type="string")
     */
    protected $name;

    /**
     * @var
     * @ORM\Column(name="additional", type="string", nullable=true)
     */
    protected $additional;

    /**
     * @var
     * @ORM\ManyToOne(targetEntity="Author", fetch="EAGER")
     */
    protected $author;

    /**
     * @var
     * @ORM\OneToMany(targetEntity="Comment", mappedBy="article", fetch="EAGER")
     */
    protected $comments;

    /**
     * @var
     * @ORM\Column(type="datetime", name="created")
     */
    protected $created;

    public function __construct($name)
    {
        $this->name = $name;
        $this->comments = new ArrayCollection();
        $this->created = new \DateTime();
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

    /**
     * @return mixed
     */
    public function getAdditional()
    {
        return json_decode($this->additional, true);
    }

    /**
     * @param mixed $additional
     */
    public function setAdditional($additional)
    {
        $this->additional = json_encode($additional);
    }

    /**
     * @return Author
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * @param mixed $author
     */
    public function setAuthor(Author $author)
    {
        $this->author = $author;
    }
    public function getComments()
    {
        return $this->comments;
    }
    public function addComment(Comment $comment)
    {
        $this->comments->add($comment);
    }

    /**
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

}
