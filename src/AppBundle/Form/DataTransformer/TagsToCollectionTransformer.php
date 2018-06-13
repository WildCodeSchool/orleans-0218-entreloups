<?php
/**
 * Created by PhpStorm.
 * User: aragorn
 * Date: 06/06/18
 * Time: 14:58
 */

namespace AppBundle\Form\DataTransformer;

use AppBundle\Entity\Tag;
use AppBundle\Repository\TagRepository;
use Symfony\Component\Form\DataTransformerInterface;

class TagsToCollectionTransformer implements DataTransformerInterface
{
    /**
     * @var TagRepository
     */
    private $tagRepository;

    public function __construct(TagRepository $tagRepository)
    {
        $this->tagRepository = $tagRepository;
    }

    public function transform($value): string
    {
        return implode(', ', $value);
    }

    public function reverseTransform($value): array
    {
        $names = array_unique(array_filter(array_map('trim', explode(',', $value))));

        $tags = $this->tagRepository->findBy([
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
