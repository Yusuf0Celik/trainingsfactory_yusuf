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
    public function appDashboardLesson($date, EntityManagerInterface $entityManager): Response
    {
        $lessons = $entityManager->getRepository(Lesson::class)->findBy(['time'|date("Y-m-d") => $date]);
        dd($date|date("Y-m-d"));
        return $this->render('instructor/dashboard_lesson.html.twig');
    }

    #[Route('/dashboard/add/lesson', name: 'app_dashboard_lesson_add')]
    public function appDashboardLessonAdd(EntityManagerInterface $entityManager, Request $request): Response
    {
        $lesson = new Lesson();
        $form = $this->createForm(MakeLessonsType::class, $lesson);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($lesson);
            $entityManager->flush();
            return $this->redirectToRoute('app_dashboard_lesson');
        }

        return $this->render('instructor/dashboard_lesson_add.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
