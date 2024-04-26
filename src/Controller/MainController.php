<?php

namespace App\Controller;

use App\Repository\CalendarRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MainController extends AbstractController
{
    #[Route('/', name: 'main')]
    public function index(calendarRepository $calendar): Response
    {
        $events = $calendar->findAll();
        //dd($events);

        $rdvs = [];

        foreach ($events as $event){
            $rdvs[] = [
                'id'=>$event->getId(),
                'start'=>$event->getStart()->format('Y-m-d H:i:s'),
                'end'=>$event->getEnd()->format('Y-m-d H:i:s'),
                'title'=>$event->getTitle(),
                'description'=>$event->getDescription(),
                'allDay'=>$event->isAllDay(),
                'backgroundColor'=>$event->getBackgroundColor(),
                'borderColor'=>$event->getBorderColor(),
                'textColor'=>$event->getTextColor(),
                ];
        }

        $data = json_encode($rdvs);

return $this->render('main/index.html.twig', compact('data'));
    }
}
