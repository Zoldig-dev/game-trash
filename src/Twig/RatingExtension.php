<?php

namespace App\Twig;

use App\Entity\Game;
use App\Repository\GameRepository;
use Twig\Environment;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class RatingExtension extends AbstractExtension
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
     * @param Environment $twigEnvironment
     * @param GameRepository $gameRepo
     */
    public function __construct(Environment $twigEnvironment, GameRepository $gameRepo)
    {
        $this->twigEnvironment = $twigEnvironment;
        $this->gameRepo = $gameRepo;
    }

    /**
     * Filter
     */

//    public function getFilters()
//    {
//        return [
//            new TwigFilter(),
//        ];
//    }

    /**
     * Function
     */

    public function getFunctions()
    {
        return [
          new TwigFunction('show_rating', [$this, 'showRating']),
        ];
    }

    public function showRating(Game $game) {
        $note = $game->getNotGlobal();

        return $this->twigEnvironment->render('gameDetail/_rating.html.twig', ['note' => $note]);
    }
}