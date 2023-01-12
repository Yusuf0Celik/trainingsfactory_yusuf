<?php

namespace App\Controller;

use App\Entity\Lesson;
use App\Form\AddLessonType;
use App\Form\DeleteLessonType;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[IsGranted('ROLE_INSTRUCTOR')]
class InstructorController extends AbstractController
{
    #[Route('/dashboard/lesson/{date}', name: 'app_dashboard_lesson')]
    public function appDashboardLesson($date, EntityManagerInterface $entityManager): Response
    {
        $current = new \DateTime($date);
        $lessons = $entityManager->getRepository(Lesson::class)->findBY(['date' => $current]);

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

    #[Route('/dashboard/delete/lesson/{id}', name: 'app_dashboard_lesson_delete')]
    public function appDashboardLessonDelete($id, EntityManagerInterface $entityManager, Request $request): Response
    {
        $lesson = $entityManager->getRepository(Lesson::class)->find($id);
        $form = $this->createForm(DeleteLessonType::class, $lesson);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->remove($lesson);
            $entityManager->flush();
            return $this->redirectToRoute('app_dashboard_lesson', ['date' => date('Y-m-d')]);
        }

        return $this->render('instructor/dashboard_lesson_delete.html.twig', [
            'form' => $form->createView(),
            'lesson' => $lesson,
        ]);
    }
}
