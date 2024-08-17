<?php

namespace App\Controller;

use App\Entity\Post;
use App\Entity\User;
use App\Repository\PostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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
        $posts = $this->repo->findBy([],[],1);
        $posts2 = $this->repo->findBy([],[],4,1);

        return $this->render('post/index.html.twig',[
            'posts' => $posts, 'posts2' => $posts2,
        ]);
    }

    #[Route('/post/{id}', name: 'show', requirements: ['id' => '\d+'])]
    public function showone(Post $post,$id, PostRepository $reppo, EntityManagerInterface $emi): Response
    {
        // Vérification du post
        if (!$post) {
            return $this->redirectToRoute('app_post');
        }
        $posts = $reppo->find($id);
        return $this->render('show/show.html.twig', [
            'post' => $post
        ]);
    }
    #[Route('/favoris/ajout/{id}', name: 'ajout_favoris')]
    public function ajoutFavoris(Post $post, EntityManagerInterface $emi): Response
    {
        if(!$post){
            throw new NotFoundHttpException('Pas d\'annonce trouvée');
        }
        $post->addFavori($this->getUser());

        $emi->persist($post);
        $emi->flush();
        return $this->redirectToRoute('app_post');
    }
    #[Route('/favoris/retrait/{id}', name: 'retrait_favoris')]
    public function retraitFavoris(Post $post, EntityManagerInterface $emi)
    {
        if(!$post){
            throw new NotFoundHttpException('Pas d\'annonce trouvée');
        }
        $post->removeFavori($this->getUser());


        $emi->persist($post);
        $emi->flush();
        return $this->redirectToRoute('app_post');
    }
 
}