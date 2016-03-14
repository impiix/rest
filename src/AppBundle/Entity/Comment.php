<?php
/**
 * Date: 2/11/16
 * Time: 5:10 PM
 */
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Comment
 * @package AppBundle\Entity
 * @ORM\Entity
 */
class Comment
{
    /**
     * @var
     * @ORM\Id
     * @ORM\Column(name="id", type="string")
     * @ORM\GeneratedValue(strategy="UUID")
     */
    protected $id;

    /**
     * @var
     * @ORM\Column(name="title", type="string")
     */
    protected $title;

    /**
     * @var
     * @ORM\Column(name="content", type="string")
     */
    protected $content;

    /**
     * @var
     * @ORM\ManyToOne(targetEntity="Article", inversedBy="comments")
     */
    protected $article;

    /**
     * Comment constructor.
     * @param $title
     * @param $content
     * @param Article $article
     */
    public function __construct($title, $content, Article $article)
    {
        $this->title = $title;
        $this->content = $content;
        $this->article = $article;
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
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @return mixed
     */
    public function getArticle()
    {
        return $this->article;
    }

}
