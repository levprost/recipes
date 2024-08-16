<?php

namespace App\Controller;

use App\Entity\Post;
use App\Entity\Step;
use App\Repository\PostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PostController extends AbstractController
{
    private $repo;
    private $emi;
    public function __construct(PostRepository $repo, EntityManagerInterface $emi){
        $this->repo = $repo;
        $this->emi = $emi;
    }
    //GESTION DE L'AFFICHAGE DE LA PAGE D'ACCEUIL(INDEX)
    #[Route('/', name: 'app_post')]
    public function index(): Response
    {
        $posts = $this->repo->findBy([],['createdAt'=>'DESC'],1);
        $posts2 = $this->repo->findBy([],['createdAt' => 'DESC'],4,1);

        return $this->render('post/index.html.twig',[
            'posts' => $posts, 'posts2' => $posts2,
        ]);
    }

    #[Route('/post/{id}', name: 'show', requirements: ['id' => '\d+'])]
    public function showone(Post $post, Step $steps ,$id, PostRepository $reppo, EntityManagerInterface $emi): Response
    {
        // Vérification du post
        if (!$post) {
            return $this->redirectToRoute('app_post');
        }
        $steps = $post->getStep()->toArray();
        $posts = $reppo->find($id);
        return $this->render('show/show.html.twig', [
            'post' => $post,
            'step' => $steps
        ]);
    }
}