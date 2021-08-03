<?php

namespace App\Controller;

use App\Entity\Game;
use App\Form\GameType;
use App\Repository\GameRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/game")
 */
class AdminGameController extends AbstractController
{
    /**
     * @Route("/", name="admin_game_index", methods={"GET"})
     */
    public function index(GameRepository $gameRepository): Response
    {
        return $this->render('admin/admin_game/index.html.twig', [
            'games' => $gameRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="admin_game_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $game = new Game();
        $form = $this->createForm(GameType::class, $game);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($game);
            $entityManager->flush();

            return $this->redirectToRoute('admin_game_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/admin_game/new.html.twig', [
            'game' => $game,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="admin_game_show", methods={"GET"})
     */
    public function show(Game $game): Response
    {
        return $this->render('admin/admin_game/show.html.twig', [
            'game' => $game,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin_game_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Game $game): Response
    {
        $form = $this->createForm(GameType::class, $game);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_game_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/admin_game/edit.html.twig', [
            'game' => $game,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="admin_game_delete", methods={"POST"})
     */
    public function delete(Request $request, Game $game): Response
    {
        if ($this->isCsrfTokenValid('delete'.$game->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($game);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_game_index', [], Response::HTTP_SEE_OTHER);
    }
}
