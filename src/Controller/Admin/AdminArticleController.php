<?php

namespace App\Controller\Admin;

use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminArticleController extends AbstractController
{
    /**
     * @var ArticleRepository
     */
    private $repository;
    /**
     * @var EntityManagerInterface
     */
    private $em;

    public function __construct(ArticleRepository $repository, EntityManagerInterface $em)
    {
        $this->repository=$repository;
        $this->em=$em;
    }

    /**
     * @Route("/admin", name="admin.article.index")
     */
    public function index():Response
    {
        $articles = $this->repository->findAll();
        return $this->render('admin/article/index.html.twig',[
            'articles' => $articles,
        ]);
    }

    /**
     * @Route("/admin/article/create", name="admin.article.new")
     * @param Request $request
     * @return Response
     */
    public function new(Request $request)
    {
        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);
        $user = $this->getUser();
        dump($user);
        if ($form->isSubmitted() && $form->isValid()){
            $article->setUser($user);
            $this->em->persist($article);
            $this->em->flush();
            $this->addFlash('success', 'Votre article a été créer avec succès');

            return $this->redirectToRoute('admin.article.index');
        }
        return $this->render('admin/article/new.html.twig', [
            'articles' => $article,
            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route("/admin/article/{id}", name="admin.article.edit", methods="GET|POST")
     * @param Article $article
     * @param Request $request
     * @return Response
     */
    public function edit(Article $article, Request $request):Response
    {

        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $this->em->flush();
            $this->addFlash('success', 'Votre article a été modifié avec succès');
            return $this->redirectToRoute('admin.article.index');
        }
        return $this->render('admin/article/edit.html.twig', [
            'articles' => $article,
            // Envoie du formulaire à la vue grâce à la méthode createView()
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/article/{id}", name="admin.article.delete", methods="DELETE")
     * @param Article $article
     * @param Request $request
     * @return Response
     */
    public function delete(Article $article, Request $request):Response
    {
        if ($this->isCsrfTokenValid('delete' . $article->getId(), $request->get('_token'))){
            $this->em->remove($article);
            $this->em->flush();;
            $this->addFlash('success', 'Votre article a été supprimé avec succès');
            return $this->redirectToRoute('admin.article.index');
        }
        return $this->redirectToRoute('admin.article.index');
    }
}