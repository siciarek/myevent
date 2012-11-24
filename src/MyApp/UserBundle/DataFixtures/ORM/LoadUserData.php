<?php
// src/MyApp/UserBundle/DataFixtures/ORM/LoadUserData.php

namespace MyApp\UserBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use MyApp\UserBundle\Entity\User;

class LoadUserData extends AbstractFixture implements OrderedFixtureInterface
{
    public function getOrder()
    {
        return 2; // the order in which fixtures will be loaded
    }

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $om)
    {
        $password = "helloworld";

        $objs = array(
            array(
                "username"    => "siciarek",
                "password"    => $password,
                "first_name"  => "Jacek",
                "last_name"   => "Siciarek",
                "description" => "My App Developer",
                "email"       => "siciarek@gmail.com",
                "group"       => "owners",
            ),
            array(
                "username"    => "asiciarek",
                "password"    => $password,
                "first_name"  => "Anna",
                "last_name"   => "Siciarek",
                "description" => "The Wife of My App Developer",
                "email"       => "anna_siciarek@o2.pl",
                "group"       => "owners",
            ),
        );

        foreach ($objs as $o) {
            $obj = new User();
            $obj->setUsername($o["username"]);
            $obj->setFirstName($o["first_name"]);
            $obj->setLastName($o["last_name"]);
            $obj->setDescription($o["description"]);
            $obj->setEmail($o["email"]);
            $obj->setPlainPassword($o["password"]);
            $obj->setEnabled(true);
            $obj->setSuperAdmin(true);
            $obj->addGroup($this->getReference($o["group"]));
            $om->persist($obj);
            $this->addReference($o["username"], $obj);
        }

        $om->flush();

    }
}