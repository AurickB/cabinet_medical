<?php

namespace App\Controller;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;

class ArticleController extends AbstractController
{
    /**
     * @var ArticleRepository
     */
    private $repository;

    public function __construct(ArticleRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return Response
     * @Route("/articles", name="article.index")
     */
    public function index(PaginatorInterface $paginator, Request $request): Response
    {
        $articles = $paginator->paginate(
            $this->repository->findBy(
                ['isPublished' => true],
                ['created_at' => 'desc']
                ),
            $request->query->getInt('page', 1),
            5
        );

        return $this->render('articles/index.html.twig', [
            'current_menu' => 'articles',
            'articles' => $articles,
        ]);
    }

    /**
     * @Route("/article/{slug}-{id}", name="article.show", requirements={"slug": "[a-z0-9\-]*"})
     * @param Article $article
     * @param string $slug
     * @return Response
     */
    public function show(Article $article, string $slug): Response
    {
        if ($article->getSlug() !== $slug){
            return $this->redirectToRoute('article.show', [
                'id' =>$article->getId(),
                'slug'=>$article->getSlug(),
            ], 301);
        }
        return $this->render('articles/show.html.twig', [
            'articles' => $article
        ]);
    }
}