<?php

namespace App\Controller;

use App\Repository\ContactRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminContactController extends AbstractController
{
    /**
     * @var EntityManagerInterface
     */
    private $em;
    /**
     * @var ContactRepository
     */
    private $contactrepo;

    /**
     * AdminContactController constructor.
     * @param EntityManagerInterface $em
     * @param ContactRepository $contactrepo
     */
    public function __construct(EntityManagerInterface $em, ContactRepository $contactrepo)
    {
        $this->em = $em;
        $this->contactrepo = $contactrepo;
    }

    /**
     * @Route("/admin/contact", name="admin_contact")
     */
    public function index(): Response
    {
        $contacts = $this->contactrepo->findAll();

        return $this->render('admin_contact/index.html.twig', [
            'contacts' => $contacts,
        ]);
    }
}
