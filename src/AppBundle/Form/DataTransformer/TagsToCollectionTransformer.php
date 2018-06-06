<?php
/**
 * Created by PhpStorm.
 * User: aragorn
 * Date: 06/06/18
 * Time: 14:58
 */

namespace AppBundle\Form\DataTransformer;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\DataTransformerInterface;
use Doctrine\Common\Collections\ArrayCollection;

class TagsToCollectionTransformer implements DataTransformerInterface
{
    private $manager;

    public function __construct(ObjectManager $manager)
    {
        $this->manager = $manager;
    }

    public function transform($tags)
    {
        return $tags;
    }

    public function reverseTransform($tags)
    {
        $tagCollection = new ArrayCollection();

        $tagsRepository = $this->manager
            ->getRepository('AppBundle:Tag');

        foreach ($tags as $tag) {
            $tagInRepo = $tagsRepository->findOneByLabel($tag->getLabel());

            if ($tagInRepo !== null) {
                $tagCollection->add($tagInRepo);
            } else {
                $tagCollection->add($tag);
            }
        }

        return $tagCollection;
    }
}
