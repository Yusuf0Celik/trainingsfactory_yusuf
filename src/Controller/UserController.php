<?php

namespace App\Controller;

use App\Entity\Lesson;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[IsGranted('ROLE_USER')]
class UserController extends AbstractController
{
    #[Route('/acount', name: 'app_account')]
    public function account(EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        $lessons = $entityManager->getRepository(User::class)->find($user);
        $lessons->getLessons();
//        dd($lessons->getLessons());
        return $this->render('user/account.html.twig', [
            'lessons' => $lessons,
        ]);
    }

    #[Route('/lessons/{date}', name: 'app_lessons')]
    public function lessons($date, EntityManagerInterface $entityManager): Response
    {
        $current = new \DateTime($date);
        $lessons = $entityManager->getRepository(Lesson::class)->findBy(['date' => $current]);
        $user = $this->getUser();

//        $lessons->getUsers($user);

        return $this->render('user/lessons.html.twig', [
            'lessons' => $lessons,
        ]);
    }

    #[Route('/lesson/signin/{id}', name: 'app_lesson_signing')]
    public function lessonSigning($id, EntityManagerInterface $entityManager, Request $request): Response
    {
        $user = $this->getUser();
        $lesson = $entityManager->getRepository(Lesson::class)->find($id);
        $user->addLesson($lesson);
        $entityManager->flush();

        return $this->redirectToRoute('app_lessons', ['date' => date('Y-m-d')]);
    }

    #[Route('/lesson/signout/{id}', name: 'app_lesson_signing_out')]
    public function lessonUnsigning($id, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        $lesson = $entityManager->getRepository(Lesson::class)->find($id);

        $user->removeLesson($lesson);
        $entityManager->flush();

        return $this->redirectToRoute('app_lessons', [
            'date' => date('Y-m-d'),
        ]);
    }
}
