<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactFormType;
use App\Repository\GameRepository;
use App\Repository\PostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @var GameRepository
     */
    private $gameRepo;
    /**
     * @var PostRepository
     */
    private $postRepo;
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * HomeController constructor.
     * @param GameRepository $gameRepo
     * @param PostRepository $postRepo
     * @param EntityManagerInterface $em
     */
    public function __construct(GameRepository $gameRepo,PostRepository $postRepo, EntityManagerInterface $em)
    {
        $this->gameRepo = $gameRepo;
        $this->postRepo = $postRepo;
        $this->em = $em;
    }


    /**
     * @Route("/", name="home")
     */
    public function index(PaginatorInterface $paginator, Request $request): Response
    {
        $qb = $this->gameRepo->getQbAll();

        $pagination = $paginator->paginate(
            $qb,
            $request->query->getInt('page', 1),
            6
        );
//        $hasAccess = $this->isGranted("ROLE_ADMIN");
        $posts = $this->postRepo->findAll();

        $user = $this->getUser();

        $contact= new Contact();
        $contact->setUser($user);
        $contact->setCreatedAt(new \DateTime());
        $contact->setIsRead(false);
        $contact->setIsClose(false);
        $form = $this->createForm(ContactFormType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($contact);
            $this->em->flush();
            return $this->redirectToRoute('home');
        }

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            "posts" => $posts,
            'form' => $form->createView(),
            'games' => $pagination,
        ]);
    }

    /**
     * @Route("/game-detail/{id}", name="game_detail")
     */
    public function getGameById(string $id): Response
    {
        $game = $this->gameRepo->find($id);

        return $this->render('gameDetail/index.html.twig', [
            'controller_name' => 'HomeController',
            "game" => $game,
        ]);
    }

}
