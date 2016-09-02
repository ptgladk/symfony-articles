<?php

namespace AppBundle\Serializer\Normalizer;

use AppBundle\Entity\Article;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class ArticleNormalizer implements NormalizerInterface
{
    /**
     * @param \AppBundle\Entity\Article $object
     * @param string $format
     * @param array $context
     *
     * @return array
     */
    public function normalize($object, $format = null, array $context = array())
    {
        $user = $object->getUser();
        $result = array(
            'id' => $object->getId(),
            'title' => $object->getTitle(),
            'description' => $object->getDescription(),
            'content' => $object->getContent(),
            'countInFavorites' => $object->getCountInFavorites(),
            'isFavorite' => $object->getIsFavorite(),
            'user' => array(
                'id' => $user->getId(),
                'username' => $user->getUsername()
            )
        );
        return $result;
    }

    /**
     * {@inheritdoc}
     */
    public function supportsNormalization($data, $format = null)
    {
        return $data instanceof Article;
    }
}
