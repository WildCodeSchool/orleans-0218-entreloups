<?php
/**
 * Created by PhpStorm.
 * User: aragorn
 * Date: 06/06/18
 * Time: 14:58
 */

namespace AppBundle\Form\DataTransformer;

use AppBundle\Entity\Tag;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\DataTransformerInterface;

class TagsToCollectionTransformer implements DataTransformerInterface
{
    /**
     * @var EntityManager
     */
    private $manager;

    public function __construct(EntityManager $manager)
    {
        $this->manager = $manager;
    }

    public function transform($value): string
    {

        return implode(', ', $value);
    }

    public function reverseTransform($value): array
    {
        $names = array_unique(array_filter(array_map('trim', explode(',', $value))));

        $tags = $this->manager->getRepository('AppBundle:Tag')->findBy([
            'label' => $names
        ]);

        $newNames = array_diff($names, $tags);

        foreach ($newNames as $name) {
            $tag = new Tag();
            $tag->setLabel($name);
            $tags[] = $tag;
        }

        return $tags;
    }
}
