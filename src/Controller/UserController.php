<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\EditProfileUserType;

class UserController extends AbstractController
{
    #[Route('/user', name: 'app_user')]
    public function index(): Response
    {
        $user = $this->getUser();

        if ($user) {
            
            return $this->render('user/profile.html.twig', [
                'user' => $user,
            ]);
        } else {
            
            return $this->redirectToRoute('app_main');
        }
    }

    #[Route('/user/edit', name: 'user_profil_edit')]
    public function editUserProfil(Request $request, EntityManagerInterface $em): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(EditProfileUserType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            $this->addFlash('success', 'Profile utilisateur mis à jour');
        }

        return $this->render('user/edituser.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]); 
    }
}
