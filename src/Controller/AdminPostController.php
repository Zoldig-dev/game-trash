<?php

namespace App\Controller;

use App\Entity\Post;
use App\Form\CreaPostFormType;
use App\Repository\PostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminPostController extends AbstractController
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
     * AdminPostController constructor.
     * @param EntityManagerInterface $em
     * @param PostRepository $postRepo
     */
    public function __construct(EntityManagerInterface $em, PostRepository $postRepo)
    {
        $this->em = $em;
        $this->postRepo = $postRepo;
    }

    /**
     * @Route("/pos-detail/{id}", name="post_detail")
     */
    public function getPostById(string $id): Response
    {
        $post = $this->postRepo->find($id);
        $post->setNumberView($post->getNumberView()+1);
        $this->em->persist($post);
        $this->em->flush();

        return $this->render('postDetail/index.html.twig', [
            "post" => $post,
        ]);
    }

    /**
     * @Route("/admin/create-post", name="admin_post_create")
     */
    public function createPost(Request $request): Response
    {
        $user = $this->getUser();

        $post= new Post();
        $post->setUser($user);
        $post->setCreatedAt(new \DateTime());
        $post->setStatus(1);
        $post->setNumberView(0);
        $form = $this->createForm(CreaPostFormType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($post);
            $this->em->flush();
            return $this->redirectToRoute('home');
        }

        return $this->render('admin/admin_create_post/index.html.twig', [
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

        return $this->render('admin/admin_create_post/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/delete-post-list/{id}", name="admin_delete_post_list")
     */
    public function deletePost(int $id) {
        $post = $this->postRepo->find($id);
        $this->em->remove($post);
        $this->em->flush();

        return $this->redirectToRoute("home");
    }
}
