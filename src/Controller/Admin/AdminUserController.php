<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AdminUserController extends AbstractController
{
    /**
     * @var EntityManagerInterface
     */
    private $em;
    /**
     * @var UserPasswordEncoderInterface
     */
    private $encoder;
    /**
     * @var UserRepository
     */
    private $userRepository;

    public function __construct(EntityManagerInterface $em, UserPasswordEncoderInterface $encoder, UserRepository $userRepository)
    {
        $this->em =$em;
        $this->encoder=$encoder;
        $this->userRepository=$userRepository;
    }

    /**
     * @Route("/superadmin", name="superadmin.index")
     * @Security("is_granted('ROLE_SUPER_ADMIN')", message="Not Access ! Get Out !")
     */
    public function index()
    {
        $user = $this->userRepository->findAll();
        return $this->render('admin/user/index.html.twig', [
            'users' =>$user,
        ]);
    }

    /**
     * @Route("/superadmin/user/create", name="superadmin.user.new", methods="GET|POST")
     * @param Request $request
     * @return Response
     */
    public function new(Request $request)
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $user->setPassword($this->encoder->encodePassword($user, $user->getPassword()));
            $this->em->persist($user);
            $this->em->flush();
            $this->addFlash('success', 'L\'utilisateur a été créer avec succès');
            return $this->redirectToRoute('superadmin.index');
        }
        return $this->render('admin/user/new.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/superadmin/user/{id}", name="superadmin.user.edit", methods="GET|POST")
     * @param User $user
     * @param Request $request
     * @return Response
     */
    // Méthode qui permet l'édition des utilisateus
    public function edit(User $user, Request $request)
    {

        $form = $this->createFormBuilder($user)
            ->add('username', TextType::class)
            ->add('role', ChoiceType::class,[
                'choices' => $this->getChoiceRole()
            ])
            ->add('editer', SubmitType::class)
            ->add('unit', ChoiceType::class, [
                'choices' => $this->getChoiceUnit()
            ])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'first_options'  => array('label' => 'Password'),
                'second_options' => array('label' => 'Repeat Password'),
            ])
            ->getForm()
        ;
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $user->setPassword($this->encoder->encodePassword($user, $user->getPassword()));
            $this->em->persist($user);
            $this->em->flush();
            $this->addFlash('success', 'L\'utilisateur  a été modifié avec succès');
            return $this->redirectToRoute('superadmin.index');
        }
        return $this->render('admin/user/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    public function getChoiceRole()
    {
        $choices = User::ROLE;
        $output = [];
        foreach ($choices as $k => $v){
            $output[$v] = $k;
        }
        return $output;
    }

    public  function getChoiceUnit()
    {
        $choices = User::UNIT;
        $output = [];
        foreach ($choices as $k => $v){
            $output[$v] = $k;
        }
        return $output;
    }

    /**
     * @Route("/superadmin/user/{id}", name="superadmin.user.delete", methods="DELETE")
     * @param User $user
     * @param Request $request
     * @return Response
     */
    // Méthode qui permet supprimer les utilisateus
    public function delete(User $user,  Request $request)
    {
        // On vérifie si le token csrf est valide grâce à la méthode qui prend l'id du token et le token grâce à la méthode get
        if ($this->isCsrfTokenValid('delete' . $user->getId(), $request->get('_token'))){
            $this->em->remove($user);
            $this->em->flush();;
            $this->addFlash('success', 'L\'utilisateur a été supprimé avec succès');
            return $this->redirectToRoute('superadmin.index');
        }
        return $this->redirectToRoute('superadmin.index');
    }
}