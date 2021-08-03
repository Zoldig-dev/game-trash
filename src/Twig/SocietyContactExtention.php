<?php

namespace App\Twig;

use App\Repository\SocietyRepository;
use Twig\Environment;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class SocietyContactExtention extends AbstractExtension
{
    /**
     * @var Environment
     */
    private $twigEnvironment;

    /**
     * @var SocietyRepository
     */
    private $societyRepo;

    /**
     * @param Environment $twigEnvironment
     * @param SocietyRepository $societyRepo
     */
    public function __construct(Environment $twigEnvironment, SocietyRepository $societyRepo)
    {
        $this->twigEnvironment = $twigEnvironment;
        $this->societyRepo = $societyRepo;
    }

    public function getFunctions()
    {
        return [
            new TwigFunction('show_society_contact', [$this, 'showSocietyContact']),
        ];
    }

    public function showSocietyContact()
    {
        $contact = $this->societyRepo->findAll()[0];
        return $this->twigEnvironment->render('footer/_societyContact.html.twig', ['contact' => $contact]);
    }

}