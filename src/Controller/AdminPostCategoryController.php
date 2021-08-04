<?php

namespace App\Controller;

use App\Entity\Post;
use App\Entity\PostCategory;
use App\Form\CreaCatPostFormType;
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
     * @Route("/admin/catpost-list", name="admin_catpost_list")
     */
    public function index(): Response {
        $catList = $this->catPostRepo->findAll();

        return $this->render('admin/admin_post/index.html.twig', [
            "catList" => $catList,
        ]);
    }

    /**
     * @Route("/admin/create-catpost-list", name="admin_create_catpost_list")
     */
    public function createCatPost(Request $request): Response {
        $postCat= new PostCategory();
        $form = $this->createForm(CreaCatPostFormType::class, $postCat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($postCat);
            $this->em->flush();
            return $this->redirectToRoute('admin_catpost_list');
        }

        return $this->render('admin/admin_post/creaCatPost.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/update-catpost-list/{id}", name="admin_update_catpost_list")
     */
    public function updateCatPost(Request $request, int $id) {
        $cat = $this->catPostRepo->find($id);
        $form = $this->createForm(CreaCatPostFormType::class, $cat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($cat);
            $this->em->flush();
            return $this->redirectToRoute('admin_catpost_list');
        }

        return $this->render('admin/admin_post/creaCatPost.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/delete-catpost-list/{id}", name="admin_delete_catpost_list")
     */
    public function deleteCatPost(int $id) {
        $cat = $this->catPostRepo->find($id);
        $this->em->remove($cat);
        $this->em->flush();

        return $this->redirectToRoute("admin_catpost_list");
    }

}
