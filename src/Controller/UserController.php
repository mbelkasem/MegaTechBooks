<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\EditProfileUserType;
use App\Form\ChangePasswordType;

class UserController extends AbstractController
{
    #[Route('/user', name: 'app_user')]
    public function index(): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
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
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
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

    #[Route('/user/changepwd', name: 'user_profil_pwd')]
        public function editUserPassword(Request $request, EntityManagerInterface $em, UserPasswordHasherInterface $userPasswordHasher): Response
        {
            $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
            $user = $this->getUser();
            $form = $this->createForm(ChangePasswordType::class);
            $form->handleRequest($request);
        
            if ($request->getMethod() == 'POST') {
                $pwdFirst = $form->get('password')['first']->getData();
                $pwdSecond = $form->get('password')['second']->getData();
        
                if (strlen($pwdFirst) >= 6 && $pwdFirst === $pwdSecond) {
                    $user->setPassword(
                        $userPasswordHasher->hashPassword(
                            $user,
                            $form->get('password')->getData()
                        )
                    );
        
                    $this->addFlash('success', 'Mot de passe mis à jour');
                    $em->persist($user);
                    $em->flush();
        
                    return $this->redirectToRoute('app_user');
                } else {
                    if (strlen($pwdFirst) < 6) {
                        $this->addFlash('warning', 'Le mot de passe doit comporter au moins 6 caractères');
                    } else {
                        $this->addFlash('warning', 'Les deux mots de passe ne sont pas identiques');
                    }
                }
            }

            

            return $this->render('user/pwduser.html.twig', [
                'form' => $form->createView(),
            ]);
        }
}
