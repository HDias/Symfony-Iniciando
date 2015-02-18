<?php

namespace HD\UserBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use HD\UserBundle\Entity\User;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoadUser implements 
    FixtureInterface,
    ContainerAwareInterface
{

    private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setUsername('admin');
        $user->setPassword($this->encodedPassword($user, 'admin'));
        $user->setEmail('admin@email.com');
        $user->setRoles(array('ROLE_ADMIN'));


        $manager->persist($user);

        for ($i = 0; $i < 3; $i++) {
            $user = new User();
            $user->setUsername('User' . $i);
            $user->setEmail('user' . $i . '@email.com');
            $user->setPassword($this->encodedPassword($user, '123' . $i));

            $manager->persist($user);
        }

        $manager->flush();
    }

    /**
     * 
     * http://symfony.com/doc/current/book/security.html#security-encoding-password
     */
    public function encodedPassword($user, $plainPassword)
    {
        $encoder = $this->container
            ->get('security.password_encoder');

        return $encoder->encodePassword($user, $plainPassword);
    }
}