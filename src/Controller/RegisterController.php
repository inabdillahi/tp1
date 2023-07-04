<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class RegisterController extends AbstractController
{
    protected $manager;
    protected $encode;
    public function __construct(EntityManagerInterface $manager, UserPasswordHasherInterface $encode)
    {
        $this->manager = $manager;
        $this->encode = $encode;
    }


    #[Route('/register', name: 'register')]
    public function register(Request $request): Response
    {
        $user = new User;
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user->setRoles(['ROLE_ADMIN']);
            $user->setPassword($this->encode->hashPassword($user, $user->getPassword()));
            $this->manager->persist($user);
            $this->manager->flush();
            $this->addFlash('success', 'Utilisateur bien inscrit');
            return $this->redirectToRoute('register');
        }
        return $this->render('register/register.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
