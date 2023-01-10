<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
//        dd($users);
        return $this->render('admin/dashboard_users.html.twig', [
            'users' => $users,
        ]);
    }

    #[Route('/dashboard/training', name: 'app_dashboard_training')]
    public function DashboardTraining(): Response
    {
        return $this->render('admin/dashboard_training.html.twig');
    }
}