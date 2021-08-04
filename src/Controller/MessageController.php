<?php

namespace App\Controller;

use App\Entity\Message;
use App\Form\MessageType;
use App\Repository\MessageRepository;
use App\Repository\TopicRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/message")
 */
class MessageController extends AbstractController
{
    private EntityManagerInterface $em;

    /**
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @Route("/{id}", name="message_index")
     */
    public function index(MessageRepository $messageRepository, TopicRepository $topicRepo, Request $request, $id): Response
    {
        $user = $this->getUser();
        $topic = $topicRepo->find($id);
        $message = new Message();
        $message->setCreatedAt(new \DateTime());
        $message->setTopic($topic);
        $message->setUser($user);
        $form = $this->createForm(MessageType::class, $message);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $message->setContent($form->getData()->getContent());
            $this->em->persist($message);
            $this->em->flush();

            return $this->redirectToRoute('message_index', ['id' => $topic->getId()]);
        }

        return $this->render('forum/message.html.twig', [
            'messages' => $messageRepository->findAll(),
            'form' => $form->createView(),
            'topic' => $topic
        ]);
    }
}
