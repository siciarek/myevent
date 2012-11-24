<?php
// src/MyApp/UserBundle/DataFixtures/ORM/LoadUserData.php

namespace MyApp\UserBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use MyApp\UserBundle\Entity\Group;

class LoadGroupData extends AbstractFixture implements OrderedFixtureInterface
{

    public function getOrder()
    {
        return 1; // the order in which fixtures will be loaded
    }

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $objs = array(
            array(
                "name" => "sysadmins",
                "description" => "System administrators",
            ),
            array(
                "name" => "owners",
                "description" => "Account owners",
            ),
            array(
                "name" => "users",
                "description" => "Regular users",
            ),
        );

        foreach ($objs as $o) {
            $obj = new Group($o["name"]);
            $obj->setDescription($o["description"]);
            $manager->persist($obj);
            $manager->flush();
            $this->addReference($o["name"], $obj);
        }

    }
}