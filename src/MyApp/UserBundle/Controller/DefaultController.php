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
     * @Route("/public.html", name="_public")
     * @Template()
     */
    public function publicAction()
    {
        return array("title" => "Public page");
    }

    /**
     * @Route("/secured.html", name="_secured")
     * @Template()
     */
    public function securedAction()
    {
        return array("title" => "Secured page");
    }

    /**
     * @Route("/editor.html", name="_editor")
     * @Template()
     */
    public function editorAction()
    {
        return array("title" => "Editor");
    }

    public function getTokenAction()
    {
        return new Response($this->container->get('form.csrf_provider')
            ->generateCsrfToken('authenticate'));
    }
}
