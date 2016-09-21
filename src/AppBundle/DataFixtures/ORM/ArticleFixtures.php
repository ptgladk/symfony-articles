<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Article;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class ArticleFixtures extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $article = new Article();
        $article->setTitle('Title 1');
        $article->setDescription('Description 1');
        $article->setContent('Content 1');
        $article->setUser($this->getReference('admin'));
        $manager->persist($article);

        $article = new Article();
        $article->setTitle('Title 2');
        $article->setDescription('Description 2');
        $article->setContent('Content 2');
        $article->setUser($this->getReference('admin'));
        $manager->persist($article);

        $article = new Article();
        $article->setTitle('Title 3');
        $article->setDescription('Description 3');
        $article->setContent('Content 3');
        $article->setUser($this->getReference('user'));
        $manager->persist($article);

        $manager->flush();
    }

    function getOrder()
    {
        return 2;
    }
}
