<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Form\CommentType;
use App\Repository\CommentRepository;
use App\Repository\PostRepository;
use Monolog\DateTimeImmutable;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/comment')]
class CommentController extends AbstractController
{
    

    #[Route('/new/{id}', name: 'app_comment_new', methods: ['GET', 'POST'])]
    public function new(int $id, Request $request, CommentRepository $commentRepository, PostRepository $postRepository): Response
    {
        if (!$this->getUser()) {
            $this->addFlash('warning', 'Il faut être connété pour poster un message');  
            return $this->redirectToRoute('app_login'); // Replace with the route name for your login page
        }

        $article = $postRepository->findOneBy(['id' => $id]);
        
        $comment = new Comment();
        $comment->setCreatedAt(new \DateTimeImmutable());
        $comment->setUser($this->getUser());
        $comment->setPost($article);
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $commentRepository->save($comment, true);

            return $this->redirectToRoute('app_post_show', ['id' => $id], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('comment/new.html.twig', [
            'comment' => $comment,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_comment_show', methods: ['GET'])]
    public function show(Comment $comment): Response
    {
        return $this->render('comment/show.html.twig', [
            'comment' => $comment,
        ]);
    }

    

}
