<?php

namespace App\Controller;

use App\Entity\Lesson;
use App\Form\AddLessonType;
use App\Form\MakeLessonsType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Date;

class InstructorController extends AbstractController
{
    #[Route('/dashboard/lesson/{date}', name: 'app_dashboard_lesson')]
    public function appDashboardLesson($date, EntityManagerInterface $entityManager): Response
    {
        $current=new \DateTime($date);
        $lessons = $entityManager->getRepository(Lesson::class)->findBY(['date'=>$current]);

        return $this->render('instructor/dashboard_lesson.html.twig', [
             'lessons' => $lessons,
        ]);
    }

    #[Route('/dashboard/add/lesson', name: 'app_dashboard_lesson_add')]
    public function appDashboardLessonAdd(EntityManagerInterface $entityManager, Request $request): Response
    {
        $lesson = new Lesson();
        $form = $this->createForm(AddLessonType::class, $lesson);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($lesson);
            $entityManager->flush();
            return $this->redirectToRoute('app_dashboard_lesson', ['date' => date('Y-m-d')]);
        }

        return $this->render('instructor/dashboard_lesson_add.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
