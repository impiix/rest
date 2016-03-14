<?php

namespace AppBundle\Controller;

use AppBundle\Criteria\BaseCriteria;
use AppBundle\Exception\NotFoundException;
use AppBundle\Exception\ValidationException;
use AppBundle\Schema\ArticleSchema;
use FOS\RestBundle\Controller\FOSRestController;
use Neomerx\JsonApi\Encoder\Encoder;
use Neomerx\JsonApi\Encoder\EncoderOptions;
use Neomerx\JsonApi\Schema\Link;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Article;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Router;

class DefaultController extends FOSRestController
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
        ]);
    }

    public function getArticlesAction(Request $request)
    {
        $sort = $request->query->get("sort");
        if ($sort) {
            $validator = $this->get("validator.service");
            try {
                $criteria = $validator->validate($sort, new BaseCriteria());
            } catch (ValidationException $e) {
                $view = $this->view(['message' => $e->getMessage()], Response::HTTP_NOT_FOUND);
                return $this->handleView($view);
            }

        }
        $service = $this->get("article.service");

        $base = $request->getSchemeAndHttpHost();

        $encoder = $this->get('encoder');
        $router = $this->get("router");

        /**
         * @var Router $router
         */

        $encoder->withLinks(['self' => new Link($router->generate("get_articles", [], $router::ABSOLUTE_URL))]);
        $data = $service->getAll($criteria);

        $result = $encoder->encodeData($data);

        $response = new Response($result);
        $response->headers->set("Content-Type", "application/vnd.api+json");

        return $response;

        $view = $this->view($result, 200)
            ->setTemplate("AppBundle:Default:getUsers.html.twig")
            ->setTemplateVar('users');

        return $this->handleView($view);
    }

    public function getArticleAction(Request $request, $id)
    {
        $service = $this->get("article.service");

        $base = $request->getSchemeAndHttpHost();
        $encoder = $this->get('encoder');
        $encoder->withLinks(['next' => new Link('next')]);

        try {
            $article = $service->get($id);
        } catch (NotFoundException $e) {
            $view = $this->view(['message' => $e->getMessage()], Response::HTTP_NOT_FOUND);
            return $this->handleView($view);
        }
        $result = $encoder->encodeData($article);

        $response = new Response($result);


        return $response;
    }

    public function getArticleAuthorAction($id)
    {
        $service = $this->get("article.service");

        $encoder = $this->get('encoder');
        $encoder->withLinks(['next' => new Link('next')]);

        $article = $service->get($id);
        $author = $article->getAuthor();
        $result = $encoder->encodeData($author);

        $response = new Response($result);


        return $response;
    }

    public function getArticleCommentsAction($id)
    {
        $service = $this->get("article.service");

        $encoder = $this->get('encoder');
        $encoder->withLinks(['next' => new Link('next')]);

        $article = $service->get($id);
        $comments = $article->getComments()->toArray();
        $result = $encoder->encodeData($comments);

        $response = new Response($result);


        return $response;
    }

    public function getArticleRelationshipsCommentsAction($id)
    {
        $service = $this->get("article.service");


        $encoder = $this->get('encoder');
        $encoder->withLinks(['next' => new Link('next')]);

        $article = $service->get($id);
        $comments = $article->getComments()->toArray();
        $result = $encoder->encodeData($comments);

        $response = new Response($result);


        return $response;
    }

    public function redirectAction()
    {
        $view = $this->renderView($this->generateUrl('test'), 301);

        return $this->handleView($view);
    }
}
