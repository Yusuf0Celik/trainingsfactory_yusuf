<?php

namespace App\Controller;

use App\Entity\Lesson;
use App\Entity\UserLesson;
use App\Form\LessonSigningType;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[IsGranted('ROLE_USER')]
class UserController extends AbstractController
{
    #[Route('/lessons/{date}', name: 'app_lessons')]
    public function lessons($date, EntityManagerInterface $entityManager): Response
    {
        $userId = $this->getUser()->getId();
//        dd($userId);
        $current = new \DateTime($date);
        $lessons = $entityManager->getRepository(Lesson::class)->findBy(['date' => $current]);

        return $this->render('user/lessons.html.twig', [
            'lessons' => $lessons,
        ]);
    }

    #[Route('/lesson/{id}', name: 'app_lesson')]
    public function lessonSigning($id, EntityManagerInterface $entityManager, Request $request): Response
    {
        $user = $this->getUser();
        $lesson = $entityManager->getRepository(Lesson::class)->find($id);
        $userLessons = $entityManager->getRepository(UserLesson::class)->findAll();

        $userLessonUser = $entityManager->getRepository(UserLesson::class)->findBy(['user' => $user]);
        $userLessonLesson = $entityManager->getRepository(UserLesson::class)->findBy(['lesson' => $lesson]);

        if (count($userLessonLesson) >= 1 && count($userLessonUser) >= 1) {
            return $this->redirectToRoute('app_lessons', ['date' => date('Y-m-d')]);
        } else {
            $userLesson = new UserLesson();
            $form = $this->createForm(LessonSigningType::class, $userLesson);
            $form->handleRequest($request);
            $userLesson->setLesson($lesson);
            $userLesson->setUser($user);

            $entityManager->persist($userLesson);
            $entityManager->flush();
        }
        return $this->redirectToRoute('app_lessons', ['date' => date('Y-m-d')]);
    }
}
