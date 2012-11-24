<?php

namespace MyApp\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="_homepage")
     * @Template()
     */
    public function indexAction()
    {
        return array();
    }

    /**
     * @Route("/events-list.html", name="_events_list")
     * @Template()
     */
    public function eventsListAction()
    {
        return array("title" => "Events List");
    }

    /**
     * @Route("/initiate-event.html", name="_initiate_event")
     * @Template()
     */
    public function initiateEventAction()
    {
        return array("title" => "Initiate Event");
    }

    /**
     * @Route("/participants.html", name="_participants")
     * @Template()
     */
    public function participantsAction()
    {
        return array("title" => "Participants");
    }

    /**
     * @Route("/my-settings.html", name="_my_settings")
     * @Template()
     */
    public function mySettingsAction()
    {
        return array("title" => "My Settings");
    }

    public function getTokenAction()
    {
        return new Response($this->container->get('form.csrf_provider')
            ->generateCsrfToken('authenticate'));
    }
}
