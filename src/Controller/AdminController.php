<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\DeleteUserType;
use App\Form\EditUserType;
use App\Form\RegistrationFormType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[IsGranted("ROLE_ADMIN")]
class AdminController extends AbstractController
{
    #[Route('/dashboard', name: 'app_dashboard')]
    public function Dashboard(): Response
    {
        return $this->render('admin/dashboard.html.twig');
    }

    #[Route('/dashboard/users', name: 'app_dashboard_users')]
    public function DashboardUsers(UserRepository $userRepository): Response
    {
        $users = $userRepository->findAll();

        return $this->render('admin/dashboard_users.html.twig', [
            'users' => $users,
        ]);
    }

    #[Route('/dashboard/edit/user/{id}', name: 'app_dashboard_edit')]
    public function UserEdit($id, EntityManagerInterface $entityManager, Request $request): Response
    {
        $user = $entityManager->getRepository(User::class)->find($id);

        $form = $this->createForm(EditUserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($user);
            $entityManager->flush();
            $this->redirectToRoute('app_dashboard_users');
        }

        return $this->render('admin/dashboard_edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/dashboard/delete/user/{id}', name: 'app_dashboard_delete')]
    public function UserDelete($id, EntityManagerInterface $entityManager, Request $request): Response
    {
        $user = $entityManager->getRepository(User::class)->find($id);

        $form = $this->createForm(DeleteUserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->remove($user);
            $entityManager->flush();
            $this->redirectToRoute('app_dashboard_users');
        }

        return $this->render('admin/dashboard_delete.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/dashboard/training', name: 'app_dashboard_training')]
    public function DashboardTraining(): Response
    {
        return $this->render('admin/dashboard_training.html.twig');
    }
}