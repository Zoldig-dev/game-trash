<?php

namespace App\Controller;

use App\Repository\DeviceRepository;
use App\Repository\GameCategoryRepository;
use App\Repository\GameRepository;
use App\Repository\PostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
    public function index(): Response
    {
//        $hasAccess = $this->isGranted("ROLE_ADMIN");
        $games = $this->gameRepo->findAll();
        $posts = $this->postRepo->findAll();

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            "games" => $games,
            "posts" => $posts,
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
