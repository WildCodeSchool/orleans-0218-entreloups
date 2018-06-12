<?php

namespace AppBundle\Tests\Form\DataTransformer;

use AppBundle\Entity\Tag;
use AppBundle\Form\DataTransformer\TagsToCollectionTransformer;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityRepository;
use PHPUnit\Framework\TestCase;

class TagsToCollectionTransformerTest extends TestCase
{
    public function testUseAlreadyDefinedTag()
    {
        $tag = new Tag();
        $tag->setLabel('Test1');

        $transformer = $this->getMockedTransformer([$tag]);

        $tags = $transformer->reverseTransform('Test1, Test2, Test3');
        $this->assertCount(3, $tags);
        $this->assertSame($tag, $tags[0]);
    }

    public function testRemoveEmptyTag()
    {
        $transformer = $this->getMockedTransformer();

        $tags = $transformer->reverseTransform('Test1, Test2, Test3, , ,');
        $this->assertCount(3, $tags);
        $this->assertSame('Test2', $tags[1]->getLabel());
    }

    public function testRemoveDuplicateTag()
    {
        $transformer = $this->getMockedTransformer();

        $tags = $transformer->reverseTransform('Test1, Test1, Test1, , ,');
        $this->assertCount(1, $tags);
    }

    private function getMockedTransformer($result = [])
    {
        $tagRepository = $this->getMockBuilder(EntityRepository::class)
            ->disableOriginalConstructor()
            ->getMock();

        $tagRepository->expects($this->any())
            ->method('findBy')
            ->will($this->returnValue($result));

        $entityManager = $this->getMockBuilder(ObjectManager::class)
            ->disableOriginalConstructor()
            ->getMock();

        $entityManager->expects($this->any())
            ->method('getRepository')
            ->will($this->returnValue($tagRepository));

        return new TagsToCollectionTransformer($entityManager);
    }
}
