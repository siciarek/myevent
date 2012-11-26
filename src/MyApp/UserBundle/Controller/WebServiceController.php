<?php

namespace MyApp\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\Query;

use MyApp\UserBundle\Entity as E;
use MyApp\UserBundle\Logic\Encoder;


class WebServiceController extends Controller
{
    private $frames = array();

    public function emailAction()
    {
        $frame = array();
        $data = array();

        try {
            $appname = $this->container->getParameter('app_name');
            $username = $this->getUser()->getFirstName() . " " . $this->getUser()->getLastName();
            $description = "Impreza gwiazdkowa dla naszych uczniów";

            $subject = sprintf("%s [%s] %s", $appname, $username, $description);

            $message = $this->renderView('MyAppUserBundle:Emails:event.html.twig',
                array(
                    "username"    => $username,
                    "gender"      => "Pana",
                    "description" => $description,
                )
            );

            $plaintext = strip_tags($message);


            $data[] = $subject;
            $data[] = $message;
            $data[] = $plaintext;

            $message = \Swift_Message::newInstance()
                ->setSubject($subject)
                ->setFrom('siciarek@gmail.com')
                ->setTo('j.siciarek@sescom.pl')
                ->setBody($message, 'text/html')
                ->addPart($plaintext, 'text/plain');

            $data[] = $this->get('mailer')->send($message);

            $frame = $this->frames["ok"];
            $frame["data"] = $data;
        } catch (\Exception $e) {
            $frame = $this->frames["error"];
            $frame["msg"] = $e->getMessage();
            $frame["data"]["errno"] = $e->getCode();
        }

        $json = json_encode($frame);
        return new Response($json);
    }

    public function createEventAction(Request $request)
    {
        $frame = array();
        $data = array();
        $json = $request->query->get('json');

        try {
            $input = json_decode($json, true);
            $frame = $this->frames["ok"];
            $frame["msg"] = "New event has been created successfuly";
            $frame["data"] = $input["data"];
        } catch (\Exception $e) {
            $frame = $this->frames["error"];
            $frame["msg"] = $e->getMessage();
            $frame["data"]["errno"] = $e->getCode();
        }

        return new Response(json_encode($frame));
    }

    public function participantsListAction()
    {
        $frame = array();
        $data = array();

        try {
            $data = array(
                array(
                    "id"                  => 234,
                    "first_name"          => "Jan",
                    "last_name"           => "Kowalski",
                    "email"               => "siciarek@gmail.com",
                    "gender"              => "male",
                    "city"                => "Gdynia",
                    "region"              => "pomorskie",
                    "address"             => "Portowa 9",
                    "description_private" => "Spoko gość",
                    "description_public"  => "Tata Krysi",
                ),
                array(
                    "id"                  => 235,
                    "first_name"          => "Michał",
                    "last_name"           => "Waśniewski",
                    "email"               => "siciarek@gmail.com",
                    "gender"              => "male",
                    "city"                => "Gdynia",
                    "region"              => "pomorskie",
                    "address"             => "Miła 2",
                    "description_private" => "Spoko gość",
                    "description_public"  => "Tata Urszulki",
                ),
                array(
                    "id"                  => 236,
                    "first_name"          => "Janina",
                    "last_name"           => "Widelec",
                    "email"               => "siciarek@gmail.com",
                    "gender"              => "female",
                    "city"                => "Rumia",
                    "region"              => "pomorskie",
                    "address"             => "Danuty 34",
                    "description_private" => "Na nią lepiej uważać",
                    "description_public"  => "Mama Jasia",
                ),
                array(
                    "id"                  => 237,
                    "first_name"          => "Julia",
                    "last_name"           => "Kamińska",
                    "email"               => "siciarek@gmail.com",
                    "gender"              => "female",
                    "city"                => "Wejherowo",
                    "region"              => "pomorskie",
                    "address"             => "Aleja Morska 2",
                    "description_private" => "Ona jest OK",
                    "description_public"  => "Mama Lucynki",
                ),
            );

            $frame = $this->frames["data"];
            $frame["msg"] = "Participants list of user #" . $this->getUser()->getId();
            $frame["totalCount"] = count($data);
            $frame["data"] = $data;
        } catch (\Exception $e) {
            $frame = $this->frames["error"];
            $frame["msg"] = $e->getMessage();
            $frame["data"]["errno"] = $e->getCode();
        }

        $json = json_encode($frame);
        return new Response($json);
    }

    public function preExecute()
    {
        $this->frames["ok"] = array(
            "success"  => true,
            "type"     => "info",
            "datetime" => date("Y-m-d H:i:s"),
            "msg"      => "OK",
            "data"     => array(),
        );

        $this->frames["data"] = array(
            "success"    => true,
            "type"       => "data",
            "datetime"   => date("Y-m-d H:i:s"),
            "msg"        => "Data",
            "totalCount" => 0,
            "data"       => array(),
        );

        $this->frames["error"] = array(
            "success"  => true,
            "type"     => "error",
            "datetime" => date("Y-m-d H:i:s"),
            "msg"      => "Unexpected Exception",
            "data"     => array(),
        );
    }
}
