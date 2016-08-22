<?php

namespace AppBundle\Security;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;

class ApiKeyUserProvider implements UserProviderInterface
{
    protected $em;

    /**
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->em = $entityManager;
    }

    /**
     * @param $apiKey
     * @return string|null
     */
    public function getUsernameForApiKey($apiKey)
    {
        $user = $this->em->getRepository('AppBundle:User')->findOneBy(array(
            'token' => $apiKey,
            'active' => true
        ));

        return $user ? $user->getUsername() : null;
    }

    /**
     * @param string $username
     * @return \AppBundle\Entity\User|null
     */
    public function loadUserByUsername($username)
    {
        $user = $this->em->getRepository('AppBundle:User')->findOneBy(array(
            'username' => $username,
            'active' => true
        ));

        return $user ? $user : null;
    }

    public function refreshUser(UserInterface $user)
    {
        throw new UnsupportedUserException();
    }

    public function supportsClass($class)
    {
        return 'AppBundle\Entity\User' === $class;
    }
}
