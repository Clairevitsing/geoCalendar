<?php


namespace App\Controller;

use App\Entity\Calendar;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class ApiController extends AbstractController
{
    #[Route('/api', name: 'app_api')]
    public function index(): Response
    {
        return $this->render('api/index.html.twig', [
            'controller_name' => 'ApiController',
        ]);
    }

    #[Route('/api/{id}/edit', name: 'api_event_edit', methods: ['PUT'])]
    public function majEvent(?Calendar $calendar, Request $request, EntityManagerInterface $em): Response
    {
        $data = json_decode($request->getContent(), true);

        if (!$data) {
            return new JsonResponse('Invalid JSON', 400);
        }

        if (
            isset($data['title'], $data['start'], $data['description'], $data['backgroundColor'], $data['borderColor'], $data['textColor']) &&
            !empty($data['title']) && !empty($data['start']) && !empty($data['description']) &&
            !empty($data['backgroundColor']) && !empty($data['borderColor']) && !empty($data['textColor'])
        ) {
            $statusCode = $calendar ? 200 : 201;
            $calendar = $calendar ?? new Calendar();

            $calendar->setTitle($data['title']);
            $calendar->setDescription($data['description']);
            $calendar->setStart(new DateTime($data['start']));
            $calendar->setEnd(new DateTime($data['allDay'] ? $data['start'] : $data['end']));
            $calendar->setAllDay($data['allDay']);
            $calendar->setBackgroundColor($data['backgroundColor']);
            $calendar->setBorderColor($data['borderColor']);
            $calendar->setTextColor($data['textColor']);

            $em->persist($calendar);
            $em->flush();

            return new JsonResponse('OK', $statusCode);
        } else {
            return new JsonResponse('Incomplete data', 400);
        }
    }
}


