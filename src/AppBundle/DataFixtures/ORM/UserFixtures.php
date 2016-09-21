<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\User;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class UserFixtures extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setUsername('admin');
        $user->setPassword('123');
        $user->setEmail('admin@test.com');
        $user->setRole(User::ROLE_ADMIN);
        $manager->persist($user);
        $this->addReference('admin', $user);

        $user = new User();
        $user->setUsername('user');
        $user->setPassword('123');
        $user->setEmail('user@test.com');
        $user->setRole(User::ROLE_USER);
        $manager->persist($user);
        $this->addReference('user', $user);

        $manager->flush();
    }

    function getOrder()
    {
        return 1;
    }
}
