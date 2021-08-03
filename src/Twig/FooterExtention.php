<?php

namespace App\Twig;

use App\Repository\GameRepository;
use App\Repository\PostRepository;
use Twig\Environment;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class FooterExtention extends AbstractExtension
{
    /**
     * @var Environment
     */
    private $twigEnvironment;

    /**
     * @var GameRepository
     */
    private $gameRepo;

    /**
     * @var PostRepository
     */
    private $postRepo;

    /**
     * @param Environment $twigEnvironment
     * @param GameRepository $gameRepo
     * @param PostRepository $postRepo
     */
    public function __construct(Environment $twigEnvironment, GameRepository $gameRepo, PostRepository $postRepo)
    {
        $this->twigEnvironment = $twigEnvironment;
        $this->gameRepo = $gameRepo;
        $this->postRepo = $postRepo;
    }

    public function getFunctions()
    {
        return [
            new TwigFunction('show_nb_games', [$this, 'showNbGames']),
            new TwigFunction('show_nb_posts', [$this, 'showNbPosts']),
        ];
    }

    public function showNbGames()
    {
        $nbGames = count($this->gameRepo->findAll());
        return $this->twigEnvironment->render('footer/_nbGame.html.twig', ['nbGames' => $nbGames]);

    }

    public function showNbPosts()
    {
        $nbPosts =  count($this->postRepo->findAll());
        return $this->twigEnvironment->render('footer/_nbPosts.html.twig', ['nbPosts' => $nbPosts]);

    }

}