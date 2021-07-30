<?php

namespace App\Controller;

use App\Entity\Topic;
use App\Form\TopicFormType;
use App\Repository\ForumRepository;
use App\Repository\TopicRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TopicController extends AbstractController
{
    /**
     * @var EntityManagerInterface
     */
    private $em;
    /**
     * @var TopicRepository
     */
    private $topicRepo;
    /**
     * @var ForumRepository
     */
    private $forumRepo;

    /**
     * TopicController constructor.
     * @param EntityManagerInterface $em
     * @param TopicRepository $topicRepo
     * @param ForumRepository $forumRepo
     */
    public function __construct(EntityManagerInterface $em, TopicRepository $topicRepo, ForumRepository $forumRepo)
    {
        $this->em = $em;
        $this->topicRepo = $topicRepo;
        $this->forumRepo = $forumRepo;
    }

    /**
     * @Route("/topic/{id}", name="topic")
     */
    public function index($id): Response
    {
        $forum = $this->forumRepo->find($id);
        $topics = $forum->getTopics();

        return $this->render('topic/index.html.twig', [
            'topics' => $topics,
            'forum' => $forum,
        ]);
    }

    /**
     * @Route("/new-topic/{id}", name="new_topic")
     */
    public function newTopic(Request $request, $id): Response
    {
        $user = $this->getUser();
        $forum = $this->forumRepo->find($id);

        $topic = new Topic();
        $topic->setCreatedAt(new \DateTime());
        $topic->setUser($user);
        $topic->setForum($forum);

        $form = $this->createForm(TopicFormType::class, $topic);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($topic);
            $this->em->flush();

            return $this->redirectToRoute('topic',  ['id' => $forum->getId()]);
        }

        return $this->renderForm('topic/new.html.twig', [
            'form' => $form,
            'forum' => $forum,
        ]);

    }
}
