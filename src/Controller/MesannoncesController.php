<?php

namespace App\Controller;

use App\Entity\Annonces;
use App\Form\AnnoncesType;
use App\Repository\AnnoncesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class MesannoncesController extends AbstractController
{
    protected $manager;
    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    #[Route('/mesannonces', name: 'mesannonces')]
    public function mesannonces(AnnoncesRepository $annonces): Response
    {
        $mesannonces = $annonces->findBy([
            'user' => $this->getUser()
        ]);
        
        return $this->render('mesannonces/mesannonces.html.twig',[
            'mesannonces'=>$mesannonces
        ]);
    }


    #[Route('/mesannonces/ajouter-annonces', name: 'ajouter-annonces')]
    public function ajouterAnnonces(Request $request): Response
    {
        $user = $this->getUser();
        $annonces = new Annonces;
        $form = $this->createForm(AnnoncesType::class, $annonces);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $annonces->setUser($user);
            $annonces->setNbrvus(350);
            $this->manager->persist($annonces);
            $this->manager->flush();
            $this->addFlash('success', 'Annonces bien enregistrer');
            return $this->redirectToRoute('mesannonces');
        }
        return $this->render('mesannonces/ajouterAnnonces.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
