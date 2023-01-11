<?php

namespace App\Controller;

use App\Entity\Sport;
use App\Entity\User;
use App\Form\AddSportType;
use App\Form\DeleteTrainingType;
use App\Form\DeleteUserType;
use App\Form\EditUserType;
use App\Form\RegistrationFormType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

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
            return $this->redirectToRoute('app_dashboard_users');
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
            return $this->redirectToRoute('app_dashboard_users');
        }

        return $this->render('admin/dashboard_delete.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/dashboard/training', name: 'app_dashboard_training')]
    public function DashboardTraining(EntityManagerInterface $entityManager): Response
    {
        $sports = $entityManager->getRepository(Sport::class)->findAll();

        return $this->render('admin/dashboard_training.html.twig', [
            'sports' => $sports
        ]);
    }

    #[Route('/dashboard/training/add', name: 'app_dashboard_training_add')]
    public function dashboardTrainingAdd(EntityManagerInterface $entityManager, Request $request): Response
    {
        $sport = new Sport();
        $form = $this->createForm(AddSportType::class, $sport);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $imageFile = $form->get('image')->getData();
            if ($imageFile) {
                $newFilename = 'img/' . uniqid() . '.' . $imageFile->guessExtension();
                try {
                    $imageFile->move(
                        $this->getParameter('kernel.project_dir') . '/public/img',
                        $newFilename
                    );
                } catch (FileException $e) {
                    error_log($e->getMessage());
                }
                $sport->setImage($newFilename);

                $entityManager->persist($sport);
                $entityManager->flush();
                return $this->redirectToRoute('app_dashboard_training');
            }
        }
        return $this->render('admin/dashboard_training_add.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/dashboard/training/delete/{id}', name: 'app_dashboard_training_delete')]
    public function dashboardTrainingDelete($id, EntityManagerInterface $entityManager, Request $request, Filesystem $filesystem): Response
    {
        $sport = $entityManager->getRepository(Sport::class)->find($id);
        $form = $this->createForm(DeleteTrainingType::class, $sport);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $projectDir = $this->getParameter('kernel.project_dir');
            $filesystem->remove($projectDir . '/public/img/' . $sport->getImage());

            $entityManager->remove($sport);
            $entityManager->flush();
            return $this->redirectToRoute('app_dashboard_training');
        }

        return $this->render('admin/dashboard_training_delete.html.twig', [
            'form' => $form->createView(),
            'sport' => $sport,
        ]);
    }
}