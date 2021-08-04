<?php

namespace App\Twig;

use App\Repository\ForumRepository;
use Doctrine\ORM\EntityManagerInterface;
use Twig\Environment;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class NavExtention extends AbstractExtension
{
    /**
     * @var Environment
     */
    private $twigEnvironment;
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @var ForumRepository
     */
    private $forumRepo;

    /**
     * @param Environment $twigEnvironment
     * @param EntityManagerInterface $em
     * @param ForumRepository $forumRepo
     */
    public function __construct(Environment $twigEnvironment, EntityManagerInterface $em, ForumRepository $forumRepo)
    {
        $this->twigEnvironment = $twigEnvironment;
        $this->em = $em;
        $this->forumRepo = $forumRepo;
    }


    public function getFunctions()
    {
        return [
            new TwigFunction('get_forums', [$this, 'getForums'])
        ];
    }
    public function getForums() {
        $forums = $this->forumRepo->findAll();
        return $this->twigEnvironment->render('layout/_forumList.html.twig', ['forums' => $forums]);
    }

}