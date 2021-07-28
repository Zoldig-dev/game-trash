<?php

namespace App\Controller;

use App\Form\ForumType;
use App\Repository\ForumRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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

        return $this->render('forum/index.html.twig', [
            'forum' => $forum,
        ]);
    }

    /**
     * @Route("/admin/delete-forum/{id}", name="admin_delete_forum")
     */
    public function deleteForum(int $id) {
        $post = $this->forumRepo->find($id);
        $this->em->remove($post);
        $this->em->flush();

        return $this->redirectToRoute("forum");
    }
}
