<?php

namespace App\Controller;

use App\Entity\Post;
use App\Form\CreaPostFormType;
use App\Repository\PostCategoryRepository;
use App\Repository\PostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminPostCategoryController extends AbstractController
{
    /**
     * @var EntityManagerInterface
     */
    private $em;
    /**
     * @var PostRepository
     */
    private $postRepo;
    /**
     * @var PostCategoryRepository
     */
    private $catPostRepo;

    /**
     * AdminPostCategoryController constructor.
     * @param EntityManagerInterface $em
     * @param PostRepository $postRepo
     * @param PostCategoryRepository $catPostRepo
     */
    public function __construct(EntityManagerInterface $em, PostRepository $postRepo, PostCategoryRepository $catPostRepo)
    {
        $this->em = $em;
        $this->postRepo = $postRepo;
        $this->catPostRepo = $catPostRepo;
    }

    /**
     * @Route("/admin/post-list", name="admin_post_list")
     */
    public function index(): Response {
        $catList = $this->catPostRepo->findAll();

        return $this->render('admin_postList_category/index.html.twig', [
            "catList" => $catList,
        ]);
    }

    /**
     * @Route("/admin/create-post", name="admin_post_create")
     */
    public function createPost(Request $request): Response
    {
        $post= new Post();
        $form = $this->createForm(CreaPostFormType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($post);
            $this->em->flush();
            return $this->redirectToRoute('home');
        }

        return $this->render('admin_post_category/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/update-post/{id}", name="admin_post_update")
     */
    public function updatePost(Request $request, $id): Response
    {
        $post = $this->postRepo->find($id);
        $form = $this->createForm(CreaPostFormType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($post);
            $this->em->flush();
            return $this->redirectToRoute('home');
        }

        return $this->render('admin_post_category/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
