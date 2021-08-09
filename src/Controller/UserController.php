<?php

namespace App\Controller;


use App\Form\UserFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    private EntityManagerInterface $em;

    /**
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @Route("/user", name="user")
     */
    public function index(Request $request): Response
    {
        $user = $this->getUser();
        dump($user);
        $form = $this->createForm(UserFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $files = $form->get('avatar')->getData();
            if ($files !== null) {
                $originalFileName = pathinfo($files->getClientOriginalName(), PATHINFO_FILENAME);
                dump($originalFileName);
            }
//            $this->em->persist($user);
//            $this->em->flush();

            return $this->redirectToRoute('user');
        }
        return $this->render('home/user.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
