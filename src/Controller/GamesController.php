<?php

namespace App\Controller;

use App\Form\SearchFormType;
use App\Repository\GameRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GamesController extends AbstractController
{
    /**
     * @var EntityManagerInterface
     */
    private $em;
    /**
     * @var GameRepository
     */
    private $gameRepo;

    /**
     * @param EntityManagerInterface $em
     * @param GameRepository $gameRepo
     */
    public function __construct(EntityManagerInterface $em, GameRepository $gameRepo)
    {
        $this->em = $em;
        $this->gameRepo = $gameRepo;
    }

    /**
     * @Route("/games", name="games")
     */
    public function index(PaginatorInterface $paginator, Request $request): Response
    {
        $qb = $this->gameRepo->getQbAll();


        $form = $this->createForm(SearchFormType::class);
        $form->handleRequest($request);

        $tags = [];

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            if ($data['search']) {
                dump('ici');
                $qb
                    ->andWhere('game.title LIKE :game_title')
                    ->setParameter('game_title', '%' . $data['search'] . '%');
            }
            if ($data['support']) {
                $qb
                    ->innerJoin('game.devices', 'd')
                    ->andWhere('d.id = :device_id')
                    ->setParameter('device_id', $data['support']->getId());
                $tags[] = $data['support'];
            }
            if ($data['cat']) {
                $qb
                    ->innerJoin('game.gameCategory', 'gc')
                    ->andWhere('gc.id = :cat_id')
                    ->setParameter('cat_id', $data['cat']->getId());
                $tags[] = $data['cat'];
            }
        }

        $pagination = $paginator->paginate(
            $qb,
            $request->query->getInt('page', 1),
            6
        );

        return $this->render('games/index.html.twig', [
            'form' => $form->createView(),
            'games' => $pagination,
            'tags' => $tags,
        ]);
    }
}
