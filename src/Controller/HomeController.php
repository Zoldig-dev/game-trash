<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactFormType;
use App\Repository\GameRepository;
use App\Repository\PostRepository;
use Doctrine\ORM\EntityManagerInterface;
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
    public function index(Request $request): Response
    {
        $posts = $this->postRepo->findAll();
        $games = $this->gameRepo->findAll();

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
            "posts" => $posts,
            'games' => $games,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/game-detail/{id}", name="game_detail")
     */
    public function getGameById(string $id): Response
    {
        $game = $this->gameRepo->find($id);

        return $this->render('gameDetail/index.html.twig', [
            "game" => $game,
        ]);
    }

}
