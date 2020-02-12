<?php

namespace App\Controller\Admin;


use App\Entity\Picture;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/admin/picture")
 */
class AdminPictureController extends AbstractController
{
    /**
     * @param Picture $picture
     * @param Request $request
     * @return Response
     * @Route("/{id}", name="admin.picture.delete", methods="DELETE")
     */
    public function delete(Picture $picture, Request $request):Response
    {
        $articleId = $picture->getArticle()->getId();
        if ($this->isCsrfTokenValid('delete' . $picture->getId(), $request->get('_token'))){
            $em = $this->getDoctrine()->getManager();
            $em->remove($picture);
            $em->flush();
        }
        return $this->redirectToRoute('admin.article.edit', ['id'=>$articleId]);
    }
}