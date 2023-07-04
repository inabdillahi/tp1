<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Form\CategorieType;
use App\Repository\CategorieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class AdminController extends AbstractController
{
    protected $manager;
    protected $slug;
    protected $repoCat;
    public function __construct(EntityManagerInterface $manager, SluggerInterface $slug, CategorieRepository $repoCat)
    {
        $this->manager = $manager;
        $this->slug = $slug;
        $this->repoCat = $repoCat;
    }
    #[Route('/utilisateurs/admin', name: 'admin')]
    public function admin(): Response
    {
        return $this->render('admin/admin.html.twig');
    }


    #[Route('/utilisateurs/admin/categorie', name: 'categorie')]
    #[Route('/utilisateurs/admin/categorie/edit/{id}', name: 'edit-categorie')]
    public function Categorie(Categorie $categorie, Request $request): Response
    {
        if ($categorie === null) {
            $categorie = new Categorie;
        }
        $form = $this->createForm(CategorieType::class, $categorie);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $categorie->setSlug(strtolower($this->slug->slug($categorie->getNom())));
            $this->manager->persist($categorie);
            $this->manager->flush();
            $this->addFlash('success', 'Categorie bien enregistrer');
            return $this->redirectToRoute('categorie');
        }
        $categories = $this->repoCat->findAll();
        return $this->render('admin/categorie.html.twig', [
            'form' => $form->createView(),
            'categories' => $categories
        ]);
    }



    #[Route('/utilisateurs/admin/categorie/supp/{id}', name: 'delete-categorie')]
    public function suppressionCategorie($id)
    {
        $categorie = $this->repoCat->find($id);
        $this->manager->remove($categorie);
        $this->manager->flush();
        $this->addFlash('success', 'categorie bien supprimer');
        return $this->redirectToRoute('categorie');
    }
}
