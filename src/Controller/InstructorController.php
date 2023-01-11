<?php

namespace App\Controller;

use App\Entity\Lesson;
use App\Form\MakeLessonsType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class InstructorController extends AbstractController
{
    #[Route('/dashboard/lesson/{date}', name: 'app_dashboard_lesson')]
    public function appDashboardLesson($date, EntityManagerInterface $entityManager, Request $request): Response
    {
//        $lesson = new Lesson();
//        $form = $this->createForm(MakeLessonsType::class, $lesson);
//        $form->handleRequest($request);
//
//        if ($form->isSubmitted() && $form->isValid()) {
//            $entityManager->persist($lesson);
//            $entityManager->flush();
//            return $this->redirectToRoute('app_dashboard');
//        }
        $day = 1;

        return $this->render('instructor/dashboard_lesson.html.twig', [
            'day' => $day,
        ]);
    }

    #[Route('/dashboard/lesson/add', name: 'app_dashboard_lesson_add')]
    public function appDashboardLessonAdd(EntityManagerInterface $entityManager, Request $request): Response
    {
        $lesson = new Lesson();
        $form = $this->createForm(MakeLessonsType::class, $lesson);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($lesson);
            $entityManager->flush();
            return $this->redirectToRoute('app_dashboard');
        }

        return $this->render('instructor/dashboard_lesson_add.html.twig');
    }
}
