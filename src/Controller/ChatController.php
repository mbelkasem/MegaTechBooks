<?php

namespace App\Controller;

use App\Entity\TchatMessage;
use App\Repository\TchatMessageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


#[Route('/chat')]
class ChatController extends AbstractController
{
    #[Route("/", name:"chat")]
    public function index(TchatMessageRepository $messageRepository): Response
    {
       // $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $messages = $messageRepository->findBy([], ['id' => 'DESC'], 10);
        $user=$this->getUser();
        return $this->render('/chat/chat.html.twig', [
            'messages' => $messages, 
            'user' => $user,
        ]);
    }

    #[Route("/chat/send", name:"chat_send", methods:["POST"])]
    public function send(Request $request, EntityManagerInterface $entityManager,TchatMessageRepository $messageRepository): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $message = new TchatMessage();
        $message->setMessage($request->request->get('message'));
        $user=$this->getUser();
        $message->setUser($user);

        $entityManager->persist($message);
        $entityManager->flush();

        return $this->redirectToRoute('chat');           
    }
}
