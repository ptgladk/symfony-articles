<?php

namespace AppBundle\Listener;

use AppBundle\Entity\Article;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;

class ArticleListener
{
    protected $container;

    /**
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * @param LifecycleEventArgs $eventArgs
     */
    public function postLoad(LifecycleEventArgs $eventArgs)
    {
        $object = $eventArgs->getObject();

        if ($object instanceof Article) {
            // How many times article was added in favorites
            $em = $this->container->get('doctrine.orm.entity_manager');
            $countInFavorites = (int)$em->getRepository('AppBundle:Article')->getFavoriteCount($object);
            $object->setCountInFavorites($countInFavorites);

            // Is this article in favorites for user
            $request = $this->container->get('request_stack')->getCurrentRequest();
            $token = $request->headers->get('authorization');
            if ($token) {
                $user = $em->getRepository('AppBundle:User')->findOneBy(array(
                    'token' => $token,
                    'active' => true
                ));

                if ($em->getRepository('AppBundle:Favorite')->findOneBy(array(
                    'user' => $user,
                    'article' => $object
                ))) {
                    $object->setIsFavorite(true);
                }
            }
        }
    }
}
