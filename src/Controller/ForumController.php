<?php

namespace App\Controller;

use App\Repository\ForumRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ForumController extends AbstractController
{
    /**
     * @var ForumRepository
     */
    private $forumRepo;
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * ForumController constructor.
     * @param ForumRepository $forumRepo
     * @param EntityManagerInterface $em
     */
    public function __construct(ForumRepository $forumRepo, EntityManagerInterface $em)
    {
        $this->forumRepo = $forumRepo;
        $this->em = $em;
    }

    /**
     * @Route("/forum", name="forum")
     */
    public function index(): Response
    {
        $forum = $this->forumRepo->findAll();

        return $this->render('forum/forum.html.twig', [
            'forum' => $forum,
        ]);
    }
}
