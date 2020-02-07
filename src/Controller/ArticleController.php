<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Picture;
use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
     * @return Response
     * @Route("/articles", name="article.index")
     */
    public function index(): Response
    {
        $articles = $this->repository->findAll();

        return $this->render('articles/index.html.twig', [
            'current_menu' => 'articles',
            'articles' => $articles,
        ]);
    }

    /**
     * @param Article $article
     * @return Response
     */
    public function show(Article $article)
    {
        return $this->render('articles/show.html.twig', [
            'articles' => $article,
        ]);
    }
}